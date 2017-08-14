<?php

namespace Mpwar\DataProcessor\Domain\EnrichmentService;

use Mpwar\DataProcessor\Domain\Document;
use Mpwar\DataProcessor\Domain\MetadataCollection;

interface EnrichmentService
{
    public function execute(Document $document): MetadataCollection;
}
