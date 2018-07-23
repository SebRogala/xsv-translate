<?php
/**
 * Author: Sebastian Rogala
 * Mail: sebrogala@gmail.com
 * Created: 20.07.18
 */

namespace Xsv\Translate\App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Xsv\Base\Service\AppConfigService;
use Xsv\Translate\DomainShared\ValueObject\Locale;
use Xsv\Translate\Translator\Translator;
use Xsv\Translate\Translator\TranslatorAdapter;

class TranslatorConfigMiddleware implements MiddlewareInterface
{
    /** @var TranslatorAdapter */
    private $translatorAdapter;
    /**
     * @var AppConfigService
     */
    private $config;

    /**
     * TranslatorConfigMiddleware constructor.
     * @param TranslatorAdapter $translatorAdapter
     * @param AppConfigService $config
     */
    public function __construct(TranslatorAdapter $translatorAdapter, AppConfigService $config)
    {
        $this->translatorAdapter = $translatorAdapter;
        $this->config = $config;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $preferableLocale = $this->getPreferableLocale($request);
        $defaultLocale = new Locale((string)$this->config->getConfig("xsv-translate", "default-locale"));

        $locale = empty($preferableLocale) ? clone $defaultLocale : new Locale($preferableLocale);

        Translator::init($locale, $defaultLocale, $this->translatorAdapter);

        return $handler->handle($request);
    }

    private function getPreferableLocale(ServerRequestInterface $request)
    {
        $preferableLocale = $request->getHeader("X-Preferable-Locale");

        if(!empty($preferableLocale)) {
            return $this->convertLocale($preferableLocale[0]);
        }

        $acceptLanguage = $request->getHeader("Accept-Language");
        if(!empty($acceptLanguage)) {
            $acceptLanguage = explode(",", $acceptLanguage[0]);
            if(!empty($acceptLanguage)) {
                return $this->convertLocale($acceptLanguage[0]);
            }
        }
        return null;
    }

    private function convertLocale($locale)
    {
        $locale = str_replace("-", "_", $locale);
        $locales = $this->config->getConfig("xsv-translate", "locales-conversion");

        if(array_key_exists($locale, $locales)) {
            $locale = $locales[$locale];
        }

        return $locale;
    }
}
