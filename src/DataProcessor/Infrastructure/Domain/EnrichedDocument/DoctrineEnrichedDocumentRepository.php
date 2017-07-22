<?php

namespace Mpwar\DataProcessor\Infrastructure\Domain\EnrichedDocument;

use Doctrine\ORM\EntityRepository;
use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocument;
use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocumentsRepository;
use Mpwar\DataProcessor\Domain\RawDocument\RawDocumentId;

class DoctrineEnrichedDocumentRepository extends EntityRepository implements EnrichedDocumentsRepository
{
    public function save(EnrichedDocument $enrichedDocument): void
    {
        $entityManager = $this->getEntityManager();

        $entityManager->persist(
            new DoctrineEnrichedDocument($enrichedDocument)
        );

        $entityManager->flush();
    }

    public function hasRawDocumentId(RawDocumentId $rawDocumentId
    ): ?EnrichedDocument
    {
        $results = $this->findByRawDocumentId($rawDocumentId->value());
        return array_shift($results);
    }
}
