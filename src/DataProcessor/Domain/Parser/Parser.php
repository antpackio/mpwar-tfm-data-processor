<?php
/**
 * Created by PhpStorm.
 * User: Carles
 * Date: 15/06/2017
 * Time: 19:33
 */

namespace Mpwar\DataProcessor\Domain\Parser;


use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichDocument;
use Mpwar\DataProcessor\Domain\RawDocument\RawDocument;

interface Parser
{
    public function parse(RawDocument $rawDocument): EnrichDocument;
}
