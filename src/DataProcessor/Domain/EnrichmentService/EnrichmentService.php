<?php

namespace Mpwar\DataProcessor\Domain\EnrichmentService;

use Mpwar\DataProcessor\Domain\Document\Document;
use Mpwar\DataProcessor\Domain\Document\MetadataCollection;

interface EnrichmentService
{
    public function execute(Document $document): MetadataCollection;
}
