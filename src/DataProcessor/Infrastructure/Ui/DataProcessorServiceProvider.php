<?php

namespace Mpwar\DataProcessor\Infrastructure\Ui;

use Mpwar\DataProcessor\Infrastructure\Application\AmazonSqsMessageBus;
use Mpwar\DataProcessor\Infrastructure\Domain\EnrichedDocument\DoctrineEnrichedDocumentFactory;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class DataProcessorServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['aws.sqs'] = $app['aws']->createSqs();
        $app['document.reader'] = new \Mpwar\DataProcessor\Infrastructure\Domain\RawDocument\AmazonSqsDocumentSource(
            $app['aws.sqs'],
            $app['mpwar.miner']['queue_url']
        );
        $app['enriched_document.repository'] = $app['orm.em']->getRepository(
            'Mpwar\DataProcessor\Infrastructure\Domain\EnrichedDocument\DoctrineEnrichDocument'
        );
//        $app['parser.service'] = new \Mpwar\DataProcessor\Domain\Parser\ConcreteParserService( new DoctrineEnrichedDocumentFactory());
        $app['enriched_document.enrichment_service'] = new \Mpwar\DataProcessor\Domain\EnrichmentService\QueueOfEnrichmentDocumentServices(
            [
                new \Mpwar\DataProcessor\Infrastructure\Domain\EnrichmentService\InMemoryCategory(),
//                new \Mpwar\DataProcessor\Infrastructure\Domain\EnrichmentService\Location\GoogleLocation(),
//                new \Mpwar\DataProcessor\Infrastructure\Domain\EnrichmentService\Sentiment\GoogleSentiment()
            ]
        );
        $app['message_bus'] = new AmazonSqsMessageBus(
            $app['aws.sqs'],
            $app['mpwar.processor']['queue_url']
        );
        $app['application.service.enrich_document'] = new \Mpwar\DataProcessor\Application\EnrichDocument(
            $app['enriched_document.enrichment_service'],
            $app['enriched_document.repository']
        );

        $app['application.service.process_queue'] = new \Mpwar\DataProcessor\Application\ProcessQueue(
            $app['application.service.enrich_document'],
            $app['document.reader'],
            $app['message_bus'],
            null
        );

//        $app['data_processor'] = new \Mpwar\DataProcessor\Application\Service\DataProcessor(
//            $app['raw_document.repository'],
//            $app['parser.service'],
//            $app['enriched_document.enrichment_service'],
//            $app['enriched_document.repository'],
//            $app['message_bus']
//        );
    }
}
