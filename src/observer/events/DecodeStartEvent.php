<?php

namespace Nimp\LinkLoomCore\observer\events;

use Nimp\LinkLoomCore\UrlShortener;
use Nimp\LinkLoomCore\observer\events\BaseShortenerEvent;

class DecodeStartEvent extends BaseShortenerEvent
{
    public readonly string $code;
    public function __construct(UrlShortener $context, string $code)
    {
        $this->code = $code;
        parent::__construct($context);
    }
}