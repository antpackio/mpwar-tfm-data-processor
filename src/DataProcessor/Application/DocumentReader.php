<?php

namespace Mpwar\DataProcessor\Application;

use Mpwar\DataProcessor\Domain\Document;

interface DocumentReader
{
    public function next(callable $callback = null): Document;
}
