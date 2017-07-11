<?php
/**
 * Created by PhpStorm.
 * User: Carles
 * Date: 05/07/2017
 * Time: 20:20
 */

namespace Mpwar\DataProcessor\Infrastructure\EnrichedDocument\Service\Sentiment;

use Google\Cloud\Core\Compute\Metadata;
use GuzzleHttp\Client;
use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocument;
use Mpwar\DataProcessor\Domain\EnrichedDocument\Service\EnrichmentDocumentService;

class GoogleSentiment implements EnrichmentDocumentService
{
    const GOOGLE_ANALYZE_SENTIMENT = 'https://language.googleapis.com/v1beta1/documents:analyzeSentiment?key=%s';
    private $client;
    private $APIKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->APIKey = 'AIzaSyAHOWIk4w3rRhAEcaW_n56kS4MztlkMT5k';
    }

    public function execute(EnrichedDocument $enrichedDocument) :EnrichedDocument
    {
        $body = ['document' => ['type'=>'PLAIN_TEXT','content'=> $enrichedDocument->content()->value()], 'encodingType' =>'UTF8'];
        $response = $this->client->request('POST', sprintf(self::GOOGLE_ANALYZE_SENTIMENT,$this->APIkey), ['json' => $body]);
        $decodedResponse = json_decode($response, true);
        $sentiment = new Sentiment();
        $sentiment->value = $decodedResponse["documentSentiment"];
        $enrichedDocument->addMetadata($sentiment);
        return $enrichedDocument;
    }
}