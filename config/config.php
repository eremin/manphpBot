<?php
use Doctrine\Common\Cache\CacheProvider;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Interop\Container\ContainerInterface;
use League\Flysystem\Adapter\Local;
use League\Flysystem\AdapterInterface;
use ManPhpBot\ManualDictionary;
use ManPhpBot\ManualDictionaryLoad;
use Telegram\Bot\Api;

use function DI\object;
use function DI\get;
use function DI\factory;

return [
    'memcached.host' => 'localhost',
    'memcached.port' => 11211,
    'memcached.prefix' => 'manphpBot_',

    'storagePath' => __DIR__ . '/../storage',

    Api::class => object()
        ->constructor(get('apiKey')),

    ClientInterface::class => object(Client::class),

    AdapterInterface::class => object(Local::class)
        ->constructorParameter('root', get('storagePath')),

    CacheProvider::class => function (ContainerInterface $container) {
        $memcache = new Memcache();
        $memcache->connect($container->get('memcached.host'), $container->get('memcached.port'));

        $cacheDriver = new \Doctrine\Common\Cache\MemcacheCache();
        $cacheDriver->setMemcache($memcache);
        return $cacheDriver;
    },

    ManualDictionary::class => factory([ManualDictionaryLoad::class, 'load']),
    ManualDictionaryLoad::class => object()
        ->constructorParameter('prefix', get('memcached.prefix')),
];
