<?php

namespace Mpwar\DataProcessor\Test\Behaviour;

use Mockery\Mock;
use Mpwar\DataProcessor\Application\CreateDocument;
use Mpwar\DataProcessor\Domain\Document\DocumentFactory;
use Mpwar\DataProcessor\Domain\Document\DocumentRepository;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\AuthorLocationStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\AuthorStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\ContentStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\CreatedAtStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\DocumentStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\LanguageStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\SourceDocumentIdStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\SourceKeywordStub;
use Mpwar\DataProcessor\Test\Infrastructure\Stub\SourceNameStub;
use Mpwar\DataProcessor\Test\Infrastructure\UnitTestCase;

class EnrichDocumentTest extends UnitTestCase
{
    /** @var  Mock|DocumentFactory */
    private $documentFactory;
    /** @var  Mock|DocumentRepository */
    private $documentRepository;
    /** @var  CreateDocument */
    private $applicationService;

    public function setUp()
    {
        parent::setUp();

        $this->documentFactory    = $this->mock(DocumentFactory::class);
        $this->documentRepository = $this->mock(DocumentRepository::class);

        $this->applicationService = new CreateDocument($this->documentFactory, $this->documentRepository);
    }

    /**
     * @test
     */
    public function processDocument()
    {
        $sourceDocumentId = SourceDocumentIdStub::create('wiki/Star_Wars');
        $sourceKeyword    = SourceKeywordStub::create('wiki');
        $sourceName       = SourceNameStub::create('force');
        $content          = ContentStub::create('May the Force be with you');
        $createdAt        = CreatedAtStub::create('1977-05-25T00:00:00+00:00');
        $author           = AuthorStub::create('George Lucas');
        $authorLocation   = AuthorLocationStub::create('US');
        $language         = LanguageStub::create('en');
        $document         = DocumentStub::create(
            $sourceDocumentId,
            $sourceKeyword,
            $sourceName,
            $content,
            $createdAt,
            $author,
            $authorLocation,
            $language
        );

        $this->documentFactory()->shouldReceive('build')->once()->with(
                equalTo($sourceDocumentId),
                equalTo($sourceKeyword),
                equalTo($sourceName),
                equalTo($content),
                equalTo($createdAt),
                equalTo($author),
                equalTo($authorLocation),
                equalTo($language)
            )->andReturn($document);

        $this->documentRepository()->shouldReceive('save')->once()->with(equalTo($document))->andReturn();

        $result = $this->applicationService()->execute(
                $sourceDocumentId,
                $sourceKeyword,
                $sourceName,
                $content,
                $createdAt,
                $author,
                $authorLocation,
                $language
            );

        $this->assertEquals($document, $result);
    }

    /**
     * @return Mock|DocumentFactory
     */
    public function documentFactory()
    {
        return $this->documentFactory;
    }

    /**
     * @return Mock|DocumentRepository
     */
    public function documentRepository()
    {
        return $this->documentRepository;
    }

    /**
     * @return CreateDocument
     */
    public function applicationService(): CreateDocument
    {
        return $this->applicationService;
    }
}
