<?php

/** @var \Interop\Container\ContainerInterface $container */

$container = require_once(__DIR__ . '/bootstrap.php');

$download = $container->get(\ManPhpBot\Download::class);

$download->download();
