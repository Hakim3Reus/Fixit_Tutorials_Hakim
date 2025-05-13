<?php

namespace App\Services;

use GuzzleHttp\Client;

class IFixitService
{
    protected $client;
    protected $baseUrl = 'https://www.ifixit.com/api/2.0/';

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Accept' => 'application/json',
            ]
        ]);
    }

    public function getTutorials($category = 'Electronics')
    {
        $response = $this->client->get('guides', [
            'query' => ['category' => $category]
        ]);
        
        return json_decode($response->getBody(), true);
    }

    public function getTutorialDetails($guideid)
    {
        $response = $this->client->get("guides/{$guideid}");
        return json_decode($response->getBody(), true);
    }

    public function getStepDetails($guideId, $stepId)
    {
        $response = $this->client->get("guides/{$guideId}/steps/{$stepId}");
        return json_decode($response->getBody(), true);
    }
}