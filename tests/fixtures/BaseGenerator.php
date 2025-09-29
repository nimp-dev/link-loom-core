<?php

namespace Nimp\LinkLoomCore\Tests\fixtures;

use Nimp\LinkLoomCore\interfaces\CodeGeneratorInterface;

/**
 * Using for test.
 */
class BaseGenerator implements CodeGeneratorInterface
{

    /**
     * @inheritDoc
     */
    public function generate(string $url): string
    {
        return substr(md5($url), 0, 5);
    }
}