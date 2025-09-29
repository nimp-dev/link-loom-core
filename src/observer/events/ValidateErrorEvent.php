<?php

namespace Nimp\LinkLoomCore\observer\events;

use Nimp\LinkLoomCore\observer\events\BaseShortenerEvent;
use Nimp\LinkLoomCore\UrlShortener;

class ValidateErrorEvent extends BaseShortenerEvent
{
    public readonly string $url;
    public readonly string $message;
    public function __construct(UrlShortener $context, string $url , string $message)
    {
        $this->url = $url;
        $this->message = $message;
        parent::__construct($context);
    }
}