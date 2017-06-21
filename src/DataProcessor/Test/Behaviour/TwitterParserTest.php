<?php
/**
 * Created by PhpStorm.
 * User: Carles
 * Date: 21/06/2017
 * Time: 18:21
 */

namespace DataProcessor\Test\Behaviour;




use Mpwar\DataProcessor\Domain\Exception\EmptyRawDocumentException;
use Mpwar\DataProcessor\Domain\Exception\NotSupportedSourceException;
use Mpwar\DataProcessor\Domain\Service\TwitterParser;
use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentSource;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\EnrichedDocumentStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\RawDocumentStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\TweetContent;
use Mpwar\DataProcessor\Test\Infrastructure\UnitTestCase;

class TwitterParserTest extends UnitTestCase
{
    use TweetContent;

    public function setUp()
    {

    }

    /** @test */
    public function itShouldThrowAnExceptionIfSourceIsNotTwitter()
    {
        $rawDocument = RawDocumentStub::withInvalidSource();
        $twitterParser = new TwitterParser();

        $this->expectException(NotSupportedSourceException::class);
        $twitterParser->parse($rawDocument);

    }

    /** @test */
    public function itShouldThrowAnExceptionIfEmptyContent()
    {
        $rawDocument = RawDocumentStub::EmptyFromTwitter();
        $twitterParser = new TwitterParser();

        $this->expectException(EmptyRawDocumentException::class);
        $twitterParser->parse($rawDocument);

    }

    /** @test */
    public function itShouldIdentifyProperlyContent()
    {
        $rawDocument = RawDocumentStub::customContentFromTwitter($this->getTweet());
        $enrichedDocument = EnrichedDocumentStub::customContent("Aggressive Ponytail #freebandnames");
        $twitterParser = new TwitterParser();

        $returnedEnrichedDocument = $twitterParser->parse($rawDocument);
        $this->assertEquals($enrichedDocument->content()->value(), $returnedEnrichedDocument->content()->value());

    }
}