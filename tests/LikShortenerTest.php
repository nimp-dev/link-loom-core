<?php

namespace Nimp\LinkLoomCore\Tests;

use Nimp\LinkLoomCore\exceptions\UrlShortenerException;
use Nimp\LinkLoomCore\observer\events\EncodeStartEvent;
use Nimp\LinkLoomCore\Tests\fixtures\BaseGenerator;
use Nimp\LinkLoomCore\Tests\fixtures\RamRepository;
use Nimp\LinkLoomCore\Tests\fixtures\SimpleValidator;
use Nimp\LinkLoomCore\Tests\fixtures\TestListener;
use Nimp\LinkLoomCore\UrlShortener;
use Nimp\Observer\EventDispatcher;
use Nimp\Observer\EventListenerInterface;
use Nimp\Observer\ListenerProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;

#[CoversClass(UrlShortener::class)]
final class LikShortenerTest extends TestCase
{
    private UrlShortener $shortener;

    /**
     * create a shortener instance
     * @inheritdoc
     */
    protected function setUp(): void
    {

         $this->shortener = new UrlShortener(
             new RamRepository(),
             new SimpleValidator(),
             new BaseGenerator(),
             new EventDispatcher(new ListenerProvider()),
         );
    }

    /**
     * check if shortener returns a correct code
     * @throws UrlShortenerException
     */
    #[Test]
    public function shortenValidUrlSuccess(): void
    {
        $code = $this->shortener->encode('https://example.com/page');
        $this->assertIsString($code);
        $this->assertNotEmpty($code);
    }

    /**
     * check if shortener throws an exception on invalid url
     * @throws UrlShortenerException
     */
    #[Test]
    public function shortenInvalidUrlException(): void
    {
         $this->expectException(UrlShortenerException::class);
         $this->shortener->encode('notaurl');
    }

    /**
     * check if shortener returns a find url
     * @throws UrlShortenerException
     */
    #[Test]
    public function resolveExistCodeReturnUrl(): void
    {
         $code = $this->shortener->encode('https://example.com/x');
         $resolved = $this->shortener->decode($code);
         $this->assertSame('https://example.com/x', $resolved);
    }

    /**
     * check if shortener throws an exception on invalid code
     * @throws UrlShortenerException
     */
    #[Test]
    public function resolveNonExistentCodeException(): void
    {
         $this->expectException(UrlShortenerException::class);
         $this->shortener->decode('unknown123');
    }

    /**
     * check if events are dispatched
     * @throws UrlShortenerException
     */
    public function testEventsAreDispatched(): void
    {
        $listener = new TestListener();
        $provider = new ListenerProvider();
        $provider->addListeners($listener);

        $shortener = new UrlShortener(
            new RamRepository(),
            new SimpleValidator(),
            new BaseGenerator(),
            new EventDispatcher($provider),
        );


        $url = 'https://example.org';
        $core = $shortener->encode($url);
        $urlDecoder = $shortener->decode($core);

        $this->assertSame($url, $urlDecoder);
        $this->assertSame(['onStartEncode', 'onSuccessEncode', 'onStartDecode', 'onSuccessDecode'], $listener->handled);
    }

    /**
     * Invalid urls for testing
     * @return array[]
     */
    public static function invalidUrls(): array
    {
        return [
            [''],
            ['ftp//example.com/file'], // если только http/https
            ['http:/broken'],
            ['example.com'],
        ];
    }

    /**
     * check if shortener throws an exception on invalid url
     * @throws UrlShortenerException
     */
    #[Test]
    #[DataProvider('invalidUrls')]
    public function shortenInvalidUrlExceptions(string $url): void
    {
         $this->expectException(UrlShortenerException::class);
         $this->shortener->encode($url);
    }
}