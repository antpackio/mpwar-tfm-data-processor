<?php

namespace Mpwar\DataProcessor\Infrastructure\Domain\Document;

use Doctrine\ORM\EntityRepository;
use Mpwar\DataProcessor\Domain\Document;
use Mpwar\DataProcessor\Domain\DocumentRepository;

class DoctrineDocumentRepository extends EntityRepository implements DocumentRepository
{
    public function save(Document $document): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($document);
        $entityManager->flush();
    }
}
