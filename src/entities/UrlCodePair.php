<?php

namespace Nimp\LinkLoomCore\entities;

/**
 * Represents a pair consisting of a URL and a corresponding code.
 */
class UrlCodePair
{
    /**
     * @var string
     */
    protected string $url;
    /**
     * @var string
     */
    protected string $code;

    /**
     * @param string $url
     * @param string $code
     */
    public function __construct(string $url, string $code)
    {
        $this->url = $url;
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

}