<?php
namespace Alexya\Localization;

use InvalidArgumentException;

/**
 * Text translator class.
 *
 * The constructor accepts as parameter an associative array
 * containing the language code and the translations.
 * The second parameter is the default locale where text are going to be translated.
 *
 * Example:
 *
 * ```php
 * $translator = new \Alexya\Localization\Translator([
 *     \Alexya\Localization\Locale::ENGLISH => [
 *         "monday"    => "monday",
 *         "thursday"  => "thursday",
 *         "wednesday" => "wednesday",
 *         "tuesday"   => "tuesday",
 *         "friday"    => "friday",
 *         "saturday"  => "saturday",
 *         "sunday"    => "sunday"
 *     ],
 *     \Alexya\Localization\Locale::SPANISH => [
 *         "monday"    => "lunes",
 *         "thursday"  => "martes",
 *         "wednesday" => "miercoles",
 *         "tuesday"   => "jueves",
 *         "friday"    => "viernes",
 *         "saturday"  => "sabado",
 *         "sunday"    => "domingo"
 *     ]
 * ], \Alexya\Localization\Locale::en());
 * ```
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
 * ```php
 * $locale = \Alexya\Localization\Locale::en();
 * $translator = new \Alexya\Localization\Translator([
 *     \Alexya\Localization\Locale::ENGLISH => [
 *         "monday"    => "monday",
 *         "thursday"  => "thursday",
 *         "wednesday" => "wednesday",
 *         "tuesday"   => "tuesday",
 *         "friday"    => "friday",
 *         "saturday"  => "saturday",
 *         "sunday"    => "sunday",
 *
 *         "Today is {day}" => "Today is {day}"
 *     ],
 *     \Alexya\Localization\Locale::SPANISH => [
 *         "monday"    => "lunes",
 *         "thursday"  => "martes",
 *         "wednesday" => "miercoles",
 *         "tuesday"   => "jueves",
 *         "friday"    => "viernes",
 *         "saturday"  => "sabado",
 *         "sunday"    => "domingo",
 *
 *         "Today is {day}" => "Hoy es {day}"
 *     ]
 * ], $locale);
 *
 * // Quick translation
 * $translator->translate("Today is {day}");
 * // Today is {day}
 *
 * // Translation with context
 * $translator->translate("Today is {day}", [
 *     "day" => $translator->translate("monday")
 * ]);
 * // Today is monday
 *
 * // Translation in a specific language
 * $translator->translate("Today is {day}", \Alexya\Localization\Locale::SPANISH);
 * // Hoy es {day}
 *
 * // Translation in a specific language with context
 * $translator->translate("Today is {day}", [
 *     "day" => $translator->translate("monday", \Alexya\Localization\Locale::SPANISH)
 * ], \Alexya\Localization\Locale::SPANISH);
 * // Hoy es lunes
 *
 * // Text that can't be translated
 * $translator->translate("some_text");
 * // some_text
 * ```
 *
 * If the locale isn't specified it will be translated to the locale sent to
 * the method `setDefaultLocale`.
 *
 * For translating texts of a sub-array use a dot (`.`) to link the texts to translate:
 *
 * ```php
 *  $translator = new \Alexya\Localization\Translator([
 *     \Alexya\Localization\Locale::ENGLISH => [
 *         "days" => [
 *             "monday"    => "monday",
 *             "thursday"  => "thursday",
 *             "wednesday" => "wednesday",
 *             "tuesday"   => "tuesday",
 *             "friday"    => "friday",
 *             "saturday"  => "saturday",
 *             "sunday"    => "sunday"
 *         ],
 *         "phrases" => [
 *             "today_is" => "Today is {day}"
 *         ]
 *     ]
 * ]);
 *
 * // Recursive translation
 * $translator->translate("phrases.today_is", [
 *     "day" => $translator->translate("days.monday")
 * ]);
 * // Today is monday
 * ```
 *
 * You can also add more translations to an already specified language with the method `addTranslations`.
 * It accepts as parameter the language code and an array containing the translations to add.
 * If the language code doesn't exist, it will create it.
 *
 * @see Locale For a list of available locales.
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
     * Context wrapper.
     *
     * @var string|array
     */
    private $_contextWrapper = "%";

    /**
     * Default locale.
     *
     * @var Locale
     */
    public $locale;

    /**
     * Available locales to translate.
     *
     * @var array
     */
    public $availableLocales = [];

    /**
     * Constructor.
     *
     * @param array         $translations    Translations array.
     * @param Locale        $locale          Default locale where the texts will be translated (default = `Locale::en()`).
     * @param string|array  $contextWrapper  Default wrapper for context variables.
     */
    public function __construct(array $translations = [], Locale $locale = null, $contextWrapper = "%")
    {
        $this->_translations   = $translations;
        $this->locale          = $locale;
        $this->_contextWrapper = $contextWrapper;

        if($this->locale === null) {
            $this->locale = Locale::get(Locale::ENGLISH);
        }

        $this->_setAvailableLocales();
    }

    /**
     * Sets available locales.
     */
    private function _setAvailableLocales()
    {
        $defaultLocaleExists = false;
        foreach($this->_translations as $key => $val) {
            try {
                $locale = Locale::get($key);

                if($locale->code === $this->locale->code) {
                    $defaultLocaleExists = true;
                }

                $this->availableLocales[] = $locale;
            } catch(InvalidArgumentException $e) {
                // Ignore
            }
        }

        if($defaultLocaleExists) {
            return;
        }

        $this->locale = ($this->availableLocales[0] ?? Locale::get(Locale::ENGLISH));
    }

    /**
     * Sets default locale.
     *
     * @param Locale $locale Default language.
     */
    public function setDefaultLocale(Locale $locale)
    {
        $this->locale = $locale;
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
        $l = $this->locale->code;

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
