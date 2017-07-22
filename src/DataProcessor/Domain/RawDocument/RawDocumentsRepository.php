<?php


namespace Mpwar\DataProcessor\Domain\RawDocument;

interface RawDocumentsRepository
{
    public function all(): RawDocumentsCollection;

    public function first(): ?RawDocument;
}
