<?php

namespace Mpwar\DataProcessor\Domain\Parser\Twitter;

use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocumentAuthor;
use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocumentAuthorLocation;
use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocumentContent;
use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocumentCreatedAt;
use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocument;
use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocumentFactory;
use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocumentLanguage;
use Mpwar\DataProcessor\Domain\Parser\NotSupportedSourceException;
use Mpwar\DataProcessor\Domain\Parser\Parser;
use Mpwar\DataProcessor\Domain\RawDocument\EmptyRawDocumentException;
use Mpwar\DataProcessor\Domain\RawDocument\RawDocument;
use Mpwar\DataProcessor\Domain\RawDocument\RawDocumentContent;
use Mpwar\DataProcessor\Domain\RawDocument\RawDocumentSource;

class TwitterParser implements Parser
{
    const SOURCE = "twitter";
    /**
     * @var EnrichedDocumentFactory
     */
    private $enrichedDocumentFactory;

    public function __construct(EnrichedDocumentFactory $enrichedDocumentFactory)
    {

        $this->enrichedDocumentFactory = $enrichedDocumentFactory;
    }

    public function parse(RawDocument $rawDocument): EnrichedDocument
    {
        $this->checkIfSourceIsTwitter($rawDocument->source());
        $this->checkIfEmptyContent($rawDocument->content());

        $rawDocumentContentDecoded = json_decode(
            $rawDocument->content()->value(),
            true
        );

        $this->checkWellFormedTweet($rawDocumentContentDecoded);

        return $this->enrichedDocumentFactory->build(
            $rawDocument,
            new EnrichedDocumentContent($rawDocumentContentDecoded['text']),
            new EnrichedDocumentCreatedAt($rawDocumentContentDecoded['created_at']),
            new EnrichedDocumentAuthor($rawDocumentContentDecoded['user']['name'] ?: EnrichedDocument::UNDEFINED_TAG),
            new EnrichedDocumentAuthorLocation($rawDocumentContentDecoded['user']['location'] ?: EnrichedDocument::UNDEFINED_TAG),
            new EnrichedDocumentLanguage($rawDocumentContentDecoded['metadata']['iso_language_code'] ?: EnrichedDocument::UNDEFINED_TAG)
        );
    }

    private function checkIfSourceIsTwitter(RawDocumentSource $rawDocumentSource
    ): void {
        if ($rawDocumentSource->value() !== self::SOURCE) {
            throw new NotSupportedSourceException();
        }
    }

    /**
     * @param RawDocumentContent $rawDocumentContent
     * @throws EmptyRawDocumentException
     */
    private function checkIfEmptyContent(RawDocumentContent $rawDocumentContent
    ): void {
        if (empty($rawDocumentContent->value())) {
            throw new EmptyRawDocumentException();
        }
    }

    private function checkWellFormedTweet(array $rawDocumentContentDecoded)
    {
        if (!$this->hasRequiredKeys($rawDocumentContentDecoded)) {
            throw new NonWellFormedTweetException();
        }
    }

    /**
     * @param array $rawDocumentContentDecoded
     * @return bool
     */
    private function hasRequiredKeys(array $rawDocumentContentDecoded): bool
    {
        return array_key_exists('user', $rawDocumentContentDecoded) &&
            array_key_exists('name', $rawDocumentContentDecoded['user']) &&
            array_key_exists('location', $rawDocumentContentDecoded['user']) &&
            array_key_exists('text', $rawDocumentContentDecoded) &&
            array_key_exists('metadata', $rawDocumentContentDecoded) &&
            array_key_exists('iso_language_code', $rawDocumentContentDecoded['metadata']) &&
            array_key_exists('created_at', $rawDocumentContentDecoded);
    }
}
