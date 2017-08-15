<?php

namespace Mpwar\DataProcessor\Test\Behaviour;

use Mpwar\DataProcessor\Infrastructure\Domain\EnrichmentService\InMemoryCategory;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\AuthorLocationStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\AuthorStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\ContentStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\CreatedAtStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\DocumentStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\LanguageStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\SourceDocumentIdStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\SourceKeywordStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\SourceNameStub;
use Mpwar\DataProcessor\Test\Infrastructure\UnitTestCase;

class InMemoryCategoryTest extends UnitTestCase
{

    /** @var  InMemoryCategory */
    private $inMemoryCategory;

    public function setUp()
    {
        $this->inMemoryCategory = new InMemoryCategory();
    }

    /** @test */
    public function itShouldReturnAnEmptyMetadataCollectionWhenNoValidKeyword()
    {
        $enrichedDocument = DocumentStub::create(
            SourceDocumentIdStub::random(),
            SourceKeywordStub::create('notValid'),
            SourceNameStub::random(),
            ContentStub::random(),
            CreatedAtStub::random(),
            AuthorStub::random(),
            AuthorLocationStub::random(),
            LanguageStub::random()
        );

        $metadataCollection = $this->inMemoryCategory->execute($enrichedDocument);
        $this->assertEquals(null, $metadataCollection->get('category'));
    }

    /** @test */
    public function itShouldAddCategoryMetadataIntoEnrichedDocumentMetadataWhenValidKeyword()
    {
        $enrichedDocument = DocumentStub::create(
            SourceDocumentIdStub::random(),
            SourceKeywordStub::create('sunscreen'),
            SourceNameStub::random(),
            ContentStub::random(),
            CreatedAtStub::random(),
            AuthorStub::random(),
            AuthorLocationStub::random(),
            LanguageStub::random()
        );

        $metadataCollection = $this->inMemoryCategory->execute($enrichedDocument);
        $this->assertEquals(['health', 'summer', 'skin'], $metadataCollection->get('category')->value());
    }
}
