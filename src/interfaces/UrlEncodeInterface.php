<?php

namespace Nimp\LinkLoomCore\interfaces;

use Nimp\LinkLoomCore\exceptions\UrlShortenerException;

interface UrlEncodeInterface
{
    /**
     * @param string $url
     * @return string
     * @throws UrlShortenerException
     */
    public function encode(string $url): string;
}