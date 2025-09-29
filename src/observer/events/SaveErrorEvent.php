<?php

namespace Nimp\LinkLoomCore\observer\events;

use Nimp\LinkLoomCore\observer\events\BaseShortenerEvent;
use Nimp\LinkLoomCore\UrlShortener;

class SaveErrorEvent extends BaseShortenerEvent
{
    public readonly string $message;
    public function __construct(UrlShortener $context, string $message)
    {
        $this->message = $message;
        parent::__construct($context);
    }
}