<?php

namespace App\Infrastructure\Http\API;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class DummyJsonConnector implements ApiConnector
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://dummyjson.com/',
            'timeout' => 10.0,
        ]);
    }

    public function get(string $endpoint): array
    {
        try {
            $response = $this->client->get($endpoint);
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            return [];
        }
    }
}
