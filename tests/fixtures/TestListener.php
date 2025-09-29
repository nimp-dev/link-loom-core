<?php

namespace Nimp\LinkLoomCore\Tests\fixtures;

use Nimp\LinkLoomCore\observer\events\DecodeStartEvent;
use Nimp\LinkLoomCore\observer\events\DecodeSuccessEvent;
use Nimp\LinkLoomCore\observer\events\EncodeStartEvent;
use Nimp\LinkLoomCore\observer\events\EncodeSuccessEvent;
use Nimp\Observer\EventListenerInterface;

/**
 * Class TestListener
 *
 * Using for testing purposes.
 * Implements the EventListenerInterface to handle specific events during encoding and decoding processes.
 */
class TestListener implements EventListenerInterface
{

    /**
     * @var array <string>
     */
    public array $handled = [];

    /**
     * @inheritDoc
     */
    public function events(): iterable
    {
        yield EncodeStartEvent::class => fn(EncodeStartEvent $e) => $this->handled[] = 'onStartEncode';
        yield EncodeSuccessEvent::class => fn(EncodeSuccessEvent $e) => $this->handled[] = 'onSuccessEncode';
        yield DecodeStartEvent::class => fn(DecodeStartEvent $e) => $this->handled[] = 'onStartDecode';
        yield DecodeSuccessEvent::class => fn(DecodeSuccessEvent $e) => $this->handled[] = 'onSuccessDecode';
    }
}