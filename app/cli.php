#!/usr/bin/env php
<?php

if ('cli' !== PHP_SAPI) {
    return;
}

ini_set('display_errors', 1);
error_reporting(E_ALL);

/** @var \Interop\Container\ContainerInterface $container */
$container = require_once(__DIR__ . '/bootstrap.php');

$api = $container->get(Telegram\Bot\Api::class);
$updateHandle = $container->get(\ManPhpBot\UpdateHandle::class);

$lastUpdateId = 0;

loop:

$updates = $api->getUpdates($lastUpdateId ? ['offset' => $lastUpdateId + 1] : []);
var_dump($updates);
foreach ($updates as $update) {
    $updateHandle->handle($update);
    $lastUpdateId = $update->getUpdateId();
}
usleep(100000);

goto loop; //yes, i will go to hell
