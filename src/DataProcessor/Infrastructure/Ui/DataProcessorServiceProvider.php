<?php

namespace Mpwar\DataProcessor\Infrastructure\Ui;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class DataProcessorServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['aws.sqs'] = $app['aws']->createSqs();
        $app['document.reader'] = new \Mpwar\DataProcessor\Infrastructure\Application\AmazonSqsDataQueue(
            $app['aws.sqs'],
            $app['mpwar.miner']['queue_url']
        );
        $app['enriched_document.repository'] = $app['orm.em']->getRepository(
            \Mpwar\DataProcessor\Infrastructure\Domain\Document\DoctrineDocument::class
        );

        $app['enriched_document.enrichment_service'] = new \Mpwar\DataProcessor\Domain\EnrichmentService\QueueOfEnrichmentServices(
            [
                new \Mpwar\DataProcessor\Infrastructure\Domain\EnrichmentService\InMemoryCategory(),
                new \Mpwar\DataProcessor\Infrastructure\Domain\EnrichmentService\GoogleLocation(),
                new \Mpwar\DataProcessor\Infrastructure\Domain\EnrichmentService\GoogleSentiment()
            ]
        );
        $app['message_bus'] = new \Mpwar\DataProcessor\Infrastructure\Application\AmazonSqsMessageBus(
            $app['aws.sqs'],
            $app['mpwar.processor']['queue_url']
        );
        $app['enriched_document.factory'] = new \Mpwar\DataProcessor\Infrastructure\Domain\Document\DoctrineDocumentFactory();
        $app['application.service.create_document'] = new \Mpwar\DataProcessor\Application\Service\CreateDocument(
            $app['enriched_document.factory'],
            $app['enriched_document.repository']
        );
        $app['application.service.enrich_document'] = new \Mpwar\DataProcessor\Application\Service\EnrichDocument(
            $app['enriched_document.enrichment_service'],
            $app['enriched_document.repository']
        );

        $app['application.service.process_queue'] = new \Mpwar\DataProcessor\Application\Service\ProcessQueue(
            $app['document.reader'],
            $app['application.service.create_document'],
            $app['application.service.enrich_document'],
            $app['message_bus']
        );
    }
}
