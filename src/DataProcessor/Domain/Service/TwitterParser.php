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

class TwitterParser implements Parser
{

    public function parse(RawDocument $rawDocument): EnrichedDocument
    {
        return new EnrichedDocument($rawDocument->id(), $rawDocument->source());
    }
}