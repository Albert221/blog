<?php

namespace Albert221\Blog;

use Albert221\Blog\Route\RouteCollection;
use League\Container\Container;
use League\Container\ReflectionContainer;
use League\Route\Http\Exception\NotFoundException;
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

        try {
            $response = $route->dispatch($request, $response);
        } catch (NotFoundException $e) {
            $response = new Response\RedirectResponse('/404');
        }

        $emitter->emit($response);
    }
}
