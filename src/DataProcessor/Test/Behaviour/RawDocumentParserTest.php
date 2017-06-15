<?php
/**
 * Created by PhpStorm.
 * User: Carles
 * Date: 15/06/2017
 * Time: 17:56
 */

namespace Mpwar\DataProcessor\Test\Behaviour;


use Mpwar\DataProcessor\Domain\Exception\NotSupportedSourceException;
use Mpwar\DataProcessor\Domain\Service\ConcreteRawDocumentParserService;
use Mpwar\DataProcessor\Domain\Service\RawDocumentParserService;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\EnrichedDocumentStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\RawDocumentStub;
use Mpwar\DataProcessor\Test\Infrastructure\UnitTestCase;


class RawDocumentParserTest extends UnitTestCase
{
    /**
     * @var RawDocumentParserService
     */
    private $rawDocumentParser;

    public function setUp()
    {
        parent::setUp();
        $this->rawDocumentParser = new ConcreteRawDocumentParserService();
    }

    /** @test */
    public function itShouldPass()
    {
        $rawDocumentFromTwitter = RawDocumentStub::randomFromTwitter();
        $enrichedDocument = EnrichedDocumentStub::fromRawDocument($rawDocumentFromTwitter);

        $this->assertEquals($enrichedDocument, $this->rawDocumentParser->execute($rawDocumentFromTwitter));
    }

    /** @test */
    public function itShouldThrowAndExceptionWhenNotCorrectSource()
    {
        $invalidRawDocument = RawDocumentStub::withInvalidSource();
        $this->expectException(NotSupportedSourceException::class);
        $this->rawDocumentParser->execute($invalidRawDocument);
    }
}