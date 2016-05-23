<?php

$config = [
    'debug' => true,
    'pagination' => [
        'perPage' => 5
    ],
    'serviceProviders' => [
        new \Albert221\Blog\ServiceProvider\HttpServiceProvider,
        new \Albert221\Blog\ServiceProvider\TwigServiceProvider,
        new \Albert221\Blog\ServiceProvider\DatabaseServiceProvider,
        new \Albert221\Blog\ServiceProvider\WhoopsServiceProvider
    ]
];

if ($config['debug']) {
    $config['serviceProviders'][] = new \Albert221\Blog\ServiceProvider\WhoopsServiceProvider;
}

return $config;
