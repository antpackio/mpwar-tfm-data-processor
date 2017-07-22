<?php

namespace Mpwar\DataProcessor\Infrastructure\Domain\RawDocument;

use Mpwar\DataProcessor\Domain\RawDocument\RawDocumentsCollection;
use Mpwar\DataProcessor\Domain\RawDocument\RawDocumentsRepository;
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
