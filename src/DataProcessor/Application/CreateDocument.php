<?php

namespace Mpwar\DataProcessor\Application;

use Mpwar\DataProcessor\Domain\Author;
use Mpwar\DataProcessor\Domain\AuthorLocation;
use Mpwar\DataProcessor\Domain\Content;
use Mpwar\DataProcessor\Domain\CreatedAt;
use Mpwar\DataProcessor\Domain\DocumentFactory;
use Mpwar\DataProcessor\Domain\DocumentRepository;
use Mpwar\DataProcessor\Domain\Language;
use Mpwar\DataProcessor\Domain\SourceId;
use Mpwar\DataProcessor\Domain\SourceKeyword;
use Mpwar\DataProcessor\Domain\SourceName;

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
