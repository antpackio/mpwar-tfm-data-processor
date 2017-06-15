<?php
/**
 * Created by PhpStorm.
 * User: Carles
 * Date: 15/06/2017
 * Time: 17:56
 */

namespace Mpwar\DataProcessor\Test\Behaviour;


use Mpwar\DataProcessor\Domain\Service\ConcreteRawDocumentParser;
use Mpwar\DataProcessor\Domain\Service\RawDocumentParser;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\EnrichedDocumentStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\RawDocumentStub;
use Mpwar\DataProcessor\Test\Infrastructure\UnitTestCase;

class RawDocumentParserTest extends UnitTestCase
{
    /**
     * @var RawDocumentParser
     */
    private $rawDocumentParser;

    public function setUp()
    {
        parent::setUp();
        $this->rawDocumentParser = new ConcreteRawDocumentParser();
    }

    /** @test */
    public function itShould()
    {
        $rawDocumentFromTwitter = RawDocumentStub::randomFromTwitter();
        $enrichedDocument = EnrichedDocumentStub::fromRawDocument($rawDocumentFromTwitter);

        $this->assertEquals($enrichedDocument,  $this->rawDocumentParser->execute($rawDocumentFromTwitter));
    }
}