<?php

namespace Mpwar\DataProcessor\Infrastructure\Application;

use Aws\Sqs\SqsClient;
use Mpwar\DataProcessor\Application\MessageBus;

class AmazonSqsMessageBus implements MessageBus
{
    private $client;
    private $queueUrl;

    public function __construct(SqsClient $awsClient, $queueUrl)
    {
        $this->client = $awsClient;
        $this->queueUrl = $queueUrl;
    }

    public function dispatch(String $eventName, $event)
    {
        $this->client->sendMessage(
            [
                'QueueUrl' => $this->queueUrl,
                'MessageBody' => json_encode($event)
            ]
        );
    }
}
