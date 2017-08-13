<?php
/**
 * Created by PhpStorm.
 * User: Carles
 * Date: 05/07/2017
 * Time: 18:42
 */

namespace Mpwar\DataProcessor\Test\Behaviour;

use Mpwar\DataProcessor\Infrastructure\Domain\EnrichmentService\InMemoryCategory;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\EnrichedDocument\EnrichedDocumentAuthorLocationStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\EnrichedDocument\EnrichedDocumentAuthorStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\EnrichedDocument\EnrichedDocumentContentStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\EnrichedDocument\EnrichedDocumentCreatedAtStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\EnrichedDocument\EnrichedDocumentLanguageStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\EnrichedDocument\EnrichedDocumentStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\RawDocument\RawDocumentIdStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\RawDocument\RawDocumentKeywordStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\RawDocument\RawDocumentSourceStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\RawDocument\RawDocumentStub;
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
        $enrichedDocument = EnrichedDocumentStub::create(
            RawDocumentIdStub::random(),
            RawDocumentKeywordStub::random(),
            RawDocumentSourceStub::twitter(),
            EnrichedDocumentContentStub::random(),
            EnrichedDocumentCreatedAtStub::random(),
            EnrichedDocumentAuthorStub::random(),
            EnrichedDocumentAuthorLocationStub::random(),
            EnrichedDocumentLanguageStub::random()
        );

        $resultEnrichedDocument = $this->inMemoryCategory->execute($enrichedDocument);
        $this->assertEquals(0, $resultEnrichedDocument->metadata()->count());
    }

    /** @test */
    public function itShouldAddCategoryMetadataIntoEnrichedDocumentMetadataWhenValidKeyword()
    {
        $category = ["health", "summer", "skin"];
        $enrichedDocument = EnrichedDocumentStub::create(
            RawDocumentIdStub::random(),
            RawDocumentKeywordStub::create('sunscreen'),
            RawDocumentSourceStub::twitter(),
            EnrichedDocumentContentStub::random(),
            EnrichedDocumentCreatedAtStub::random(),
            EnrichedDocumentAuthorStub::random(),
            EnrichedDocumentAuthorLocationStub::random(),
            EnrichedDocumentLanguageStub::random()
        );

        $resultEnrichedDocument = $this->inMemoryCategory->execute($enrichedDocument);
        $this->assertEquals($category, $resultEnrichedDocument->metadata()->current()->value);
    }

}