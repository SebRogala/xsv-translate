<?php
/**
 * Author: Sebastian Rogala
 * Mail: sebrogala@gmail.com
 * Created: 20.07.18
 */

namespace Xsv\Translate\App\TranslatorAdapter;

use App\UuidGen;
use Doctrine\ORM\EntityManager;
use Xsv\Translate\DomainShared\Entity\Translation;
use Xsv\Translate\DomainShared\ValueObject\Locale;
use Xsv\Translate\DomainShared\ValueObject\NotFoundTranslation;
use Xsv\Translate\Translator\TranslatorAdapter;

class DoctrineTranslatorAdapter implements TranslatorAdapter
{
    /** @var EntityManager */
    private $entityManager;

    /**
     * DoctrineTranslatorAdapter constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function translate($resourceName, $resourceId, Locale $locale): Translation
    {
        /** @var Translation $translation */
        $translation = $this->entityManager->getRepository(Translation::class)->findOneBy(
            [
                "resourceName" => $resourceName,
                "resourceId" => $resourceId,
                "locale" => $locale->toString()
            ]
        );

        if(empty($translation)) {
            $translation = new NotFoundTranslation();
        }

        return $translation;
    }

    public function getAllTranslations($resourceName, $resourceId)
    {
        $translations = $this->entityManager->getRepository(Translation::class)->findBy(
            [
                "resourceName" => $resourceName,
                "resourceId" => $resourceId,
            ]
        );

        return $translations;
    }

    public function addTranslation($resourceName, $resourceId, Locale $locale, $content)
    {
        $shouldPersist = true;

        /** @var Translation $translation */
        $translation = $this->entityManager->getRepository(Translation::class)->findOneBy(
            [
                "resourceName" => $resourceName,
                "resourceId" => $resourceId,
                "locale" => $locale->toString()
            ]
        );

        if(empty($translation)) {
            $id = UuidGen::uuid();
        } else {
            $id = $translation->getId();
            $shouldPersist = false;
        }

        $translation = new Translation(
            $id,
            $resourceName,
            $resourceId,
            $locale->toString(),
            $content
        );

        if($shouldPersist) {
            $this->entityManager->persist($translation);
        }
        $this->entityManager->flush();
    }
}
