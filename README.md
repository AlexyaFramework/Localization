# Localization
Alexya's localization components

## Contents
 - [Text translation](#text_translation)
    - [Instantiating Translator objects](#instantiating_translator_objects)
    - [Translating texts](#translating_texts)

<a name="text_translation"></a>
## Text translation
The class `\Alexya\Localization\Translator` offers a way for translating texts.
Bassically you instance a `Translator` object with the given text translatation and the you call the
`translate` method whenever you want to translate a text.

<a name="iinstantiating_translator_objects"></a>
### Instantiating Translator objects
The constructor accepts as parameter an associative array containing the language code and the translations.
Optionally you can send a second parameter being the default language where the texts will be translated.

Example:

```php
<?php
$translator = new \Alexya\Localization\Translator([
    "en" => [
        "monday"    => "monday",
        "thursday"  => "thursday",
        "wednesday" => "wednesday",
        "tuesday"   => "tuesday",
        "friday"    => "friday",
        "saturday"  => "saturday",
        "sunday"    => "sunday"
    ],
    "es" => [
        "monday"    => "lunes",
        "thursday"  => "martes",
        "wednesday" => "miercoles",
        "tuesday"   => "jueves",
        "friday"    => "viernes",
        "saturday"  => "sabado",
        "sunday"    => "domingo"
    ]
], "en");
```

<a name="translating_texts"></a>
### Translating texts

Once the object has been instantiated you can use the method `translate` to translate a text.
It accepts as parameter a string being the text to translate.

Optionally you can send an array with the variables to parse or a string with the language
code to translate the text, or even both.

If the language doesn't exist, the text will be translated to the default language.

If the text couldn't be translated, it will return the first parameter.

Example:

```php
<?php
$translator = new \Alexya\Localization\Translator([
    "en" => [
        "monday"    => "monday",
        "thursday"  => "thursday",
        "wednesday" => "wednesday",
        "tuesday"   => "tuesday",
        "friday"    => "friday",
        "saturday"  => "saturday",
        "sunday"    => "sunday",

        "Today is {day}" => "Today is {day}"
    ],
    "es" => [
        "monday"    => "lunes",
        "thursday"  => "martes",
        "wednesday" => "miercoles",
        "tuesday"   => "jueves",
        "friday"    => "viernes",
        "saturday"  => "sabado",
        "sunday"    => "domingo",

        "Today is {day}" => "Hoy es {day}"
    ]
]);

// Quick translation
$translator->translate("Today is {day}");
// Today is {day}

// Translation with context
$translator->translate("Today is {day}", [
    "day" => $translator->translate("monday")
]);
// Today is monday

// Translation in a specific language
$translator->translate("Today is {day}", "es");
// Hoy es {day}

// Translation in a specific language with context
$translator->translate("Today is {day}", [
    "day" => $translator->translate("monday", "es")
], "es");
// Hoy es lunes

// Text that can't be translated
$translator->translate("some_text");
// some_text
```

If the language isn't specified it will be translated to the language sent to the method `setDefaultLanguage`.

For translating texts of a sub-array use a dot (`.`) to link the texts to translate:

```php
<?php
$translator = new \Alexya\Localization\Translator([
    "en" => [
        "days" => [
            "monday"    => "monday",
            "thursday"  => "thursday",
            "wednesday" => "wednesday",
            "tuesday"   => "tuesday",
            "friday"    => "friday",
            "saturday"  => "saturday",
            "sunday"    => "sunday"
        ],
        "phrases" => [
            "today_is" => "Today is {day}"
        ]
    ]
]);

// Recursive translation
$translator->translate("phrases.today_is", [
    "day" => $translator->translate("days.monday")
]);
// Today is monday
```

You can also add more translations to an already specified language with the method `addTranslations`.
It accepts as parameter the language code and an array containing the translations to add.
If the language code doesn't exist, it will create it.
