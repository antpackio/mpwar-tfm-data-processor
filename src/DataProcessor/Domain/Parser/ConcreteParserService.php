<?php

namespace Mpwar\DataProcessor\Domain\Parser;

use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocument;
use Mpwar\DataProcessor\Domain\Exception\NotSupportedSourceException;
use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentSource;

class ConcreteParserService implements ParserService
{
    const SOURCE_SUPPORTED = ["twitter"];

    public function execute(EnrichedDocument $enrichedDocument): EnrichedDocument
    {
        $parserService = $this->getParserFromSource($enrichedDocument->source());
        return $parserService->parse($enrichedDocument);
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