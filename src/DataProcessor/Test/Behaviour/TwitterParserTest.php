<?php

namespace DataProcessor\Test\Behaviour;

use Mockery\Mock;
use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocumentFactory;
use Mpwar\DataProcessor\Domain\Parser\NotSupportedSourceException;
use Mpwar\DataProcessor\Domain\Parser\Twitter\NonWellFormedTweetException;
use Mpwar\DataProcessor\Domain\Parser\Twitter\TwitterParser;
use Mpwar\DataProcessor\Domain\RawDocument\EmptyRawDocumentException;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\EnrichedDocument\EnrichedDocumentAuthorLocationStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\EnrichedDocument\EnrichedDocumentAuthorStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\EnrichedDocument\EnrichedDocumentContentStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\EnrichedDocument\EnrichedDocumentCreatedAtStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\EnrichedDocument\EnrichedDocumentLanguageStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\EnrichedDocument\EnrichedDocumentStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\RawDocument\RawDocumentContentStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\RawDocument\RawDocumentIdStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\RawDocument\RawDocumentKeywordStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\RawDocument\RawDocumentSourceStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\RawDocument\RawDocumentStub;
use Mpwar\DataProcessor\Test\Infrastructure\UnitTestCase;

class TwitterParserTest extends UnitTestCase
{
    /** @var  TwitterParser */
    private $parser;
    /** @var  Mock|EnrichedDocumentFactory */
    private $enrichedDocumentFactory;

    public function setUp()
    {
        parent::setUp();

        $this->enrichedDocumentFactory = $this->mock(EnrichedDocumentFactory::class);
        $this->parser = new TwitterParser($this->enrichedDocumentFactory);
    }

    /** @test */
    public function itShouldThrowAnExceptionIfSourceIsNotTwitter()
    {
        $rawDocument = RawDocumentStub::withInvalidSource();

        $this->expectException(NotSupportedSourceException::class);
        $this->parser->parse($rawDocument);
    }

    /** @test */
    public function itShouldThrowAnExceptionIfEmptyContent()
    {
        $rawDocument = RawDocumentStub::EmptyFromTwitter();

        $this->expectException(EmptyRawDocumentException::class);
        $this->parser->parse($rawDocument);
    }

    /** @test */
    public function itShouldThrowAnExceptionIfInvalidTweetStructure()
    {
        $rawDocument = RawDocumentStub::invalidStructureFromTwitter();

        $this->expectException(NonWellFormedTweetException::class);
        $this->parser->parse($rawDocument);
    }

    /** @test */
    public function itShouldIdentifyProperlyAllAttributes()
    {
        $rawDocument = RawDocumentStub::validFromTwitter();
        $enrichedDocument = EnrichedDocumentStub::create(
            $rawDocument->id(),
            $rawDocument->keyword(),
            $rawDocument->source(),
            EnrichedDocumentContentStub::create('Aggressive Ponytail #freebandnames'),
            EnrichedDocumentCreatedAtStub::create('Mon Sep 24 03:35:21 +0000 2012'),
            EnrichedDocumentAuthorStub::create('Sean Cummings'),
            EnrichedDocumentAuthorLocationStub::create('LA, CA'),
            EnrichedDocumentLanguageStub::create('en')
        );

        $this->enrichedDocumentFactory
            ->shouldReceive('build')
            ->with(
                $rawDocument,
                equalTo(EnrichedDocumentContentStub::create('Aggressive Ponytail #freebandnames')),
                equalTo(EnrichedDocumentCreatedAtStub::create('Mon Sep 24 03:35:21 +0000 2012')),
                equalTo(EnrichedDocumentAuthorStub::create('Sean Cummings')),
                equalTo(EnrichedDocumentAuthorLocationStub::create('LA, CA')),
                equalTo(EnrichedDocumentLanguageStub::create('en'))
                )
            ->once()
            ->andReturn($enrichedDocument);

        $this->assertEquals(
            $enrichedDocument,
            $this->parser->parse($rawDocument)
        );
    }

    /**
     * @test
     */
    public function itShouldSetUndefinedWhenAttributesEqualNull(){
        $rawDocument = RawDocumentStub::validFromTwitterWithNullLanguageAndAuthorFields();
        $enrichedDocument = EnrichedDocumentStub::create(
            $rawDocument->id(),
            $rawDocument->keyword(),
            $rawDocument->source(),
            EnrichedDocumentContentStub::create('Aggressive Ponytail #freebandnames'),
            EnrichedDocumentCreatedAtStub::create('Mon Sep 24 03:35:21 +0000 2012'),
            EnrichedDocumentAuthorStub::create('undefined'),
            EnrichedDocumentAuthorLocationStub::create('undefined'),
            EnrichedDocumentLanguageStub::create('undefined')
        );

        $this->enrichedDocumentFactory
            ->shouldReceive('build')
            ->with(
                $rawDocument,
                equalTo(EnrichedDocumentContentStub::create('Aggressive Ponytail #freebandnames')),
                equalTo(EnrichedDocumentCreatedAtStub::create('Mon Sep 24 03:35:21 +0000 2012')),
                equalTo(EnrichedDocumentAuthorStub::create('undefined')),
                equalTo(EnrichedDocumentAuthorLocationStub::create('undefined')),
                equalTo(EnrichedDocumentLanguageStub::create('undefined'))
            )
            ->once()
            ->andReturn($enrichedDocument);

        $this->assertEquals(
            $enrichedDocument,
            $this->parser->parse($rawDocument)
        );

    }
}
