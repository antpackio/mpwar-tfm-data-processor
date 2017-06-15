<?php

namespace Mpwar\DataProcessor\Domain\Service;

use Mpwar\DataProcessor\Domain\Entity\EnrichedDocument;
use Mpwar\DataProcessor\Domain\Entity\RawDocument;

interface RawDocumentParserService
{
    public function execute(RawDocument $rawDocument): EnrichedDocument;
}