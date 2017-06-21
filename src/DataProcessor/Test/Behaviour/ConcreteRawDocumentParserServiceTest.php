<?php
/**
 * Created by PhpStorm.
 * User: Carles
 * Date: 15/06/2017
 * Time: 17:56
 */

namespace Mpwar\DataProcessor\Test\Behaviour;


use Mpwar\DataProcessor\Test\Infrastructure\Stub\TweetContent;
use Mpwar\DataProcessor\Domain\Entity\EnrichedDocument;
use Mpwar\DataProcessor\Domain\Exception\NotSupportedSourceException;
use Mpwar\DataProcessor\Domain\Service\ConcreteRawDocumentParserService;
use Mpwar\DataProcessor\Domain\Service\RawDocumentParserService;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\EnrichedDocumentStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\RawDocumentStub;
use Mpwar\DataProcessor\Test\Infrastructure\UnitTestCase;


class ConcreteRawDocumentParserServiceTest extends UnitTestCase
{
    use TweetContent;
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
        $rawDocumentFromTwitter = RawDocumentStub::customContentFromTwitter($this->getTweet());
        $this->assertInstanceOf(EnrichedDocument::class, $this->rawDocumentParser->execute($rawDocumentFromTwitter));
    }

    /** @test */
    public function itShouldThrowAndExceptionWhenNotCorrectSource()
    {
        $invalidRawDocument = RawDocumentStub::withInvalidSource();
        $this->expectException(NotSupportedSourceException::class);
        $this->rawDocumentParser->execute($invalidRawDocument);
    }
}