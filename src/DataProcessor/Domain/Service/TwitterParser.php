<?php

namespace Mpwar\DataProcessor\Domain\Service;

use Mpwar\DataProcessor\Domain\Entity\EnrichedDocument;
use Mpwar\DataProcessor\Domain\Exception\EmptyRawDocumentException;
use Mpwar\DataProcessor\Domain\Exception\NonWellFormedTweetException;
use Mpwar\DataProcessor\Domain\Exception\NotSupportedSourceException;
use Mpwar\DataProcessor\Domain\ValueObject\EnrichedDocumentAuthor;
use Mpwar\DataProcessor\Domain\ValueObject\EnrichedDocumentAuthorLocation;
use Mpwar\DataProcessor\Domain\ValueObject\EnrichedDocumentContent;
use Mpwar\DataProcessor\Domain\ValueObject\EnrichedDocumentCreatedAt;
use Mpwar\DataProcessor\Domain\ValueObject\EnrichedDocumentLanguage;
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
            new EnrichedDocumentContent(
                $rawDocumentContentDecoded["text"]
            )
        );
        $enrichedDocument->setCreatedAt(
            new EnrichedDocumentCreatedAt(
                $rawDocumentContentDecoded["created_at"]
            )
        );
        $enrichedDocument->setAuthor(
            new EnrichedDocumentAuthor(
                $rawDocumentContentDecoded['user']['name'] ?: 'undefined'
            )
        );
        $enrichedDocument->setAuthorLocation(
            new EnrichedDocumentAuthorLocation(
                $rawDocumentContentDecoded['user']['location'] ?: 'undefined'
            )
        );
        if ($rawDocumentContentDecoded['metadata']['iso_language_code']) {
            $enrichedDocument->setLanguage(
                new EnrichedDocumentLanguage(
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
