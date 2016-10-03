<?php
namespace Alexya\Localization;

/**
 * Text translator class.
 *
 * The constructor accepts as parameter an associative array
 * containing the language code and the translations.
 * Optionally you can send a second parameter being the default language where
 * the texts will be translated.
 * It can also accept a third parameter being the string that will wrap context variables,
 * it can be a string (the start of the string is the same as the end) or an
 * array (the first index is the start of the string and the second index is the ending of the string).
 *
 * Example:
 *
 *     $translator = new \Alexya\Localization\Translator([
 *         "en" => [
 *             "monday"    => "monday",
 *             "thursday"  => "thursday",
 *             "wednesday" => "wednesday",
 *             "tuesday"   => "tuesday",
 *             "friday"    => "friday",
 *             "saturday"  => "saturday",
 *             "sunday"    => "sunday"
 *         ],
 *         "es" => [
 *             "monday"    => "lunes",
 *             "thursday"  => "martes",
 *             "wednesday" => "miercoles",
 *             "tuesday"   => "jueves",
 *             "friday"    => "viernes",
 *             "saturday"  => "sabado",
 *             "sunday"    => "domingo"
 *         ]
 *     ], "en");
 *
 * Once the object has been instantiated you can use the method `translate` to
 * translate a text. It accepts as parameter a string being the text to translate.
 *
 * Optionally you can send an array with the variables to parse or a string with the language
 * code to translate the text, or even both.
 *
 * If the language doesn't exist, the text will be translated to the default language.
 *
 * If the text couldn't be translated, it will return the first parameter.
 *
 * Example:
 *
 *     $translator = new \Alexya\Localization\Translator([
 *         "en" => [
 *             "monday"    => "monday",
 *             "thursday"  => "thursday",
 *             "wednesday" => "wednesday",
 *             "tuesday"   => "tuesday",
 *             "friday"    => "friday",
 *             "saturday"  => "saturday",
 *             "sunday"    => "sunday",
 *
 *             "Today is {day}" => "Today is {day}"
 *         ],
 *         "es" => [
 *             "monday"    => "lunes",
 *             "thursday"  => "martes",
 *             "wednesday" => "miercoles",
 *             "tuesday"   => "jueves",
 *             "friday"    => "viernes",
 *             "saturday"  => "sabado",
 *             "sunday"    => "domingo",
 *
 *             "Today is {day}" => "Hoy es {day}"
 *         ]
 *     ], "en", ["{", "}"]);
 *
 *     // Quick translation
 *     $translator->translate("Today is {day}");
 *     // Today is {day}
 *
 *     // Translation with context
 *     $translator->translate("Today is {day}", [
 *         "day" => $translator->translate("monday")
 *     ]);
 *     // Today is monday
 *
 *     // Translation in a specific language
 *     $translator->translate("Today is {day}", "es");
 *     // Hoy es {day}
 *
 *     // Translation in a specific language with context
 *     $translator->translate("Today is {day}", [
 *         "day" => $translator->translate("monday", "es")
 *     ], "es");
 *     // Hoy es lunes
 *
 *     // Text that can't be translated
 *     $translator->translate("some_text");
 *     // some_text
 *
 * If the language isn't specified it will be translated to the language sent to
 * the method `setDefaultLanguage`.
 *
 * For translating texts of a sub-array use a dot (`.`) to link the texts to translate:
 *
 *     $translator = new \Alexya\Localization\Translator([
 *         "en" => [
 *             "days" => [
 *                 "monday"    => "monday",
 *                 "thursday"  => "thursday",
 *                 "wednesday" => "wednesday",
 *                 "tuesday"   => "tuesday",
 *                 "friday"    => "friday",
 *                 "saturday"  => "saturday",
 *                 "sunday"    => "sunday"
 *             ],
 *             "phrases" => [
 *                 "today_is" => "Today is %day%"
 *             ]
 *         ]
 *     ]);
 *
 *     // Recursive translation
 *     $translator->translate("phrases.today_is", [
 *         "day" => $translator->translate("days.monday")
 *     ]);
 *     // Today is monday
 *
 * You can also add more translations to an already specified language with the method `addTranslations`.
 * It accepts as parameter the language code and an array containing the translations to add.
 * If the language code doesn't exist, it will create it.
 *
 * @author Manulaiko <manulaiko@gmail.com>
 */
class Translator
{
    /**
     * Translation array.
     *
     * @var array
     */
    private $_translations = [];

    /**
     * Default language.
     *
     * @var string
     */
    private $_defaultLanguage = "";

    /**
     * Context wrapper.
     *
     * @var string|array
     */
    private $_contextWrapper = "%";

    /**
     * Constructor.
     *
     * @param array  $translations    Translations array.
     * @param string $defaultLanguage Default language where the texts will be translated (default is `en`).
     * @param array  $contextWrapper  Default wrapper for context variables.
     */
    public function __construct(array $translations = [], string $defaultLanguage = "en", $contextWrapper = "%")
    {
        $this->_translations    = $translations;
        $this->_defaultLanguage = $defaultLanguage;
        $this->_contextWrapper  = $contextWrapper;
    }

    /**
     * Sets default language.
     *
     * @param string $language Default language.
     */
    public function setDefaultLanguage(string $language)
    {
        $this->_defaultLanguage = $language;
    }

    /**
     * Adds new translations.
     *
     * If the language doesn't exist, it will be created.
     *
     * @param string $language     Language code.
     * @param array  $translations Text translations.
     */
    public function addTranslations(string $language, array $translations)
    {
        $currentTranslations = ($this->_translations[$language] ?? []);

        $this->_translations[$language] = array_merge($currentTranslations, $translations);
    }

    /**
     * Translates a text.
     *
     * If the text can't be translated, the parameter `$text` will be returned.
     *
     * @param string       $text     Text to translate.
     * @param array|string $context  Context variables (if is a string it will be interpreted as `$language`).
     * @param string|null  $language Language to translate `$text` (if `null` the default language will be used).
     *
     * @return string Translated text.
     */
    public function translate(string $text, $context = [], $language = null) : string
    {
        // Normalize parameters
        list($text, $context, $language) = $this->_parseParameters($text, $context, $language);

        $translated = ($this->_translations[$language] ?? []);

        // Parse $text to an array now so we can use it's original value later
        foreach(explode(".", $text) as $t) {
            $translated = ($translated[$t] ?? []);

            if(!is_array($translated)) {
                // $translated is not an array
                // This means that we've reached last text translation sub-array
                return $this->_parseContext($translated, $context);
            }
        }

        return $this->_parseContext($text, $context);
    }

    /**
     * Parses the arguments.
     *
     * @param string       $text     Text to translate.
     * @param array|string $context  Context variables (if is a string it will be interpreted as `$language`).
     * @param string|null  $language Language to translate `$text` (if `null` the default language will be used).
     *
     * @return array Parameters in the right order.
     */
    private function _parseParameters($text, $context, $language) : array
    {
        $t = $text;
        $c = [];
        $l = $this->_defaultLanguage;

        if(is_string($context)) {
            $l = $context;
        } else if(is_array($context)) {
            $c = $context;
        }

        if(is_string($language)) {
            $l = $language;
        } else if(is_array($language)) {
            $c = $language;
        }

        return [$t, $c, $l];
    }
    /**
     * Replaces all placeholders in `message` with the placeholders of `context`
     *
     * @param string $message Message to parse
     * @param array  $context Array with placeholders
     *
     * @return string Parsed message
     */
    private function _parseContext(string $message, array $context) : string
    {
        // build a replacement array with braces around the context keys
        $replace = [];
        foreach($context as $key => $val) {
            // check that the value can be casted to string
            if(
                !is_array($val) &&
                (!is_object($val) || method_exists($val, '__toString'))
            ) {
                if(is_array($this->_contextWrapper)) {
                    $key = ($this->_contextWrapper[0] ?? ""). $key .($this->_contextWrapper[1] ?? "");
                } else {
                    $key = $this->_contextWrapper.$key.$this->_contextWrapper;
                }

                $replace[$key] = $val;
            }
        }

        // interpolate replacement values into the message and return
        return strtr($message, $replace);
    }
}
