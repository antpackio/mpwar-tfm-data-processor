<?php

namespace Mpwar\DataProcessor\Domain\Entity;

use Mpwar\DataProcessor\Domain\ValueObject\EnrichedDocumentContent;
use Mpwar\DataProcessor\Domain\ValueObject\EnrichedDocumentCreatedAt;
use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentContent;
use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentId;
use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentKeyword;
use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentSource;

class EnrichedDocument
{
    private $rawDocument;
    private $content;
    private $createdAt;

    private function __construct(
        RawDocument $rawDocument
    ) {
        $this->rawDocument = $rawDocument;
        $this->content = null;
        $this->createdAt = null;
    }

    public static function fromRawDocument(RawDocument $rawDocument): self
    {
        return new self($rawDocument);
    }

    public function source(): RawDocumentSource
    {
        return $this->rawDocument->source();
    }

    public function content(): ?EnrichedDocumentContent
    {
        return $this->content;
    }

    public function createdAt(): ?EnrichedDocumentCreatedAt
    {
        return $this->createdAt;
    }

    public function keyword(): RawDocumentKeyword
    {
        return $this->rawDocument->keyword();
    }

    public function rawDocumentId(): RawDocumentId
    {
        return $this->rawDocument->id();
    }

    public function setContent(EnrichedDocumentContent $content)
    {
        $this->content = $content;
    }

    public function setCreatedAt(EnrichedDocumentCreatedAt $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function rawDocumentContent(): RawDocumentContent
    {
        return $this->rawDocument->content();
    }
}