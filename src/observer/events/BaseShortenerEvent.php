<?php

namespace Nimp\LinkLoomCore\observer\events;

use Nimp\LinkLoomCore\UrlShortener;
use Nimp\LinkLoomCore\interfaces\NamedEventInterface;

abstract class BaseShortenerEvent implements NamedEventInterface
{
    public function __construct(
        public readonly UrlShortener $context,
    ) {}

    public function eventName(): string|null
    {
        return static::class;
    }
}