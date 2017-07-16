<?php

namespace Mpwar\DataProcessor\Infrastructure;

use Aws\Sqs\SqsClient;
use Mpwar\DataProcessor\Domain\Event\DomainEvent;
use Mpwar\DataProcessor\Domain\MessageBus;

class AmazonSqsMessageBus implements MessageBus
{
    private $client;
    private $queueUrl;

    public function __construct(SqsClient $awsClient, $queueUrl)
    {
        $this->client = $awsClient;
        $this->queueUrl = $queueUrl;
    }

    public function dispatch(String $eventName, DomainEvent $event)
    {
        $this->client->sendMessage(
            [
                'QueueUrl' => $this->queueUrl,
                'MessageBody' => json_encode($event)
            ]
        );
    }
}
