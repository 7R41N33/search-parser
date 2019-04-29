<?php

namespace Acme\Request;

use GuzzleHttp\Client;

abstract class BaseRequest
{
    public $text;

    public function __construct($text)
    {
        $this->text = $text;
    }

    abstract public function sendQuery();

    protected function request($url, $params)
    {
        $client = new Client();
        $response = $client->get($url, $params);

        if ($response->getStatusCode() !== 200) {
            throw new Exception('Invalid query');
        }

        $body = $response->getBody();

        return $body->getContents();
    }
}
