<?php

namespace Mpwar\DataProcessor\Domain\Entity;

use Mpwar\DataProcessor\Domain\ValueObject\EnrichedDocumentAuthor;
use Mpwar\DataProcessor\Domain\ValueObject\EnrichedDocumentAuthorLocation;
use Mpwar\DataProcessor\Domain\ValueObject\EnrichedDocumentContent;
use Mpwar\DataProcessor\Domain\ValueObject\EnrichedDocumentCreatedAt;
use Mpwar\DataProcessor\Domain\ValueObject\EnrichedDocumentLanguage;
use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentContent;
use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentId;
use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentKeyword;
use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentSource;

class EnrichedDocument
{
    private $rawDocument;
    private $content;
    private $createdAt;
    private $author;
    private $authorLocation;
    private $language;

    private function __construct(
        RawDocument $rawDocument
    ) {
        $this->rawDocument = $rawDocument;
        $this->content = null;
        $this->createdAt = null;
        $this->author = null;
        $this->authorLocation = null;
        $this->language = null;
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

    public function setContent(EnrichedDocumentContent $content): void
    {
        $this->content = $content;
    }

    public function setCreatedAt(EnrichedDocumentCreatedAt $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function rawDocumentContent(): RawDocumentContent
    {
        return $this->rawDocument->content();
    }

    public function setAuthor(EnrichedDocumentAuthor $author): void
    {
        $this->author = $author;
    }

    public function author(): ?EnrichedDocumentAuthor
    {
        return $this->author;
    }

    public function authorLocation(): ?EnrichedDocumentAuthorLocation
    {
        return $this->authorLocation;
    }

    public function setAuthorLocation(
        EnrichedDocumentAuthorLocation $authorLocation
    ): void {
        $this->authorLocation = $authorLocation;
    }

    public function language(): ?EnrichedDocumentLanguage
    {
        return $this->language;
    }

    public function setLanguage(EnrichedDocumentLanguage $language)
    {
        $this->language = $language;
    }
}
