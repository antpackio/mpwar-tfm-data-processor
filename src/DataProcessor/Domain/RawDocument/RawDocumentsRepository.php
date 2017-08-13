<?php


namespace Mpwar\DataProcessor\Domain\RawDocument;

interface RawDocumentsRepository
{
    public function all(): RawDocumentsArrayCollection;

    public function first(): ?RawDocument;
}
