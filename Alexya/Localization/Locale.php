<?php
namespace Alexya\Localization;
use InvalidArgumentException;

/**
 * Locale class.
 *
 * Represents a locale option.
 *
 * For instancing objects you can use the `get` method:
 *
 * ```php
 * $english = \Alexya\Localization\Locale::get("en");
 * $spanish = \Alexya\Localization\Locale::get("es");
 * ```
 *
 * @author Manulaiko <manulaiko@gmail.com>
 */
class Locale
{
    ///////////////////////////////////
    // Static methods and properties //
    ///////////////////////////////////

    /////////////////////////////
    // Start locales constants //
    /////////////////////////////
    /**
     * Albanian locale.
     *
     * @var string
     */
    const ALBANIAN = "sq";

    /**
     * Arabic locale.
     *
     * @var string
     */
    const ARABIC = "ar";

    /**
     * Belarusian locale.
     *
     * @var string
     */
    const BELARUSIAN = "be";

    /**
     * Bulgarian locale.
     *
     * @var string
     */
    const BULGARIAN = "bg";

    /**
     * Catalan locale.
     *
     * @var string
     */
    const CATALAN = "ca";

    /**
     * Chinese locale.
     *
     * @var string
     */
    const CHINESE = "zh";

    /**
     * Croatian locale.
     *
     * @var string
     */
    const CROATIAN = "hr";

    /**
     * Czech locale.
     *
     * @var string
     */
    const CZECH = "cs";

    /**
     * Danish locale.
     *
     * @var string
     */
    const DANISH = "da";

    /**
     * Dutch locale.
     *
     * @var string
     */
    const DUTCH = "nl";

    /**
     * English locale.
     *
     * @var string
     */
    const ENGLISH = "en";

    /**
     * Stonian locale.
     *
     * @var string
     */
    const ESTONIAN = "et";

    /**
     * Finnish locale.
     *
     * @var string
     */
    const FINNISH = "fi";

    /**
     * French locale.
     *
     * @var string
     */
    const FRENCH = "fr";

    /**
     * Albanian locale.
     *
     * @var string
     */
    const GERMAN = "de";

    /**
     * Greek locale.
     *
     * @var string
     */
    const GREEK = "el";

    /**
     * Hebrew locale.
     *
     * @var string
     */
    const HEBREW = "iw";

    /**
     * Hungarian locale.
     *
     * @var string
     */
    const HUNGARIAN = "hu";

    /**
     * Icelandic locale.
     *
     * @var string
     */
    const ICELANDIC = "is";

    /**
     * Indonesian locale.
     *
     * @var string
     */
    const INDONESIAN = "in";

    /**
     * Irish locale.
     *
     * @var string
     */
    const IRISH = "ga";

    /**
     * Italian locale.
     *
     * @var string
     */
    const ITALIAN = "it";

    /**
     * Japanese locale.
     *
     * @var string
     */
    const JAPANESE = "ja";

    /**
     * Korean locale.
     *
     * @var string
     */
    const KOREAN = "ko";

    /**
     * Latvian locale.
     *
     * @var string
     */
    const LATVIAN = "lv";

    /**
     * Lithuanian locale.
     *
     * @var string
     */
    const LITHUANIAN = "lt";

    /**
     * Macedonian locale.
     *
     * @var string
     */
    const MACEDONIAN = "mk";

    /**
     * Malay locale.
     *
     * @var string
     */
    const MALAY = "ms";

    /**
     * Maltese locale.
     *
     * @var string
     */
    const MALTESE = "mt";

    /**
     * Norwegian locale.
     *
     * @var string
     */
    const NORWEGIAN = "no";

    /**
     * Polish locale.
     *
     * @var string
     */
    const POLISH = "pl";

    /**
     * Portugese locale.
     *
     * @var string
     */
    const PORTUGESE = "pt";

    /**
     * Romanian locale.
     *
     * @var string
     */
    const ROMANIAN = "ro";

    /**
     * Russian locale.
     *
     * @var string
     */
    const RUSSIAN = "ru";

    /**
     * Serbian locale.
     *
     * @var string
     */
    const SERBIAN = "sr";

    /**
     * Slovak locale.
     *
     * @var string
     */
    const SLOVAK = "sk";

    /**
     * Slovenian locale.
     *
     * @var string
     */
    const SLOVENIAN = "sl";

    /**
     * Spanish locale.
     *
     * @var string
     */
    const SPANISH = "es";

    /**
     * Swedish locale.
     *
     * @var string
     */
    const SWEDISH = "sv";

    /**
     * Thai locale.
     *
     * @var string
     */
    const THAI = "th";

    /**
     * Turkish locale.
     *
     * @var string
     */
    const TURKISH = "tr";

    /**
     * Ukranian locale.
     *
     * @var string
     */
    const UKRANIAN = "uk";

    /**
     * Vietnamese locale.
     *
     * @var string
     */
    const VIETNAMESE = "vi";
    ///////////////////////////
    // End locales constants //
    ///////////////////////////

    /**
     * Available locales.
     *
     * @var array
     */
     private static $_locales = [
         Locale::ALBANIAN => [
             "code"       => Locale::ALBANIAN,
             "name"       => "Albanian",
             "nativeName" => "Shqip"
         ],
         Locale::ARABIC => [
             "code"       => Locale::ARABIC,
             "name"       => "Arabic",
             "nativeName" => "العربية"
         ],
         Locale::BELARUSIAN => [
             "code"       => Locale::BELARUSIAN,
             "name"       => "Belarusian",
             "nativeName" => "беларуская мова"
         ],
         Locale::BULGARIAN => [
             "code"       => Locale::BULGARIAN,
             "name"       => "Bulgarian",
             "nativeName" => "български език"
         ],
         Locale::CATALAN => [
             "code"       => Locale::CATALAN,
             "name"       => "Catalan",
             "nativeName" => "català"
         ],
         Locale::CHINESE => [
             "code"       => Locale::CHINESE,
             "name"       => "Chinese",
             "nativeName" => "中文"
         ],
         Locale::CROATIAN => [
             "code"       => Locale::CROATIAN,
             "name"       => "Croatian",
             "nativeName" => "hrvatski jezik"
         ],
         Locale::CZECH => [
             "code"       => Locale::CZECH,
             "name"       => "Czech",
             "nativeName" => "čeština"
         ],
         Locale::DANISH => [
             "code"       => Locale::DANISH,
             "name"       => "Danish",
             "nativeName" => "dansk"
         ],
         Locale::DUTCH => [
             "code"       => Locale::DUTCH,
             "name"       => "Dutch",
             "nativeName" => "Nederlands"
         ],
         Locale::ENGLISH => [
             "code"       => Locale::ENGLISH,
             "name"       => "English",
             "nativeName" => "English"
         ],
         Locale::ESTONIAN => [
             "code"       => Locale::ESTONIAN,
             "name"       => "Estonian",
             "nativeName" => "eesti"
         ],
         Locale::FINNISH => [
             "code"       => Locale::FINNISH,
             "name"       => "Finnish",
             "nativeName" => "suomi"
         ],
         Locale::FRENCH => [
             "code"       => Locale::FRENCH,
             "name"       => "French",
             "nativeName" => "français"
         ],
         Locale::GERMAN => [
             "code"       => Locale::GERMAN,
             "name"       => "German",
             "nativeName" => "Deutsch"
         ],
         Locale::GREEK => [
             "code"       => Locale::GREEK,
             "name"       => "Greek",
             "nativeName" => "ελληνικά"
         ],
         Locale::HEBREW => [
             "code"       => Locale::HEBREW,
             "name"       => "Hebrew",
             "nativeName" => "עברית"
         ],
         Locale::HUNGARIAN => [
             "code"       => Locale::HUNGARIAN,
             "name"       => "Hungarian",
             "nativeName" => "magyar"
         ],
         Locale::ICELANDIC => [
             "code"       => Locale::ICELANDIC,
             "name"       => "Icelandic",
             "nativeName" => "Íslenska"
         ],
         Locale::IRISH => [
             "code"       => Locale::IRISH,
             "name"       => "Irish",
             "nativeName" => "Gaeilge"
         ],
         Locale::INDONESIAN => [
             "code"       => Locale::INDONESIAN,
             "name"       => "Indonesian",
             "nativeName" => "Bahasa"
         ],
         Locale::JAPANESE => [
             "code"       => Locale::JAPANESE,
             "name"       => "Japanese",
             "nativeName" => "日本語"
         ],
         Locale::KOREAN => [
             "code"       => Locale::KOREAN,
             "name"       => "Korean",
             "nativeName" => "Korean"
         ],
         Locale::LATVIAN => [
             "code"       => Locale::LATVIAN,
             "name"       => "Latvian",
             "nativeName" => "latviešu valoda"
         ],
         Locale::LITHUANIAN => [
             "code"       => Locale::LITHUANIAN,
             "name"       => "Lithuanian",
             "nativeName" => "lietuvių kalba"
         ],
         Locale::MALAY => [
             "code"       => Locale::MALAY,
             "name"       => "Melay",
             "nativeName" => "bahasa Melayu"
         ],
         Locale::MACEDONIAN => [
             "code"       => Locale::MACEDONIAN,
             "name"       => "Macedonian",
             "nativeName" => "македонски јазик"
         ],
         Locale::MALTESE => [
             "code"       => Locale::MALTESE,
             "name"       => "Maltese",
             "nativeName" => "Malti"
         ],
         Locale::NORWEGIAN => [
             "code"       => Locale::NORWEGIAN,
             "name"       => "Norwegian",
             "nativeName" => "Norsk"
         ],
         Locale::POLISH => [
             "code"       => Locale::POLISH,
             "name"       => "Polish",
             "nativeName" => "język polski"
         ],
         Locale::PORTUGESE => [
             "code"       => Locale::PORTUGESE,
             "name"       => "Portugese",
             "nativeName" => "Português"
         ],
         Locale::RUSSIAN => [
             "code"       => Locale::RUSSIAN,
             "name"       => "Russian",
             "nativeName" => "Русский"
         ],
         Locale::ROMANIAN => [
             "code"       => Locale::ROMANIAN,
             "name"       => "Romanian",
             "nativeName" => "Română"
         ],
         Locale::SERBIAN => [
             "code"       => Locale::SERBIAN,
             "name"       => "Serbian",
             "nativeName" => "српски језик"
         ],
         Locale::SLOVAK => [
             "code"       => Locale::SLOVAK,
             "name"       => "Slovak",
             "nativeName" => "slovenčina"
         ],
         Locale::SPANISH => [
             "code"       => Locale::SPANISH,
             "name"       => "Spanish",
             "nativeName" => "Español"
         ],
         Locale::SWEDISH => [
             "code"       => Locale::SWEDISH,
             "name"       => "Swedish",
             "nativeName" => "svenska"
         ],
         Locale::SLOVENIAN => [
             "code"       => Locale::SLOVENIAN,
             "name"       => "Slovenian",
             "nativeName" => "slovenski jezik"
         ],
         Locale::THAI => [
             "code"       => Locale::THAI,
             "name"       => "Thai",
             "nativeName" => "ไทย"
         ],
         Locale::TURKISH => [
             "code"       => Locale::TURKISH,
             "name"       => "Turkish",
             "nativeName" => "Türkçe"
         ],
         Locale::UKRANIAN => [
             "code"       => Locale::UKRANIAN,
             "name"       => "Ukranian",
             "nativeName" => "Українська"
         ],
         Locale::VIETNAMESE => [
             "code"       => Locale::VIETNAMESE,
             "name"       => "Vietnamese",
             "nativeName" => "Tiếng Việt"
         ]
     ];

    /**
     * Instances and returns a locale.
     *
     * @param string $name Locale name.
     *
     * @return Locale Locale instance.
     *
     * @throws InvalidArgumentException If `$name` isn't a valid locale name.
     */
     public static function get(string $name)
     {
        if(!isset(static::$_locales[$name])) {;
            throw new InvalidArgumentException("Locale `{$name}` does not exist!");
        }

        return new static(... array_values(static::$_locales[$name]));;
    }

    ///////////////////////////////////////
    // Non static methods and properties //
    ///////////////////////////////////////

    /**
     * Locale name.
     *
     * @var string
     */
    public $name = "";

    /**
     * Locale code.
     *
     * @var string
     */
    public $code = "";

    /**
     * Locale native name.
     *
     * @var string
     */
    public $nativeName = "";

    /**
     * Constructor.
     *
     * @param string $code       Locale code.
     * @param string $name       Locale name.
     * @param string $nativeName Locale native name.
     */
    public function __construct(string $code, string $name, string $nativeName)
    {
        $this->name       = $name;
        $this->code       = $code;
        $this->nativeName = $nativeName;
    }
}
