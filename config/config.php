<?php

$config = [
    'debug' => true,
    'database' => [
        'dbname' => 'blog',
        'user' => 'root',
        'password' => '',
        'host' => 'localhost',
        'charset' => 'utf8',
        'driver' => 'pdo_mysql'
    ],
    'serviceProviders' => [
        new \Albert221\Blog\ServiceProvider\HttpServiceProvider,
        new \Albert221\Blog\ServiceProvider\TwigServiceProvider,
        new \Albert221\Blog\ServiceProvider\DatabaseServiceProvider
    ]
];

if ($config['debug']) {
    $config['serviceProviders'][] = new \Albert221\Blog\ServiceProvider\WhoopsServiceProvider;
}

return $config;
