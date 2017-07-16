<?php

namespace Mpwar\DataProcessor\Infrastructure\Ui;

use Mpwar\DataProcessor\Infrastructure\AmazonSqsMessageBus;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class DataProcessorServiceProvider implements ServiceProviderInterface
{

    public function register(Container $app)
    {
        $app['aws.sqs'] = $app['aws']->createSqs();
        $app['raw_document.repository'] = new \Mpwar\DataProcessor\Infrastructure\Domain\AmazonSqsRawDocumentRepository(
            $app['aws.sqs'],
            $app['mpwar.miner']['queue_url']
        );
        $app['enriched_document.repository'] = $app['orm.em']->getRepository('Mpwar\DataProcessor\Infrastructure\Domain\EnrichedDocument\DoctrineEnrichedDocument');
        $app['parser.service'] = new \Mpwar\DataProcessor\Domain\Parser\ConcreteParserService();
        $app['enriched_document.enrichment_service'] = new \Mpwar\DataProcessor\Domain\EnrichedDocument\Service\QueueOfEnrichmentDocumentServices(
            [
                new \Mpwar\DataProcessor\Infrastructure\EnrichedDocument\Service\Category\InMemoryCategory(),
                new \Mpwar\DataProcessor\Infrastructure\EnrichedDocument\Service\Location\GoogleLocation(),
                new \Mpwar\DataProcessor\Infrastructure\EnrichedDocument\Service\Sentiment\GoogleSentiment()
            ]
        );
        $app['message_bus'] = new AmazonSqsMessageBus(
            $app['aws.sqs'],
            $app['mpwar.processor']['queue_url']
        );

        $app['data_processor'] = new \Mpwar\DataProcessor\Application\Service\DataProcessor(
            $app['raw_document.repository'],
            $app['parser.service'],
            $app['enriched_document.enrichment_service'],
            $app['enriched_document.repository'],
            $app['message_bus']
        );
    }
}
