<?php

namespace Mpwar\DataProcessor\Domain\Parser;

use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocumentFactory;
use Mpwar\DataProcessor\Domain\Parser\Twitter\TwitterParser;
use Mpwar\DataProcessor\Domain\RawDocument\RawDocumentSource;

class ConcreteParserService implements ParserService
{
    const SOURCE_SUPPORTED = [
        TwitterParser::SOURCE
    ];
    private $enrichedDocumentFactory;

    public function __construct(EnrichedDocumentFactory $enrichedDocumentFactory)
    {
        $this->enrichedDocumentFactory = $enrichedDocumentFactory;
    }

    public function execute(RawDocumentSource $source): Parser
    {
        return $this->getParserFromSource($source);
    }

    private function getParserFromSource(RawDocumentSource $source): Parser
    {
        $this->checkValidSource($source);

        $parser = null;
        switch ($source->value()) {
            case "twitter":
                $parser = new TwitterParser($this->enrichedDocumentFactory);
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