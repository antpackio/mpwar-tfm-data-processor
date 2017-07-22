<?php

namespace Mpwar\DataProcessor\Domain\EnrichedDocument;

use Mpwar\DataProcessor\Domain\RawDocument\RawDocumentId;
use Mpwar\DataProcessor\Domain\RawDocument\RawDocumentKeyword;
use Mpwar\DataProcessor\Domain\RawDocument\RawDocumentSource;

class EnrichedDocument
{
    const UNDEFINED_TAG = 'undefined';

    protected $rawDocumentId;
    protected $keyword;
    protected $source;
    protected $content;
    protected $createdAt;
    protected $author;
    protected $authorLocation;
    protected $language;
    protected $metadata;

    protected function __construct(
        RawDocumentId $rawDocumentId,
        RawDocumentKeyword $rawDocumentKeyword,
        RawDocumentSource $rawDocumentSource,
        Content $content,
        CreatedAt $createdAt,
        Author $author,
        AuthorLocation $authorLocation,
        Language $language
    ) {
        $this->setRawDocumentId($rawDocumentId);
        $this->setKeyword($rawDocumentKeyword);
        $this->setSource($rawDocumentSource);
        $this->setContent($content);
        $this->setCreatedAt($createdAt);
        $this->setAuthor($author);
        $this->setAuthorLocation($authorLocation);
        $this->setLanguage($language);
        $this->metadata = new MetadataCollection();
    }

    public function source(): RawDocumentSource
    {
        return $this->source;
    }

    protected function setSource($rawDocumentSource): void
    {
        $this->source = $rawDocumentSource;
    }

    public function content(): Content
    {
        return $this->content;
    }

    protected function setContent(Content $content): void
    {
        $this->content = $content;
    }

    public function createdAt(): CreatedAt
    {
        return $this->createdAt;
    }

    protected function setCreatedAt(CreatedAt $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function keyword(): RawDocumentKeyword
    {
        return $this->keyword;
    }

    protected function setKeyword($rawDocumentKeyword): void
    {
        $this->keyword = $rawDocumentKeyword;
    }

    public function rawDocumentId(): RawDocumentId
    {
        return $this->rawDocumentId;
    }

    protected function setRawDocumentId($rawDocumentId): void
    {
        $this->rawDocumentId = $rawDocumentId;
    }

    public function author(): Author
    {
        return $this->author;
    }

    protected function setAuthor(Author $author): void
    {
        $this->author = $author;
    }

    public function authorLocation(): AuthorLocation
    {
        return $this->authorLocation;
    }

    protected function setAuthorLocation(AuthorLocation $authorLocation): void
    {
        $this->authorLocation = $authorLocation;
    }

    public function language(): Language
    {
        return $this->language;
    }

    protected function setLanguage(Language $language)
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
