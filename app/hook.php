<?php

/** @var \Interop\Container\ContainerInterface $container */
$container = require_once(__DIR__ . '/bootstrap.php');

$api = $container->get(Telegram\Bot\Api::class);
$updateHandle = $container->get(\ManPhpBot\UpdateHandle::class);

$update = $api->getWebhookUpdate();
$updateHandle->handle($update);
