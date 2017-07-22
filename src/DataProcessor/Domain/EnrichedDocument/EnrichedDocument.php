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

    public function __construct(
        RawDocumentId $rawDocumentId,
        RawDocumentKeyword $rawDocumentKeyword,
        RawDocumentSource $rawDocumentSource,
        EnrichedDocumentContent $content,
        EnrichedDocumentCreatedAt $createdAt,
        EnrichedDocumentAuthor $author,
        EnrichedDocumentAuthorLocation $authorLocation,
        EnrichedDocumentLanguage $language
    ) {
        $this->setRawDocumentId($rawDocumentId);
        $this->setKeyword($rawDocumentKeyword);
        $this->setSource($rawDocumentSource);
        $this->setContent($content);
        $this->setCreatedAt($createdAt);
        $this->setAuthor($author);
        $this->setAuthorLocation($authorLocation);
        $this->setLanguage($language);
        $this->metadata = new EnrichedDocumentMetadataCollection();
    }

    public function source(): RawDocumentSource
    {
        return $this->source;
    }

    protected function setSource($rawDocumentSource): void
    {
        $this->source = $rawDocumentSource;
    }

    public function content(): EnrichedDocumentContent
    {
        return $this->content;
    }

    protected function setContent(EnrichedDocumentContent $content): void
    {
        $this->content = $content;
    }

    public function createdAt(): EnrichedDocumentCreatedAt
    {
        return $this->createdAt;
    }

    protected function setCreatedAt(EnrichedDocumentCreatedAt $createdAt): void
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

    public function author(): EnrichedDocumentAuthor
    {
        return $this->author;
    }

    protected function setAuthor(EnrichedDocumentAuthor $author): void
    {
        $this->author = $author;
    }

    public function authorLocation(): EnrichedDocumentAuthorLocation
    {
        return $this->authorLocation;
    }

    protected function setAuthorLocation(EnrichedDocumentAuthorLocation $authorLocation): void
    {
        $this->authorLocation = $authorLocation;
    }

    public function language(): EnrichedDocumentLanguage
    {
        return $this->language;
    }

    protected function setLanguage(EnrichedDocumentLanguage $language)
    {
        $this->language = $language;
    }

    public function metadata(): EnrichedDocumentMetadataCollection
    {
        return $this->metadata;
    }

    public function addMetadata(EnrichedDocumentMetadata $metadata)
    {
        $this->metadata()->add($metadata);
    }
}
