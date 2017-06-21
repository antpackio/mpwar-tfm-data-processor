<?php
/**
 * Created by PhpStorm.
 * User: Carles
 * Date: 15/06/2017
 * Time: 19:34
 */

namespace Mpwar\DataProcessor\Domain\Service;


use Mpwar\DataProcessor\Domain\Entity\EnrichedDocument;
use Mpwar\DataProcessor\Domain\Entity\RawDocument;
use Mpwar\DataProcessor\Domain\Exception\EmptyRawDocumentException;
use Mpwar\DataProcessor\Domain\Exception\NotSupportedSourceException;
use Mpwar\DataProcessor\Domain\ValueObject\EnrichedDocumentContent;

class TwitterParser implements Parser
{

    const SOURCE = "twitter";

    public function parse(RawDocument $rawDocument): EnrichedDocument
    {
        $this->checkIfSourceIsTwitter($rawDocument);

        $this->checkIfEmptyContent($rawDocument);

        $rawDocumentContentDecoded = json_decode($rawDocument->content()->value(),true);
        $content = $rawDocumentContentDecoded["text"];

        $content = New EnrichedDocumentContent($content);

        return new EnrichedDocument($rawDocument->id(), $rawDocument->source(), $content);
    }

    /**
     * @param RawDocument $rawDocument
     * @throws NotSupportedSourceException
     */
    private function checkIfSourceIsTwitter(RawDocument $rawDocument): void
    {
        if ($rawDocument->source()->value() !== self::SOURCE) {
            throw new NotSupportedSourceException();
        }
    }

    /**
     * @param RawDocument $rawDocument
     * @throws EmptyRawDocumentException
     */
    private function checkIfEmptyContent(RawDocument $rawDocument): void
    {
        if (empty($rawDocument->content()->value())) {
            throw new EmptyRawDocumentException();
        }
    }
}