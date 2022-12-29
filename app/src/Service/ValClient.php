<?php
namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ValClient
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://www.cbr-xml-daily.ru/daily_json.js'
        ]);
    }

    /**
     * @throws GuzzleException
     */
    public function getForeignCurrencyMarket(): array
    {
        $response = $this->client->request('GET', "");

        if($response->getStatusCode() === 200){
            return json_decode($response->getBody()->getContents(), true);
        }
        throw new \Exception("ValClient status not 200!");
    }
}