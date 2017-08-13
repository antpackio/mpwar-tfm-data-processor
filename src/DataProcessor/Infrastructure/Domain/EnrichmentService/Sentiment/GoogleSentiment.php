<?php

namespace Mpwar\DataProcessor\Infrastructure\Domain\EnrichmentService\Sentiment;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;
use Mpwar\DataProcessor\Domain\Document;
use Mpwar\DataProcessor\Domain\EnrichedDocument;
use Mpwar\DataProcessor\Domain\EnrichmentService\EnrichmentDocumentService;

class GoogleSentiment implements EnrichmentDocumentService
{
    const GOOGLE_ANALYZE_SENTIMENT = 'https://language.googleapis.com/v1beta1/documents:analyzeSentiment?key=%s';
    private $client;
    private $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = 'AIzaSyAHOWIk4w3rRhAEcaW_n56kS4MztlkMT5k';
    }

    public function execute(Document $document
    ): EnrichedDocument {
        $body = [
            'document' => [
                'type' => 'PLAIN_TEXT',
                'content' => $document->content()->value()
            ],
            'encodingType' => 'UTF8'
        ];
        try{
            $response = $this->client->request(
                'POST',
                sprintf(
                    self::GOOGLE_ANALYZE_SENTIMENT,
                    $this->apiKey
                ),
                ['json' => $body]
            );
        } catch (TransferException $exception) {
            echo $exception->getMessage();
            return $document;
        }

        $decodedResponse = json_decode(
            $response->getBody()->getContents(),
            true
        );
        $sentiment = new Sentiment();
        $sentiment->value = $decodedResponse["documentSentiment"];
        $document->addMetadata($sentiment);
        return $document;
    }
}