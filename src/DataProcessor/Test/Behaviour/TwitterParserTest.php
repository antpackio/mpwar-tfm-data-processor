<?php

namespace DataProcessor\Test\Behaviour;

use Mockery\Mock;
use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocumentFactory;
use Mpwar\DataProcessor\Domain\Parser\NotSupportedSourceException;
use Mpwar\DataProcessor\Domain\Parser\Twitter\NonWellFormedTweetException;
use Mpwar\DataProcessor\Domain\Parser\Twitter\TwitterParser;
use Mpwar\DataProcessor\Domain\RawDocument\EmptyRawDocumentException;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\EnrichedDocumentAuthorLocationStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\EnrichedDocumentAuthorStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\EnrichedDocumentContentStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\EnrichedDocumentCreatedAtStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\EnrichedDocumentLanguageStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\EnrichedDocumentStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\RawDocumentContentStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\RawDocumentIdStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\RawDocumentKeywordStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\RawDocumentSourceStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\RawDocumentStub;
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
            $rawDocument,
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
    public function itShouldIdentifyProperlyCreationDate()
    {
        $rawDocument = RawDocumentStub::validFromTwitter();
        $customCreatedAt = EnrichedDocumentCreatedAtStub::create(
            'Mon Sep 24 03:35:21 +0000 2012'
        );

        $returnedEnrichedDocument = $this->parser->parse($rawDocument);
        $this->assertEquals(
            $customCreatedAt->value(),
            $returnedEnrichedDocument->createdAt()->value()
        );
    }

    /**
    * @test
    */
    public function itShouldIdentifyProperlyAuthor()
    {
        $rawDocument = RawDocumentStub::validFromTwitter();

        $returnedEnrichedDocument = $this->parser->parse($rawDocument);
        $this->assertEquals(
            'Sean Cummings',
            $returnedEnrichedDocument->author()->value()
        );
    }

    /**
    * @test
    */
    public function itShouldIdentifyProperlyAuthorLocation()
    {
        $rawDocument = RawDocumentStub::validFromTwitter();

        $returnedEnrichedDocument = $this->parser->parse($rawDocument);
        $this->assertEquals(
            'LA, CA',
            $returnedEnrichedDocument->authorLocation()->value()
        );
    }

    /**
    * @test
    */
    public function itShouldSetUndefinedAuthorLocation()
    {
        $rawDocument = RawDocumentStub::create(
            RawDocumentIdStub::random(),
            RawDocumentSourceStub::twitter(),
            RawDocumentKeywordStub::random(),
            RawDocumentContentStub::validFromTwitterWithNullUserLocation()
        );

        $returnedEnrichedDocument = $this->parser->parse($rawDocument);
        $this->assertEquals(
            'undefined',
            $returnedEnrichedDocument->authorLocation()->value()
        );
    }

    /**
     * @test
     */
    public function itShouldIdentifyProperlyLanguage()
    {
        $rawDocument = RawDocumentStub::validFromTwitter();

        $returnedEnrichedDocument = $this->parser->parse($rawDocument);
        $this->assertEquals(
            'en',
            $returnedEnrichedDocument->language()->value()
        );
    }

    /**
     * @test
     */
    public function itShouldSetUndefinedLanguage()
    {
        $rawDocument = RawDocumentStub::create(
            RawDocumentIdStub::random(),
            RawDocumentSourceStub::twitter(),
            RawDocumentKeywordStub::random(),
            RawDocumentContentStub::validFromTwitterWithNullLanguage()
        );

        $returnedEnrichedDocument = $this->parser->parse($rawDocument);
        $this->assertEquals(
            'undefined',
            $returnedEnrichedDocument->language()
        );
    }
}
