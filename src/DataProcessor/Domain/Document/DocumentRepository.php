<?php

namespace Mpwar\DataProcessor\Domain\Document;

interface DocumentRepository
{
    public function save(Document $document): void;
}
