<?php

namespace Nimp\LinkLoomCore\observer\events;

use Nimp\LinkLoomCore\observer\events\BaseShortenerEvent;
use Nimp\LinkLoomCore\UrlShortener;

class EncodeSuccessEvent extends BaseShortenerEvent
{
    public readonly string $code;
    public function __construct(UrlShortener $context, string $code)
    {
        $this->code = $code;
        parent::__construct($context);
    }
}