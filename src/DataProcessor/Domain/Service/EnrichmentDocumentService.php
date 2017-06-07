<?php


namespace Mpwar\DataProcessor\Domain\Service;


use Mpwar\DataProcessor\Domain\Entity\RawDocument;

interface EnrichmentDocumentService
{

    public function execute(RawDocument $rawDocument);
}