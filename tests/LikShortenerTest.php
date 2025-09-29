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
     * @throws UrlShortenerException
     */
    #[Test]
    public function shortenInvalidUrlException(): void
    {
         $this->expectException(UrlShortenerException::class);
         $this->shortener->encode('notaurl');
    }

    /**
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
     * @throws UrlShortenerException
     */
    #[Test]
    public function resolveNonExistentCodeException(): void
    {
         $this->expectException(UrlShortenerException::class);
         $this->shortener->decode('unknown123');
    }

    /**
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