<?php


namespace Mpwar\DataProcessor\Domain\Repository;

use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentsCollection;

interface RawDocumentsRepository
{
    public function all(): RawDocumentsCollection;
}
