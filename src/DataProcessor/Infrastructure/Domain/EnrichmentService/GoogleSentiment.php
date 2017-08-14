<?php

namespace Mpwar\DataProcessor\Infrastructure\Domain\EnrichmentService;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;
use Mpwar\DataProcessor\Domain\Document;
use Mpwar\DataProcessor\Domain\EnrichmentService\EnrichmentService;
use Mpwar\DataProcessor\Domain\Metadata;
use Mpwar\DataProcessor\Domain\MetadataCollection;

class GoogleSentiment implements EnrichmentService
{
    const GOOGLE_ANALYZE_SENTIMENT = 'https://language.googleapis.com/v1beta1/documents:analyzeSentiment?key=%s';
    private $client;
    private $apiKey;

    public function __construct(string $googleApiKey = 'AIzaSyAHOWIk4w3rRhAEcaW_n56kS4MztlkMT5k')
    {
        $this->client = new Client();
        $this->apiKey = $googleApiKey;
    }

    public function execute(Document $document): MetadataCollection
    {
        $metadataCollection = new MetadataCollection();

        $options = $this->getOptions($document->content()->value());
        try {
            $response = $this->client->request('POST', $this->getUrl(), $options);
        } catch (TransferException $exception) {
            return $metadataCollection;
        }

        $decodedResponse   = json_decode($response->getBody()->getContents(), true);
        $documentSentiment = $decodedResponse["documentSentiment"];

        $metadataCollection->add(new Metadata('sentiment', $documentSentiment['score']));
        $metadataCollection->add(new Metadata('language', $decodedResponse["language"]));

        return $metadataCollection;
    }

    private function getOptions(string $content): array
    {
        return [
            'json' => [
                'document'     => [
                    'type'    => 'PLAIN_TEXT',
                    'content' => $content
                ],
                'encodingType' => 'UTF8'
            ]
        ];
    }

    /**
     * @return string
     */
    private function getUrl(): string
    {
        return sprintf(
            self::GOOGLE_ANALYZE_SENTIMENT,
            $this->apiKey
        );
    }
}