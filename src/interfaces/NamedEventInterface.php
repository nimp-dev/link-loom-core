<?php

namespace Nimp\LinkLoomCore\interfaces;

interface NamedEventInterface
{
    /**
     * Retrieves the name of the event.
     *
     * @return string|null The name of the event or null if no name is set.
     */
    public function eventName(): string|null;
}