<?php
/**
 * Author: Sebastian Rogala
 * Mail: sebrogala@gmail.com
 * Created: 13.07.18
 */

namespace Xsv\Translate;

use Doctrine\ORM\EntityManager;
use Xsv\Base\AbstractFactory\CommonDependencyInjectionAbstractFactory;
use Xsv\Translate\App\Middleware\TranslatorConfigMiddleware;
use Xsv\Translate\App\TranslatorAdapter\DoctrineTranslatorAdapter;

class ConfigProvider
{
    public function __invoke()
    {
        return [
            'dependencies' => [
                'invokables' => [
                ],
                'factories' => [
                    DoctrineTranslatorAdapter::class => CommonDependencyInjectionAbstractFactory::class,
                    TranslatorConfigMiddleware::class => CommonDependencyInjectionAbstractFactory::class,
                ],
                'services' => [
                    Translator\TranslatorAdapter::class => DoctrineTranslatorAdapter::class,
                ],
            ],
            'doctrine' => [
                EntityManager::class => [
                    'entity-path' => [
                        __DIR__ . "/../doctrine-xml-mapping"
                    ],
                ],
            ],
        ];
    }
}