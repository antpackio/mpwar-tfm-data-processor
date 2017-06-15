<?php
/**
 * Created by PhpStorm.
 * User: Carles
 * Date: 15/06/2017
 * Time: 18:01
 */

namespace Mpwar\DataProcessor\Domain\Service;


use Mpwar\DataProcessor\Domain\Entity\EnrichedDocument;
use Mpwar\DataProcessor\Domain\Entity\RawDocument;
use Mpwar\DataProcessor\Domain\Exception\NotSupportedSourceException;
use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentSource;


class ConcreteRawDocumentParserService implements RawDocumentParserService
{
    const SOURCE_SUPPORTED = ["twitter"];

    public function execute(RawDocument $rawDocument): EnrichedDocument
    {
        $parserService = $this->getParserFromSource($rawDocument->source());
        return $parserService->parse($rawDocument);

    }

    private function getParserFromSource(RawDocumentSource $source): Parser
    {
        $this->checkValidSource($source);

        $parser = null;
        switch ($source->value()) {
            case "twitter":
                $parser = new TwitterParser();
                break;
        }

        return $parser;
    }

    private function checkValidSource(RawDocumentSource $source): void
    {
        if (!in_array($source->value(), self::SOURCE_SUPPORTED)) {
            throw new NotSupportedSourceException();
        }
    }
}