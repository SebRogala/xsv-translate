<?php
/**
 * Author: Sebastian Rogala
 * Mail: sebrogala@gmail.com
 * Created: 20.07.18
 */

namespace Xsv\Translate\DomainShared\Entity;

class Translation
{
    /** @var string */
    private $id;

    /** @var string */
    private $resourceName;

    /** @var string */
    private $resourceId;

    /** @var string */
    private $locale;

    /** @var string */
    private $content;

    /**
     * Translation constructor.
     * @param string $id
     * @param string $resourceName
     * @param string $resourceId
     * @param string $locale
     * @param string $content
     */
    public function __construct(string $id, string $resourceName, string $resourceId, string $locale, string $content)
    {
        $this->id = $id;
        $this->resourceName = $resourceName;
        $this->resourceId = $resourceId;
        $this->locale = $locale;
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

}
