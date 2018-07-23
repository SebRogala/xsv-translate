<?php
/**
 * Author: Sebastian Rogala
 * Mail: sebrogala@gmail.com
 * Created: 20.07.18
 */

namespace Xsv\Translate\Translator;

use Xsv\Translate\DomainShared\Entity\Translation;
use Xsv\Translate\DomainShared\ValueObject\Locale;

interface TranslatorAdapter
{
    public function translate($resourceName, $resourceId, Locale $locale): Translation;

    public function addTranslation($resourceName, $resourceId, Locale $locale, $content);

    public function getAllTranslations($resourceName, $resourceId);
}
