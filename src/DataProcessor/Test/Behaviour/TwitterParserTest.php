<?php

namespace DataProcessor\Test\Behaviour;

use Mpwar\DataProcessor\Domain\Exception\EmptyRawDocumentException;
use Mpwar\DataProcessor\Domain\Exception\NotSupportedSourceException;
use Mpwar\DataProcessor\Domain\Service\TwitterParser;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\EnrichedDocumentContentStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\EnrichedDocumentCreatedAtStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\EnrichedDocumentStub;
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
    public function itShouldIdentifyProperlyContent()
    {
        $rawDocument = RawDocumentStub::validFromTwitter();
        $customContent = EnrichedDocumentContentStub::create(
            'Aggressive Ponytail #freebandnames'
        );
        $enrichedDocument = EnrichedDocumentStub::create(
            $rawDocument
        );

        $returnedEnrichedDocument = $this->parser->parse($enrichedDocument);
        $this->assertEquals(
            $customContent->value(),
            $returnedEnrichedDocument->content()->value()
        );
    }

    /**
    * @test
    */
    public function isShouldIdentifyProperlyCreationDate()
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
}
