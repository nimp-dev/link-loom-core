# Link Loom Core

![Tests](https://github.com/nimp-dev/link-loom-core/actions/workflows/tests.yml/badge.svg)
![PHPStan](https://github.com/nimp-dev/link-loom-core/actions/workflows/phpstan.yml/badge.svg)
![Code Coverage](https://codecov.io/gh/nimp-dev/link-loom-core/branch/main/graph/badge.svg)
![PHP Version](https://img.shields.io/badge/PHP-8.1%2B-blue.svg)
![License](https://img.shields.io/badge/license-MIT-green.svg)

A library for shortening URLs and decoding shortcodes back into original links. It's based on clearly separated interfaces (repository, validator, code generator) and PSR-14 events.

- Minimal dependencies
- Extensibility through custom interface implementations
- Events during encoding/decoding and errors

## Installation
```BASH
composer require nimp/observer
```

## Quick start

```PHP
use Nimp\Linkloom\Linkloom;

$shortener = new UrlShortener(
            new Repository(),
            new Validator(),
            new Generator(),
            new EventDispatcher(
                new ListenerProvider()
            ),
        );


$url = 'https://example.org';
$core = $shortener->encode($url);
$urlDecoder = $shortener->decode($core);
```
## Tests
```BASH
composer install && composer test
```
