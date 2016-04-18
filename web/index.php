<?php

require_once __DIR__ . '/../vendor/autoload.php';

use \App\Lib\YandexLocator;

$app = new Silex\Application();

$app->get('/', function () use ($app) {

    $ip = $_SERVER['REMOTE_ADDR'];
    $token = 'AKVUBVcBAAAAufWcbQIApg0B_jBRuZZMtbKypQzCYc0Jaf8AAAAAAAAAAABzIfnaJskeaUoT0pJ63HPGlJVL2g==';
    $api = new YandexLocator($token);
    if($ip) {
        $api->setIpAddress((string)$ip);
        $result = $api->getCoordinate();
    }
    return $result;

});

$app->run();