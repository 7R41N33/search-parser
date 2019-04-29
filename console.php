<?php

require 'vendor/autoload.php';

use Acme\Request\YandexRequest;
use Acme\Parser\YandexParser;
use Dotenv\Dotenv;

$dotenv = Dotenv::create(__DIR__);
$dotenv->load();

$request = new YandexRequest($argv[1]);

$parser = new YandexParser($request);
$results = $parser->parse();

print_r($results);
