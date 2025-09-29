<?php

namespace Nimp\LinkLoomCore\observer\events;

use Nimp\LinkLoomCore\UrlShortener;
use Nimp\LinkLoomCore\observer\events\BaseShortenerEvent;

class DecodeSuccessEvent extends BaseShortenerEvent
{
    public readonly string $url;
    public function __construct(UrlShortener $context, string $url)
    {
        $this->url = $url;
        parent::__construct($context);
    }
}