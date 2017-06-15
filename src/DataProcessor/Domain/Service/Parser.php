<?php
/**
 * Created by PhpStorm.
 * User: Carles
 * Date: 15/06/2017
 * Time: 19:33
 */

namespace Mpwar\DataProcessor\Domain\Service;


use Mpwar\DataProcessor\Domain\Entity\EnrichedDocument;
use Mpwar\DataProcessor\Domain\Entity\RawDocument;

interface Parser
{
    public function parse(RawDocument $rawDocument): EnrichedDocument;


}