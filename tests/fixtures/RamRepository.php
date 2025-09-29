<?php

namespace Nimp\LinkLoomCore\Tests\fixtures;

use Nimp\LinkLoomCore\entities\UrlCodePair;
use Nimp\LinkLoomCore\exceptions\RepositoryDataException;
use Nimp\LinkLoomCore\interfaces\RepositoryInterface;

/**
 * Using for test.
 * Simple repository: code as key, url as value.
 */
final class RamRepository implements RepositoryInterface
{
    /**
     * @var array<string, string>
     */
    private array $storage = [];

    /**
     * @param UrlCodePair $urlCodePair
     * @return bool
     */
    public function saveUrlEntity(UrlCodePair $urlCodePair): bool
    {
        $this->storage[$urlCodePair->getCode()] = $urlCodePair->getUrl();
        return true;
    }

    /**
     * Retrieves the URL associated with the given code.
     *
     * @param string $code The code for which the URL should be retrieved.
     * @return string The URL associated with the provided code.
     * @throws RepositoryDataException If no URL is found for the given code.
     */
    public function getUrlByCode(string $code): string
    {
        if (!array_key_exists($code, $this->storage)) {
            throw new RepositoryDataException("No URL found for code: {$code}");
        }

        return $this->storage[$code];
    }

    /**
     * Retrieves a code corresponding to the provided URL from the storage.
     *
     * @param string $url The URL to search for in the storage.
     * @return string The code associated with the given URL.
     * @throws RepositoryDataException If no code is found for the provided URL.
     */
    public function getCodeByUrl(string $url): string
    {
        $code = array_search($url, $this->storage, true);

        if ($code === false) {
            throw new RepositoryDataException("No code found for URL: {$url}");
        }

        return $code;
    }
}