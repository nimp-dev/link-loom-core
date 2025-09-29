# Link Loom Core

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
