<?php
/**
 * Created by PhpStorm.
 * User: Carles
 * Date: 12/07/2017
 * Time: 18:48
 */

namespace Mpwar\DataProcessor\Infrastructure\Domain\EnrichmentService\Location;

use GuzzleHttp\Client;
use Mpwar\DataProcessor\Domain\EnrichedDocument\EnrichedDocument;
use Mpwar\DataProcessor\Domain\EnrichmentService\EnrichmentDocumentService;

class GoogleLocation implements EnrichmentDocumentService
{
    const GOOGLE_GEOCODE = 'https://maps.googleapis.com/maps/api/geocode/json?key=%s&address=%s';
    private $client;
    private $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = 'AIzaSyAHOWIk4w3rRhAEcaW_n56kS4MztlkMT5k';
    }

    public function execute(EnrichedDocument $enrichedDocument): EnrichedDocument
    {
        if ($enrichedDocument->authorLocation()->value() !== EnrichedDocument::UNDEFINED_TAG) {
            $response = $this->client->request(
                'GET',
                sprintf(
                    self::GOOGLE_GEOCODE,
                    $this->apiKey,
                    $enrichedDocument->authorLocation()->value()
                )
            );
            $decodedResponse = json_decode($response->getBody()->getContents(), true);
            $location = new Location();
            $filteredAddressComponents = $this->filterCountry($decodedResponse);
            $location->value = array_shift($filteredAddressComponents);
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