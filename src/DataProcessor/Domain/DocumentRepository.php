<?php

namespace Mpwar\DataProcessor\Domain;

interface DocumentRepository
{
    public function save(Document $document): void;
}
