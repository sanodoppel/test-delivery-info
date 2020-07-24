<?php

namespace App\Service;

use App\DTO\RequestDTO;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Sender
{
    /**
     * @param RequestDTO $data
     *
     * @return array|null
     *
     * @throws GuzzleException
     */
    public function send(RequestDTO $data)
    {
        switch (strtolower($data->getMethod())) {
            case 'post':
                return $this->sendPostRequest($data);
            case 'get':
                return $this->sendGetRequest($data);
            default:
                return null;
        }
    }

    /**
     * @param RequestDTO $data
     *
     * @return array
     *
     * @throws GuzzleException
     */
    private function sendPostRequest(RequestDTO $data): array
    {
        $client = new Client([
            'base_uri' => $data->getBaseUrl(),
        ]);

        $response = $client->post($data->getUrl(), [
            'json' => $data->getFields()
        ]);

        return json_decode($response->getBody()->getContents(), 1);
    }

    /**
     * @param RequestDTO $data
     * @return array
     */
    private function sendGetRequest(RequestDTO $data): array
    {
        /**
         * @TODO create this request when it's necessary
         */
        return [];
    }
}
