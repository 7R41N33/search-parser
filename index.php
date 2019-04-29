<?php

require 'vendor/autoload.php';

use Dotenv\Dotenv;
use GuzzleHttp\Client;

function loadEnv()
{
    $dotenv = Dotenv::create(__DIR__);
    $dotenv->load();
}

function loadSearchResults($text)
{
    $params = [
        'query' => [
            'user' => $_ENV['USER_NAME'],
            'key' => $_ENV['API_KEY'],
            'query' => $text,
            'lr' => $_ENV['LR'],
            'i10n' => 'en',
        ],
    ];

    $url = $_ENV['SEARCH_URL'];

    $client = new Client();
    $response = $client->get($url, $params);

    if ($response->getStatusCode() !== 200) {
        throw new Exception('Invalid query');
    }

    $body = $response->getBody();
    $searchResults = $body->getContents();

    return $searchResults;
}

function prepareResults($searchResults)
{
    $searchData = new \SimpleXMLElement($searchResults);
    $groups = $searchData->xpath('//group');

    $count = 0;
    $results = [];
    foreach ($groups as $group) {
        if ($count == 5) {
            break;
        }

        $count++;

        $results[] = [
            'url' => (string) $group->doc->url,
            'title' => (string) $group->doc->title,
            'description' => (string) $group->doc->passages->passage,
        ];
    }

    return $results;
}

loadEnv();

$searchResults = loadSearchResults($argv[1]);
$results = prepareResults($searchResults);

print_r($results);
