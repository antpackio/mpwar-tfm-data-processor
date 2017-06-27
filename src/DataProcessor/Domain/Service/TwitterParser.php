<?php

namespace Mpwar\DataProcessor\Domain\Service;

use Mpwar\DataProcessor\Domain\Entity\EnrichedDocument;
use Mpwar\DataProcessor\Domain\Exception\EmptyRawDocumentException;
use Mpwar\DataProcessor\Domain\Exception\NotSupportedSourceException;
use Mpwar\DataProcessor\Domain\ValueObject\EnrichedDocumentContent;
use Mpwar\DataProcessor\Domain\ValueObject\EnrichedDocumentCreatedAt;
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
        $content = new EnrichedDocumentContent(
            $rawDocumentContentDecoded["text"]
        );
        $enrichedDocument->setContent($content);
        $createdAt = new EnrichedDocumentCreatedAt(
            $rawDocumentContentDecoded["created_at"]
        );
        $enrichedDocument->setCreatedAt($createdAt);

        return $enrichedDocument;
    }

    /**
     * @param EnrichedDocument $enrichedDocument
     * @throws NotSupportedSourceException
     */
    private function checkIfSourceIsTwitter(EnrichedDocument $enrichedDocument): void
    {
        if ($enrichedDocument->source()->value() !== self::SOURCE) {
            throw new NotSupportedSourceException();
        }
    }

    /**
     * @param RawDocumentContent $rawDocumentContent
     * @throws EmptyRawDocumentException
     */
    private function checkIfEmptyContent(RawDocumentContent $rawDocumentContent): void
    {
        if (empty($rawDocumentContent->value())) {
            throw new EmptyRawDocumentException();
        }
    }
}
