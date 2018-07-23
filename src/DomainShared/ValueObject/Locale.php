<?php
/**
 * Author: Sebastian Rogala
 * Mail: sebrogala@gmail.com
 * Created: 20.07.18
 */

namespace Xsv\Translate\DomainShared\ValueObject;

class Locale
{
    /** @var string */
    private $name;

    /**
     * Locale constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = str_replace("-", "_", $name);
    }

    public function toString()
    {
        return $this->name;
    }
}
