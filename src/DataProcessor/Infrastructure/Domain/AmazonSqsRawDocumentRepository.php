<?php

namespace Mpwar\DataProcessor\Infrastructure\Domain;

use Aws\Sqs\SqsClient;
use Mpwar\DataProcessor\Domain\Entity\RawDocument;
use Mpwar\DataProcessor\Domain\Repository\RawDocumentsRepository;
use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentContent;
use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentId;
use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentKeyword;
use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentsCollection;
use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentSource;

class AmazonSqsRawDocumentRepository implements RawDocumentsRepository
{
    private $client;
    private $queueUrl;

    public function __construct(SqsClient $awsClient, $queueUrl)
    {
        $this->client = $awsClient;
        $this->queueUrl = $queueUrl;
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
}
