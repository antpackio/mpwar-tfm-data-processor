<?php

namespace Mpwar\DataProcessor\Infrastructure\Domain\EnrichmentService\Location;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;
use Mpwar\DataProcessor\Domain\Document;
use Mpwar\DataProcessor\Domain\EnrichedDocument;
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

    public function execute(Document $document
    ): EnrichedDocument {
        if ($document->authorLocation()->value(
            ) === EnrichedDocument::UNDEFINED_TAG
        ) {
            return $document;
        }

        try {
            $response = $this->client->request(
                'GET',
                sprintf(
                    self::GOOGLE_GEOCODE,
                    $this->apiKey,
                    $document->authorLocation()->value()
                )
            );
        } catch (TransferException $exception) {
            echo $exception->getMessage();
            return $document;
        }


        $decodedResponse = json_decode(
            $response->getBody()->getContents(),
            true
        );

        if (empty($decodedResponse['results'])) {
            return $document;
        }

        $location = new Location();
        $filteredAddressComponents = $this->filterCountry($decodedResponse);
        $location->value = array_shift($filteredAddressComponents);

        $document->addMetadata($location);

        return $document;
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
            }
        );
    }
}