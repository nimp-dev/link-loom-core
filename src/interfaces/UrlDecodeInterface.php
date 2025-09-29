<?php

namespace Nimp\LinkLoomCore\interfaces;

use Nimp\LinkLoomCore\exceptions\UrlShortenerException;

interface UrlDecodeInterface
{
    /**
     * @param string $code
     * @return string
     * @throws UrlShortenerException
     */
    public function decode(string $code): string;

}