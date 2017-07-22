<?php

namespace Mpwar\DataProcessor\Infrastructure\Domain\RawDocument;

use Aws\Result;
use Aws\Sqs\SqsClient;
use Mpwar\DataProcessor\Domain\RawDocument\RawDocument;
use Mpwar\DataProcessor\Domain\RawDocument\RawDocumentContent;
use Mpwar\DataProcessor\Domain\RawDocument\RawDocumentId;
use Mpwar\DataProcessor\Domain\RawDocument\RawDocumentKeyword;
use Mpwar\DataProcessor\Domain\RawDocument\RawDocumentsCollection;
use Mpwar\DataProcessor\Domain\RawDocument\RawDocumentSource;
use Mpwar\DataProcessor\Domain\RawDocument\RawDocumentsRepository;

class AmazonSqsRawDocumentRepository implements RawDocumentsRepository
{
    private $client;
    private $queueUrl;
    private $foundMessage;

    const MAX_MEMORY_USAGE_BYTES = 64 * 1024 * 1024;

    const RECEIVE_MESSAGE_WAITING_TIME = 20;

    public function __construct(SqsClient $awsClient, $queueUrl)
    {
        $this->client = $awsClient;
        $this->queueUrl = $queueUrl;
        $this->foundMessage = false;
    }


    public function all(): RawDocumentsCollection
    {
        $messages = $this->client->receiveMessage(
            ['QueueUrl' => $this->queueUrl]
        );

        $collection = new RawDocumentsCollection();

        if ($messages['Messages'] == null) {
            return $collection;
        }

        foreach ($messages['Messages'] as $message) {
            $messageDecoded = json_decode($message['Body']);
            $collection->add(
                new RawDocument(
                    RawDocumentId::fromString($messageDecoded->rawDocument->id),
                    new RawDocumentSource($messageDecoded->rawDocument->source),
                    new RawDocumentKeyword($messageDecoded->rawDocument->keyword),
                    new RawDocumentContent(json_encode($messageDecoded->rawDocument->content))
                )
            );
            $this->client->deleteMessage(
                [
                    'QueueUrl' => $this->queueUrl,
                    'ReceiptHandle' => $message['ReceiptHandle']
                ]
            );
        }
        return $collection;
    }

    public function first(): ?RawDocument
    {
        do {
            $messages = $this->client->receiveMessage(
                [
                    'QueueUrl' => $this->queueUrl,
                    'WaitTimeSeconds' => self::RECEIVE_MESSAGE_WAITING_TIME,
                ]
            );

            if ($messages['Messages'] !== null) {
                $this->foundMessage = true;
            }
        } while(!$this->shouldStop());

        if (!is_a($messages, Result::class) || $messages['Messages'] === null) {
            return null;
        }

        $messageDecoded = json_decode($messages['Messages'][0]['Body']);

        $this->client->deleteMessage(
            [
                'QueueUrl' => $this->queueUrl,
                'ReceiptHandle' => $messages['Messages'][0]['ReceiptHandle']
            ]
        );

        return new RawDocument(
            RawDocumentId::fromString($messageDecoded->rawDocument->id),
            new RawDocumentSource($messageDecoded->rawDocument->source),
            new RawDocumentKeyword($messageDecoded->rawDocument->keyword),
            new RawDocumentContent(json_encode($messageDecoded->rawDocument->content))
        );
    }

    private function shouldStop(): bool
    {
        return $this->foundMessage ?: memory_get_usage(true) > self::MAX_MEMORY_USAGE_BYTES;
    }
}
