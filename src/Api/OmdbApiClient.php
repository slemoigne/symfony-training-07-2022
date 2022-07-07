<?php

namespace App\Api;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class OmdbApiClient
{
    public function __construct(
        //protected string $apiKey,
        //protected string $apiHost,
        protected HttpClientInterface $omdbClient,
    )
    {}

    public function getByTitle(string $title): array
    {
        $data = $this->omdbClient->request('GET', '/', ['query' => [
            //'apikey' => $this->apiKey,
            't' => $title,
        ]])->toArray();

        return $data;
    }
}
