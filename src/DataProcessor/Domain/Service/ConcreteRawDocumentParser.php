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

class ConcreteRawDocumentParser implements RawDocumentParser
{

    public function execute(RawDocument $rawDocument): EnrichedDocument
    {
        return new EnrichedDocument($rawDocument->id(), $rawDocument->source());
    }
}