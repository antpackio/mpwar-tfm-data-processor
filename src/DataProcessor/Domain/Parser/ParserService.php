<?php

namespace Mpwar\DataProcessor\Domain\Parser;

use Mpwar\DataProcessor\Domain\RawDocument\RawDocumentSource;

interface ParserService
{
    public function execute(RawDocumentSource $source): Parser;
}