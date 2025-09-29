<?php

namespace Nimp\LinkLoomCore;

use Nimp\LinkLoomCore\entities\UrlCodePair;
use Nimp\LinkLoomCore\exceptions\{RepositoryDataException, UrlShortenerException};
use Nimp\LinkLoomCore\interfaces\{
    CodeGeneratorInterface,
    RepositoryInterface,
    UrlDecodeInterface,
    UrlEncodeInterface,
    UrlValidatorInterface,
};
use Nimp\LinkLoomCore\observer\events\{
    DecodeStartEvent,
    DecodeSuccessEvent,
    EncodeStartEvent,
    EncodeSuccessEvent,
    GetFromStorageErrorEvent,
    SaveErrorEvent,
    ValidateErrorEvent,
};
use Psr\EventDispatcher\EventDispatcherInterface;

/**
 * Class UrlShortener
 *
 * This class provides functionality to encode and decode URLs.
 * Encoding converts long URLs into short, unique codes, while decoding retrieves the original URLs using these codes.
 *
 * Implements UrlDecodeInterface and UrlEncodeInterface.
 */
class UrlShortener implements UrlDecodeInterface, UrlEncodeInterface
{
    protected RepositoryInterface $repository;
    protected UrlValidatorInterface $validator;
    protected CodeGeneratorInterface $codeGenerator;
    protected EventDispatcherInterface $eventDispatcher;

    /**
     * @param RepositoryInterface $repository
     * @param UrlValidatorInterface $validator
     * @param CodeGeneratorInterface $codeGenerator
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        RepositoryInterface      $repository,
        UrlValidatorInterface    $validator,
        CodeGeneratorInterface   $codeGenerator,
        EventDispatcherInterface $eventDispatcher,
    )
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->codeGenerator = $codeGenerator;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Encodes a given URL into a shortened code.
     *
     * @param string $url The URL to be encoded.
     * @return string The encoded URL as a shortened code.
     * @throws UrlShortenerException If URL validation fails or if an error occurs during encoding.
     */
    public function encode(string $url): string
    {
        $this->eventDispatcher->dispatch(new EncodeStartEvent($this, $url));

        if (!$this->validator->validate($url)) {
            $message = $this->validator->getMessageError();

            $this->eventDispatcher->dispatch(new ValidateErrorEvent($this, $url, $message));

            throw new UrlShortenerException(
                $message
            );
        }

        try {
            $code = $this->repository->getCodeByUrl($url);
        } catch (RepositoryDataException) {
            $code = $this->codeGenerator->generate($url);
            $urlCodePair = new UrlCodePair($url, $code);
            if (!$this->repository->saveUrlEntity($urlCodePair)) {

                $message = 'save entity error';
                $this->eventDispatcher->dispatch(new SaveErrorEvent($this, $message));

                throw new UrlShortenerException(
                    $message
                );
            }
        }

        $this->eventDispatcher->dispatch(new EncodeSuccessEvent($this, $code));
        return $code;
    }

    /**
     * Decodes the given code to retrieve the corresponding URL.
     *
     * @param string $code The encoded string that represents the shortened URL.
     * @return string The original URL corresponding to the given code.
     * @throws UrlShortenerException If an error occurs during the decoding process.
     */
    public function decode(string $code): string
    {
        $this->eventDispatcher->dispatch(new DecodeStartEvent($this, $code));

        try {
            $url = $this->repository->getUrlByCode($code);
        } catch (RepositoryDataException $e) {

            $this->eventDispatcher->dispatch(new GetFromStorageErrorEvent($this, $code, $e->getMessage()));

            throw new UrlShortenerException(
                $e->getMessage(),
            );
        }

        $this->eventDispatcher->dispatch(new DecodeSuccessEvent($this, $url));
        return $url;
    }
}