<?php
namespace App\Lib;

use GuzzleHttp\Client;

class YandexLocator
{

    const API_URL = 'http://api.lbs.yandex.net/geolocation';

    protected $version = '1.0';

    protected $filters = array();

    protected $response;

    protected $client;

    public function __construct($token, $version = null)
    {
        if (!empty($version)) {
            $this->version = (string)$version;
        }
        $this->client = new Client();
        $this->filters['common'] = [
            'version' => $this->version,
            'api_key' => $token
        ];
        $this->reset();
    }
    public function reset()
    {
        $this->filters['ip'] = [];
        return $this;
    }

    public function load()
    {
        $response = $this->client->request('POST', self::API_URL, [
            'multipart' => [
                [
                    'name'     => 'json',
                    'contents' => json_encode($this->filters)
                ]
            ]
        ]);
        $this->response = json_decode($response->getBody()->getContents());

        return $this;
    }

    public function getCoordinate()
    {
        $this->load();
        $result = [
            'lat' => $this->response->position->latitude,
            'lon' => $this->response->position->longitude
        ];
        return json_encode($result);
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function setIpAddress($ip)
    {
        $this->filters['ip']['address_v4'] = $ip;
        return $this;
    }
}