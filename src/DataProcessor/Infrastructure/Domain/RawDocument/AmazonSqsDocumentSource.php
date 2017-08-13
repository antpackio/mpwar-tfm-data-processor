<?php

namespace Mpwar\DataProcessor\Infrastructure\Domain\RawDocument;

use Aws\Result;
use Aws\Sqs\SqsClient;
use Mpwar\DataProcessor\Application\DocumentReader;
use Mpwar\DataProcessor\Domain\Author;
use Mpwar\DataProcessor\Domain\AuthorLocation;
use Mpwar\DataProcessor\Domain\Content;
use Mpwar\DataProcessor\Domain\CreatedAt;
use Mpwar\DataProcessor\Domain\Document;
use Mpwar\DataProcessor\Domain\Language;
use Mpwar\DataProcessor\Domain\RawDocument\RawDocument;
use Mpwar\DataProcessor\Domain\RawDocument\RawDocumentContent;
use Mpwar\DataProcessor\Domain\RawDocument\RawDocumentId;
use Mpwar\DataProcessor\Domain\RawDocument\RawDocumentKeyword;
use Mpwar\DataProcessor\Domain\RawDocument\RawDocumentsArrayCollection;
use Mpwar\DataProcessor\Domain\RawDocument\RawDocumentSource;
use Mpwar\DataProcessor\Domain\RawDocument\RawDocumentsRepository;
use Mpwar\DataProcessor\Domain\SourceDocumentId;
use Mpwar\DataProcessor\Domain\SourceKeyword;
use Mpwar\DataProcessor\Domain\SourceName;

class AmazonSqsDocumentSource implements DocumentReader
{
    const MAX_MEMORY_USAGE_BYTES = 64 * 1024 * 1024;
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

    public function next(callable $callback = null): Document
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
            return null;
        }

        $messageDecoded = json_decode($messages['Messages'][0]['Body']['data']);

        $document = new Document(
            new SourceDocumentId($messageDecoded['source_id']),
            new SourceKeyword($messageDecoded['keyword']),
            new SourceName($messageDecoded['source']),
            new Content($messageDecoded['content']),
            new CreatedAt($messageDecoded['created_at']),
            new Author($messageDecoded['author']),
            new AuthorLocation($messageDecoded['author_location']),
            new Language($messageDecoded['metadata']['language'])
        );

        if ($callback) {
            $document = call_user_func($callback, $document);
        }

        $this->client->deleteMessage(
            [
                'QueueUrl'      => $this->queueUrl,
                'ReceiptHandle' => $messages['Messages'][0]['ReceiptHandle']
            ]
        );

        return $document;
    }

    private function shouldStop(): bool
    {
        return $this->foundMessage ?: memory_get_usage(true) > self::MAX_MEMORY_USAGE_BYTES;
    }
}
