<?php

namespace Mpwar\DataProcessor\Infrastructure\Domain\EnrichmentService;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;
use Mpwar\DataProcessor\Domain\Document\Document;
use Mpwar\DataProcessor\Domain\EnrichmentService\EnrichmentService;
use Mpwar\DataProcessor\Domain\Document\Metadata;
use Mpwar\DataProcessor\Domain\Document\MetadataCollection;

class GoogleLocation implements EnrichmentService
{
    const GOOGLE_GEOCODE = 'https://maps.googleapis.com/maps/api/geocode/json?key=%s&address=%s';
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

        if ($document->authorLocation()->value() === "") {
            return $metadataCollection;
        }

        try {
            $response = $this->client->request('GET', $this->getUrl($document->authorLocation()->value()));
        } catch (TransferException $exception) {
            return $metadataCollection;
        }

        $decodedResponse = json_decode($response->getBody()->getContents(), true);

        if (empty($decodedResponse['results'])) {
            return $metadataCollection;
        }

        $filteredAddressComponents = $this->filterCountry($decodedResponse);
        $countryPoliticalElement   = array_shift($filteredAddressComponents);
        $metadataCollection->add(new Metadata('location', strtolower($countryPoliticalElement["short_name"])));

        return $metadataCollection;
    }

    private function getUrl(string $location): string
    {
        return sprintf(self::GOOGLE_GEOCODE, $this->apiKey, $location);
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
