<?php

/** @var \Interop\Container\ContainerInterface $container */
$container = require_once(__DIR__ . '/bootstrap.php');

$api = $container->get(Telegram\Bot\Api::class);

$response = $api->setWebhook(['url' => $container->get('botUrl')]);
var_dump($response);
