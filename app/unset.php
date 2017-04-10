<?php

/** @var \Interop\Container\ContainerInterface $container */
$container = require_once(__DIR__ . '/bootstrap.php');

$api = $container->get(Telegram\Bot\Api::class);

$response = $api->removeWebhook();
var_dump($response);
