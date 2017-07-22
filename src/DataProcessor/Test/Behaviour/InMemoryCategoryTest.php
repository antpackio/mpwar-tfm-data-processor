<?php
/**
 * Created by PhpStorm.
 * User: Carles
 * Date: 05/07/2017
 * Time: 18:42
 */

namespace Mpwar\DataProcessor\Test\Behaviour;

use Mpwar\DataProcessor\Infrastructure\Domain\EnrichmentService\Category\InMemoryCategory;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\EnrichedDocumentStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\RawDocumentStub;
use Mpwar\DataProcessor\Test\Infrastructure\UnitTestCase;

class InMemoryCategoryTest extends UnitTestCase
{

    /** @test */
    public function itShouldReturnAnEmptyMetadataCollectionWhenNoValidKeyword()
    {
        $inMemoryCategory = new InMemoryCategory();

        $rawDocument = RawDocumentStub::validFromTwitter();
        $enrichedDocument = EnrichedDocumentStub::create(
            $rawDocument
        );

        $resultEnrichedDocument =  $inMemoryCategory->execute($enrichedDocument);
        $this->assertEquals(0,$resultEnrichedDocument->metadata()->count());
    }

    /** @test */
    public function itShouldAddCategoryMetadataIntoEnrichedDocumentMetadataWhenValidKeyword()
    {
        $inMemoryCategory = new InMemoryCategory();
        $category = ["health","summer","skin"];
        $rawDocument = RawDocumentStub::withCustomKeyword("sunscreen");
        $enrichedDocument = EnrichedDocumentStub::create(
            $rawDocument
        );

        $resultEnrichedDocument =  $inMemoryCategory->execute($enrichedDocument);
        $this->assertEquals($category,$resultEnrichedDocument->metadata()->current()->value);
    }

}