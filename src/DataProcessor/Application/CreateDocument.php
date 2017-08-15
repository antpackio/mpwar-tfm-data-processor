<?php

namespace Mpwar\DataProcessor\Application;

use Mpwar\DataProcessor\Domain\Document\Author;
use Mpwar\DataProcessor\Domain\Document\AuthorLocation;
use Mpwar\DataProcessor\Domain\Document\Content;
use Mpwar\DataProcessor\Domain\Document\CreatedAt;
use Mpwar\DataProcessor\Domain\Document\DocumentFactory;
use Mpwar\DataProcessor\Domain\Document\DocumentRepository;
use Mpwar\DataProcessor\Domain\Document\Language;
use Mpwar\DataProcessor\Domain\Document\SourceId;
use Mpwar\DataProcessor\Domain\Document\SourceKeyword;
use Mpwar\DataProcessor\Domain\Document\SourceName;

class CreateDocument
{
    /**
     * @var DocumentRepository
     */
    private $enrichedDocumentsRepository;
    /**
     * @var DocumentFactory
     */
    private $factory;

    public function __construct(
        DocumentFactory $factory,
        DocumentRepository $enrichedDocumentsRepository
    )
    {
        $this->factory = $factory;
        $this->enrichedDocumentsRepository = $enrichedDocumentsRepository;
    }

    public function execute(
        SourceId $sourceDocumentId,
        SourceKeyword $sourceKeyword,
        SourceName $sourceName,
        Content $content,
        CreatedAt $createdAt,
        Author $author,
        AuthorLocation $authorLocation,
        Language $language
    ) {
        $document = $this->factory->build(
            $sourceDocumentId,
            $sourceKeyword,
            $sourceName,
            $content,
            $createdAt,
            $author,
            $authorLocation,
            $language
        );
        $this->enrichedDocumentsRepository->save($document);

        return $document;
    }
}
