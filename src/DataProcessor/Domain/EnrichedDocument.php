<?php

namespace Mpwar\DataProcessor\Domain;

class EnrichedDocument extends Document
{

    private $metadataCollection;

    public static function fromDocument(Document $document)
    {
        return new self(
            $document->sourceDocumentId(),
            $document->sourceKeyword(),
            $document->sourceName(),
            $document->content(),
            $document->createdAt(),
            $document->author(),
            $document->authorLocation(),
            $document->language()
        );
    }

    /**
     * @return MetadataCollection
     */
    public function metadataCollection(): MetadataCollection
    {
        return $this->metadataCollection;
    }

    public function __construct(
        SourceDocumentId $sourceDocumentId,
        SourceKeyword $sourceKeyword,
        SourceName $sourceName,
        Content $content,
        CreatedAt $createdAt,
        Author $author,
        AuthorLocation $authorLocation,
        Language $language
    ) {
        parent::__construct(
            $sourceDocumentId,
            $sourceKeyword,
            $sourceName,
            $content,
            $createdAt,
            $author,
            $authorLocation,
            $language
        );

        $this->metadataCollection = new MetadataCollection();
    }

}
