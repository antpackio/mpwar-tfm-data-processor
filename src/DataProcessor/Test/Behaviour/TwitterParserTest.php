<?php

namespace DataProcessor\Test\Behaviour;

use Mpwar\DataProcessor\Domain\Exception\EmptyRawDocumentException;
use Mpwar\DataProcessor\Domain\Exception\NonWellFormedTweetException;
use Mpwar\DataProcessor\Domain\Exception\NotSupportedSourceException;
use Mpwar\DataProcessor\Domain\Service\TwitterParser;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\EnrichedDocumentCreatedAtStub;
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

    public function setUp()
    {
        parent::setUp();

        $this->parser = new TwitterParser();
    }

    /** @test */
    public function itShouldThrowAnExceptionIfSourceIsNotTwitter()
    {
        $rawDocument = RawDocumentStub::withInvalidSource();
        $enrichedDocument = EnrichedDocumentStub::create($rawDocument);

        $this->expectException(NotSupportedSourceException::class);
        $this->parser->parse($enrichedDocument);
    }

    /** @test */
    public function itShouldThrowAnExceptionIfEmptyContent()
    {
        $rawDocument = RawDocumentStub::EmptyFromTwitter();
        $enrichedDocument = EnrichedDocumentStub::create($rawDocument);

        $this->expectException(EmptyRawDocumentException::class);
        $this->parser->parse($enrichedDocument);
    }

    /** @test */
    public function itShouldThrowAnExceptionIfInvalidTweetStructure()
    {
        $rawDocument = RawDocumentStub::invalidStructureFromTwitter();
        $enrichedDocument = EnrichedDocumentStub::create($rawDocument);

        $this->expectException(NonWellFormedTweetException::class);
        $this->parser->parse($enrichedDocument);
    }

    /** @test */
    public function itShouldIdentifyProperlyContent()
    {
        $rawDocument = RawDocumentStub::validFromTwitter();
        $enrichedDocument = EnrichedDocumentStub::create(
            $rawDocument
        );

        $returnedEnrichedDocument = $this->parser->parse($enrichedDocument);
        $this->assertEquals(
            'Aggressive Ponytail #freebandnames',
            $returnedEnrichedDocument->content()->value()
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
        $enrichedDocument = EnrichedDocumentStub::create(
            $rawDocument
        );

        $returnedEnrichedDocument = $this->parser->parse($enrichedDocument);
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
        $enrichedDocument = EnrichedDocumentStub::create(
            $rawDocument
        );

        $returnedEnrichedDocument = $this->parser->parse($enrichedDocument);
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
        $enrichedDocument = EnrichedDocumentStub::create(
            $rawDocument
        );

        $returnedEnrichedDocument = $this->parser->parse($enrichedDocument);
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
        $enrichedDocument = EnrichedDocumentStub::create(
            $rawDocument
        );

        $returnedEnrichedDocument = $this->parser->parse($enrichedDocument);
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
        $enrichedDocument = EnrichedDocumentStub::create(
            $rawDocument
        );

        $returnedEnrichedDocument = $this->parser->parse($enrichedDocument);
        $this->assertEquals(
            'en',
            $returnedEnrichedDocument->language()->value()
        );
    }

    /**
     * @test
     */
    public function itShouldKeepNullLanguageIfTweetLanguageIsNull()
    {
        $rawDocument = RawDocumentStub::create(
            RawDocumentIdStub::random(),
            RawDocumentSourceStub::twitter(),
            RawDocumentKeywordStub::random(),
            RawDocumentContentStub::validFromTwitterWithNullLanguage()
        );
        $enrichedDocument = EnrichedDocumentStub::create(
            $rawDocument
        );

        $returnedEnrichedDocument = $this->parser->parse($enrichedDocument);
        $this->assertEquals(
            null,
            $returnedEnrichedDocument->language()
        );
    }
}
