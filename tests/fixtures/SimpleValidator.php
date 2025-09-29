<?php

namespace Nimp\LinkLoomCore\Tests\fixtures;

use Nimp\LinkLoomCore\interfaces\UrlValidatorInterface;

/**
 * Using for test.
 * Simple validator: check if url is valid.
 */
class SimpleValidator implements UrlValidatorInterface
{
    /**
     * @var string
     */
    protected string $messageError = 'Error';

    /**
     * @inheritDoc
     */
    public function getMessageError(): string
    {
        return $this->messageError;
    }

    /**
     * @inheritDoc
     */
    public function validate(string $url): bool
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            $this->messageError = 'Invalid URL';
            return false;
        }
        return true;
    }
}