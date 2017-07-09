<?php

namespace Mpwar\DataProcessor\Domain\EnrichedDocument;

use Mpwar\DataProcessor\Domain\Entity\RawDocument;
use Mpwar\DataProcessor\Domain\EnrichedDocument\Author;
use Mpwar\DataProcessor\Domain\EnrichedDocument\AuthorLocation;
use Mpwar\DataProcessor\Domain\EnrichedDocument\Content;
use Mpwar\DataProcessor\Domain\EnrichedDocument\CreatedAt;
use Mpwar\DataProcessor\Domain\EnrichedDocument\Language;
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
    private $metadata;

    private function __construct(
        RawDocument $rawDocument
    )
    {
        $this->rawDocument = $rawDocument;
        $this->content = null;
        $this->createdAt = null;
        $this->author = null;
        $this->authorLocation = null;
        $this->language = null;
        $this->metadata = new MetadataCollection();
    }

    public static function fromRawDocument(RawDocument $rawDocument): self
    {
        return new self($rawDocument);
    }

    public function source(): RawDocumentSource
    {
        return $this->rawDocument->source();
    }

    public function content(): ?Content
    {
        return $this->content;
    }

    public function createdAt(): ?CreatedAt
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

    public function setContent(Content $content): void
    {
        $this->content = $content;
    }

    public function setCreatedAt(CreatedAt $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function rawDocumentContent(): RawDocumentContent
    {
        return $this->rawDocument->content();
    }

    public function setAuthor(Author $author): void
    {
        $this->author = $author;
    }

    public function author(): ?Author
    {
        return $this->author;
    }

    public function authorLocation(): ?AuthorLocation
    {
        return $this->authorLocation;
    }

    public function setAuthorLocation(
        AuthorLocation $authorLocation
    ): void
    {
        $this->authorLocation = $authorLocation;
    }

    public function language(): ?Language
    {
        return $this->language;
    }

    public function setLanguage(Language $language)
    {
        $this->language = $language;
    }

    public function metadata(): MetadataCollection
    {
        return $this->metadata;
    }

    public function addMetadata(Metadata $metadata)
    {
        $this->metadata()->add($metadata);
    }
}
