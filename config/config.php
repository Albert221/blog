<?php

return [
    'debug' => true,
    'pagination' => [
        'perPage' => 5
    ],
    'serviceProviders' => [
        new \Albert221\Blog\ServiceProvider\HttpServiceProvider,
        new \Albert221\Blog\ServiceProvider\TwigServiceProvider,
        new \Albert221\Blog\ServiceProvider\DatabaseServiceProvider
    ]
];
