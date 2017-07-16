<?php

namespace Mpwar\DataProcessor\Domain\Parser;

use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocument;
use Mpwar\DataProcessor\Domain\Exception\EmptyRawDocumentException;
use Mpwar\DataProcessor\Domain\Exception\NonWellFormedTweetException;
use Mpwar\DataProcessor\Domain\Exception\NotSupportedSourceException;
use Mpwar\DataProcessor\Domain\EnrichedDocument\Author;
use Mpwar\DataProcessor\Domain\EnrichedDocument\AuthorLocation;
use Mpwar\DataProcessor\Domain\EnrichedDocument\Content;
use Mpwar\DataProcessor\Domain\EnrichedDocument\CreatedAt;
use Mpwar\DataProcessor\Domain\EnrichedDocument\Language;
use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentContent;

class TwitterParser implements Parser
{

    const SOURCE = "twitter";



    public function parse(EnrichedDocument $enrichedDocument): EnrichedDocument
    {
        $this->checkIfSourceIsTwitter($enrichedDocument);
        $this->checkIfEmptyContent($enrichedDocument->rawDocumentContent());

        $rawDocumentContentDecoded = json_decode(
            $enrichedDocument->rawDocumentContent()->value(),
            true
        );

        $this->checkWellFormedTweet($rawDocumentContentDecoded);

        $enrichedDocument->setContent(
            new Content(
                $rawDocumentContentDecoded['text']
            )
        );
        $enrichedDocument->setCreatedAt(
            new CreatedAt(
                $rawDocumentContentDecoded['created_at']
            )
        );
        $enrichedDocument->setAuthor(
            new Author(
                $rawDocumentContentDecoded['user']['name'] ?: EnrichedDocument::UNDEFINED_TAG
            )
        );
        $enrichedDocument->setAuthorLocation(
            new AuthorLocation(
                $rawDocumentContentDecoded['user']['location'] ?: EnrichedDocument::UNDEFINED_TAG
            )
        );
        if ($rawDocumentContentDecoded['metadata']['iso_language_code']) {
            $enrichedDocument->setLanguage(
                new Language(
                    $rawDocumentContentDecoded['metadata']['iso_language_code']
                )
            );
        }

        return $enrichedDocument;
    }

    /**
     * @param EnrichedDocument $enrichedDocument
     * @throws NotSupportedSourceException
     */
    private function checkIfSourceIsTwitter(EnrichedDocument $enrichedDocument
    ): void {
        if ($enrichedDocument->source()->value() !== self::SOURCE) {
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
