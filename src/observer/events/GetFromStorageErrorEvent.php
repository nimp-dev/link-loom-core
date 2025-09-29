<?php

namespace Nimp\LinkLoomCore\observer\events;

use Nimp\LinkLoomCore\observer\events\BaseShortenerEvent;
use Nimp\LinkLoomCore\UrlShortener;

class GetFromStorageErrorEvent extends BaseShortenerEvent
{
    public readonly string $code;
    public readonly string $message;

    public function __construct(UrlShortener $context, string $code, string $message)
    {
        $this->code = $code;
        $this->message = $message;
        parent::__construct($context);
    }
}