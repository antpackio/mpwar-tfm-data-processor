<?php

namespace Mpwar\DataProcessor\Infrastructure\Domain\EnrichmentService\Sentiment;

use GuzzleHttp\Client;
use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocument;
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

    public function execute(EnrichedDocument $enrichedDocument) :EnrichedDocument
    {
        $body = ['document' => ['type'=>'PLAIN_TEXT','content'=> $enrichedDocument->content()->value()], 'encodingType' =>'UTF8'];
        $response = $this->client->request('POST', sprintf(self::GOOGLE_ANALYZE_SENTIMENT,$this->apiKey), ['json' => $body]);
        $decodedResponse = json_decode($response->getBody()->getContents(), true);
        $sentiment = new Sentiment();
        $sentiment->value = $decodedResponse["documentSentiment"];
        $enrichedDocument->addMetadata($sentiment);
        return $enrichedDocument;
    }
}