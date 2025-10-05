<?php

namespace Nimp\LinkLoomCore\Tests\entities;

use Nimp\LinkLoomCore\entities\UrlCodePair;
use PHPUnit\Framework\TestCase;

/**
 * Test class for UrlCodePair.
 * Tests the getUrl method to ensure it correctly retrieves the URL.
 */
class UrlCodePairTest extends TestCase
{
    /**
     * Test that getUrl returns the URL passed to the constructor.
     * @return void
     */
    public function testGetUrlReturnsCorrectUrl(): void
    {
        $url = "https://example.com";
        $code = "ABC123";
        $urlCodePair = new UrlCodePair($url, $code);

        $this->assertSame($url, $urlCodePair->getUrl());
    }

    /**
     * Test that getUrl handles empty string URLs.
     * @return void
     */
    public function testGetUrlHandlesEmptyUrl(): void
    {
        $url = "";
        $code = "EMPTY001";
        $urlCodePair = new UrlCodePair($url, $code);

        $this->assertSame($url, $urlCodePair->getUrl());
    }

    /**
     * Test that getUrl handles special characters in the URL.
     * @return void
     */
    public function testGetUrlHandlesSpecialCharacters(): void
    {
        $url = "https://example.com/?query=value&other=value#anchor";
        $code = "SPEC123";
        $urlCodePair = new UrlCodePair($url, $code);

        $this->assertSame($url, $urlCodePair->getUrl());
    }
}