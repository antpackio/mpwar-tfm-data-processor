<?php

namespace Mpwar\DataProcessor\Domain\EnrichedDocument;

use Mpwar\DataProcessor\Domain\Entity\RawDocument;
use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentContent;
use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentId;
use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentKeyword;
use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentSource;

class EnrichedDocument
{
    const UNDEFINED_TAG = 'undefined';
    protected $rawDocumentId;
    protected $rawDocumentContent;
    protected $content;
    protected $createdAt;
    protected $author;
    protected $authorLocation;
    protected $language;
    protected $metadata;
    protected $keyword;
    protected $source;

    protected function __construct(
        RawDocumentId $rawDocumentId,
        RawDocumentContent $rawDocumentContent,
        RawDocumentKeyword $rawDocumentKeyword,
        RawDocumentSource $rawDocumentSource,
        ?Content $content,
        ?CreatedAt $createdAt,
        ?Author $author,
        ?AuthorLocation $authorLocation,
        ?Language $language,
        MetadataCollection $metadata
    )
    {
        $this->rawDocumentId = $rawDocumentId;
        $this->rawDocumentContent = $rawDocumentContent;
        $this->keyword = $rawDocumentKeyword;
        $this->source = $rawDocumentSource;
        $this->content = $content;
        $this->createdAt = $createdAt;
        $this->author = $author;
        $this->authorLocation = $authorLocation;
        $this->language = $language;
        $this->metadata = $metadata;
    }

    public static function fromRawDocument(RawDocument $rawDocument): self
    {
        return new self(
            $rawDocument->id(),
            $rawDocument->content(),
            $rawDocument->keyword(),
            $rawDocument->source(),
            null,
            null,
            null,
            null,
            null,
            new MetadataCollection()
        );
    }

    public function source(): RawDocumentSource
    {
        return $this->source;
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
        return $this->keyword;
    }

    public function rawDocumentId(): RawDocumentId
    {
        return $this->rawDocumentId;
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
        return $this->rawDocumentContent;
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
