<?php
/**
 * Author: Sebastian Rogala
 * Mail: sebrogala@gmail.com
 * Created: 20.07.18
 */

namespace Xsv\Translate\Translator;

use Xsv\Translate\DomainShared\ValueObject\DefaultTranslation;
use Xsv\Translate\DomainShared\ValueObject\Locale;
use Xsv\Translate\DomainShared\ValueObject\NotFoundTranslation;

class Translator
{
    /** @var Locale */
    private static $appDefaultLocale;

    /** @var Locale */
    private static $preferableLocale;

    /** @var TranslatorAdapter */
    private static $adapter;

    /** @var array */
    private static $translationKeys;

    public static function init(Locale $preferableLocale, Locale $appDefaultLocale, TranslatorAdapter $adapter, array $translationKeys = [])
    {
        self::$preferableLocale = $preferableLocale;
        self::$adapter = $adapter;
        self::$appDefaultLocale = $appDefaultLocale;
        self::$translationKeys = $translationKeys;
    }

    public static function translate(string $resourceName, string $resourceId, $defaultTranslationContent = "")
    {
        $defaultTranslation = new DefaultTranslation($defaultTranslationContent);

        if(self::$preferableLocale == self::$appDefaultLocale) {
            return $defaultTranslation->getContent();
        }

        $translation = self::$adapter->translate($resourceName, $resourceId, self::$preferableLocale);
        if($translation instanceof NotFoundTranslation && !empty($defaultTranslationContent)) {
            $translation = $defaultTranslation;
        }

        return $translation->getContent();
    }

    public static function getTranslationKeys()
    {
        return self::$translationKeys;
    }

    public static function addTranslation($resourceName, $resourceId, Locale $locale, $content)
    {
        return self::$adapter->addTranslation($resourceName, $resourceId, $locale, $content);
    }

    public static function getAllTranslations(string $resourceName, $resourceId)
    {
        return self::$adapter->getAllTranslations($resourceName, $resourceId);
    }
}
