<?php

namespace Albert221\Blog\ServiceProvider;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;

class HttpServiceProvider extends AbstractServiceProvider
{
    /**
     * {@inheritdoc}
     */
    protected $provides = [
        'request',
        'response',
        'emitter',
        'route'
    ];

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->getContainer()->share('request', function () {
            return ServerRequestFactory::fromGlobals();
        });

        $this->getContainer()->share('response', Response::class);

        $this->getContainer()->share('emitter', SapiEmitter::class);

        $this->getContainer()->share('route', function () {
            return require $this->getContainer()
                ->get('baseDir').'/config/routes.php';
        });
    }
}