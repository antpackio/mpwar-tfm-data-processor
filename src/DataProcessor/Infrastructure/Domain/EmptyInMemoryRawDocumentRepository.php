<?php

namespace Mpwar\DataProcessor\Infrastructure\Domain;

use Mpwar\DataProcessor\Domain\Repository\RawDocumentsRepository;
use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentsCollection;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\RawDocumentStub;

class EmptyInMemoryRawDocumentRepository implements RawDocumentsRepository
{

    public function all(): RawDocumentsCollection
    {
        echo "RawDocuments retrieved\n";
        return new RawDocumentsCollection(
            RawDocumentStub::validFromTwitter()
        );
    }
}
