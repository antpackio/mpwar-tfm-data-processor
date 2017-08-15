<?php

namespace Mpwar\DataProcessor\Infrastructure\Application;

use Aws\Result;
use Aws\Sqs\SqsClient;
use Mpwar\DataProcessor\Application\DataQueue;
use Mpwar\DataProcessor\Application\DataRequest;

class AmazonSqsDataQueue implements DataQueue
{
    const MAX_MEMORY_USAGE_BYTES       = 64 * 1024 * 1024;
    const RECEIVE_MESSAGE_WAITING_TIME = 20;
    private $client;
    private $queueUrl;
    private $foundMessage;

    public function __construct(SqsClient $awsClient, $queueUrl)
    {
        $this->client       = $awsClient;
        $this->queueUrl     = $queueUrl;
        $this->foundMessage = false;
    }

    public function next(): DataRequest
    {
        do {
            $messages = $this->client->receiveMessage(
                [
                    'QueueUrl'        => $this->queueUrl,
                    'WaitTimeSeconds' => self::RECEIVE_MESSAGE_WAITING_TIME,
                ]
            );

            if ($messages['Messages'] !== null) {
                $this->foundMessage = true;
            }
        } while (!$this->shouldStop());

        if (!is_a($messages, Result::class) || $messages['Messages'] === null) {
            throw new \Exception();
        }

        $messageDecoded = json_decode($messages['Messages'][0]['Body'], true);

        $this->client->deleteMessage(
            [
                'QueueUrl'      => $this->queueUrl,
                'ReceiptHandle' => $messages['Messages'][0]['ReceiptHandle']
            ]
        );

        $data = $messageDecoded['data'];

        return new DataRequest(
            $data['source_id'],
            $data['keyword'],
            $data['source'],
            $data['content'],
            $data['created_at'],
            $data['author'],
            $data['author_location'],
            $data['metadata']['language']
        );
    }

    private function shouldStop(): bool
    {
        return $this->foundMessage ?: memory_get_usage(true) > self::MAX_MEMORY_USAGE_BYTES;
    }
}
