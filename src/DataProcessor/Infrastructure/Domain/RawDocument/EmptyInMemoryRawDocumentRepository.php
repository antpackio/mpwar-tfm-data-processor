<?php

namespace Mpwar\DataProcessor\Infrastructure\Domain\RawDocument;

use Mpwar\DataProcessor\Domain\RawDocument\RawDocument;
use Mpwar\DataProcessor\Domain\RawDocument\RawDocumentsArrayCollection;
use Mpwar\DataProcessor\Domain\RawDocument\RawDocumentsRepository;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\RawDocument\RawDocumentStub;

class EmptyInMemoryRawDocumentRepository implements RawDocumentsRepository
{

    public function all(): RawDocumentsArrayCollection
    {
        echo "RawDocuments retrieved\n";
        return new RawDocumentsArrayCollection(
            RawDocumentStub::validFromTwitter()
        );
    }

    public function first(): ?RawDocument
    {
        // TODO: Implement first() method.
    }
}
