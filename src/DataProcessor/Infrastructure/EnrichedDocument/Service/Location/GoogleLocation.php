<?php
/**
 * Created by PhpStorm.
 * User: Carles
 * Date: 12/07/2017
 * Time: 18:48
 */

namespace Mpwar\DataProcessor\Infrastructure\EnrichedDocument\Service\Location;

use GuzzleHttp\Client;
use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocument;
use Mpwar\DataProcessor\Domain\EnrichedDocument\Service\EnrichmentDocumentService;

class GoogleLocation implements EnrichmentDocumentService
{
    const GOOGLE_GEOCODE = 'https://maps.googleapis.com/maps/api/geocode/json?key=%s&address=%s';
    private $client;
    private $APIKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->APIKey = 'AIzaSyAHOWIk4w3rRhAEcaW_n56kS4MztlkMT5k';
    }

    public function execute(EnrichedDocument $enrichedDocument): EnrichedDocument
    {
        if ($enrichedDocument->authorLocation()->value() !== EnrichedDocument::UNDEFINED_TAG) {
            $response = $this->client->request(
                'GET',
                sprintf(
                    self::GOOGLE_GEOCODE,
                    $this->APIkey,
                    $enrichedDocument->authorLocation()->value()
                )
            );
            $decodedResponse = json_decode($response, true);
            $location = new Location();
            $location->value = array_shift($this->filterCountry($decodedResponse));
            $enrichedDocument->addMetadata($location);
        }
        return $enrichedDocument;
    }

    /**
     * @param $decodedResponse
     * @return array
     */
    private function filterCountry($decodedResponse): array
    {
        return array_filter(
            $decodedResponse["results"][0]['address_components'],
            function ($element) {
                return ($element['types'] === ["country", "political"]);
            });
    }
}