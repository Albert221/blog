<?php

namespace Albert221\Blog;

use Albert221\Blog\Controller\PostController;
use Albert221\Blog\ServiceProvider\HttpServiceProvider;
use Albert221\Blog\ServiceProvider\TwigServiceProvider;
use League\Container\Container;
use League\Container\ReflectionContainer;
use League\Route\RouteCollection;
use Zend\Diactoros\Request;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\ServerRequest;

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
        
        $this->container->addServiceProvider(new HttpServiceProvider);
        $this->container->addServiceProvider(new TwigServiceProvider);

        $this->container->add(PostController::class)
            ->withMethodCall('setTwig', ['twig']);
    }

    /**
     * Sends response.
     */
    public function run()
    {
        /** @var RouteCollection $route */
        $route = $this->container->get('route');
        /** @var ServerRequest $request */
        $request = $this->container->get('request');
        /** @var Response $response */
        $response = $this->container->get('response');
        /** @var SapiEmitter $emitter */
        $emitter = $this->container->get('emitter');

        $response = $route->dispatch($request, $response);

        $emitter->emit($response);
    }
}