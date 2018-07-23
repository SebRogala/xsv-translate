<?php
/**
 * Author: Sebastian Rogala
 * Mail: sebrogala@gmail.com
 * Created: 22.07.18
 */

namespace Xsv\Translate\DomainShared\ValueObject;

use Xsv\Translate\DomainShared\Entity\Translation;

class NotFoundTranslation extends Translation
{
    public function __construct()
    {
        parent::__construct("empty", "empty", "empty", "en_GB", "Translation not found");
    }
}
