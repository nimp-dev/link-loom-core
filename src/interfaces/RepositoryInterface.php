<?php

namespace Nimp\LinkLoomCore\interfaces;

use Nimp\LinkLoomCore\entities\UrlCodePair;
use Nimp\LinkLoomCore\exceptions\RepositoryDataException;

interface RepositoryInterface
{
    /**
     * @param UrlCodePair $urlCodePair
     * @return bool
     */
    public function saveUrlEntity(UrlCodePair $urlCodePair): bool;

    /**
     * @param string $code
     * @throws RepositoryDataException
     * @return string
     */
    public function getUrlByCode(string $code): string;

    /**
     * @param string $url
     * @throws RepositoryDataException
     * @return string
     */
    public function getCodeByUrl(string $url): string;


}