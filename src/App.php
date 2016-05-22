<?php

namespace Albert221\Blog;

use League\Container\Container;
use League\Container\ReflectionContainer;
use League\Route\RouteCollection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Request;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\EmitterInterface;

class App
{
    /**
     * @var Container
     */
    protected $container;

    public function __construct()
    {
        $this->container = new Container;
        $this->container->delegate(new ReflectionContainer);

        $this->container->add('baseDir', dirname(__DIR__));

        $this->loadConfig();
        $this->loadServiceProviders();
    }

    private function loadConfig()
    {
        $this->container->add(
            'config',
            require $this->container->get('baseDir').'/config/config.php'
        );
    }

    private function loadServiceProviders()
    {
        foreach ($this->container->get('config')['serviceProviders'] as $provider) {
            $this->container->addServiceProvider($provider);
        }
    }

    /**
     * Sends response.
     */
    public function run()
    {
        /** @var RouteCollection $route */
        $route = $this->container->get(RouteCollection::class);
        /** @var ServerRequestInterface $request */
        $request = $this->container->get(ServerRequestInterface::class);
        /** @var ResponseInterface $response */
        $response = $this->container->get(ResponseInterface::class);
        /** @var EmitterInterface $emitter */
        $emitter = $this->container->get(EmitterInterface::class);

        $response = $route->dispatch($request, $response);

        $emitter->emit($response);
    }
}
