# Zend Expressive Translation Module
Module made for database oriented resource translating with usage of Doctrine2.
However it is quite simple to expand Translator with own kind of Adapter.

## Installing (being in project root)
```bash
composer require sebrogala/xsv-translate^3.0
cp vendor/sebrogala/xsv-translate/data/xsv-translate-config.global.php.dist config/autoload/xsv-translate-config.global.php
```
- enable module in ```config/config.php``` adding ```Xsv\Translate\ConfigProvider::class,```
- pipe middleware in ```config/pipeline.php``` before ```DispatchMiddleware```:
```php
/* ... */
$app->pipe(\Xsv\Translate\App\Middleware\TranslatorConfigMiddleware::class);
$app->pipe(DispatchMiddleware::class);
/* ... */
```
- change config file according to needs
```bash
vendor/bin/doctrine orm:schema-tool:update --force
```
## Usage

- yet to done, for now only simple examples:

#### Recognizing which language to use
- provide locale code with custom header:
```
X-Preferable-Locale locale_CODE
```

#### Adding translation
```php
//adding translation interface
public static function addTranslation($resourceName, $resourceId, Locale $locale, $content)
```
```php
use Xsv\Translate\Translator\Translator;
/*
...
*/
Translator::addTranslation("resource.name", "id", new Locale("pl_PL"), "TranslationToPolish");
```
Where:
- "resource.name" is self defined, can be "user.username" - it's about single field.
- "id" is unique id of row (currently it's based on uuid)

#### Translating resource
```php
//translating interface
public static function translate(string $resourceName, string $resourceId, $defaultTranslationContent = "")
```
```php
use Xsv\Translate\Translator\Translator;
/*
...
*/
return new JsonResponse(
    [
        "userName" => Translator::translate("user.name", $user->getId(), $user->getUserName())
    ]
);
```

## TODO
- remove single translation
- remove all translations for chosen ID
- provide better examples