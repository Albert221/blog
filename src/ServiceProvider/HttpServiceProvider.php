<?php

namespace Albert221\Blog\ServiceProvider;

use Albert221\Blog\Controller\PostController;
use Albert221\Blog\Repository\PostRepositoryInterface;
use Albert221\Blog\Route\RouteCollection;
use League\Container\ServiceProvider\AbstractServiceProvider;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\EmitterInterface;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;

class HttpServiceProvider extends AbstractServiceProvider
{
    /**
     * {@inheritdoc}
     */
    protected $provides = [
        ServerRequestInterface::class,
        ResponseInterface::class,
        EmitterInterface::class,
        RouteCollection::class,
        PostController::class
    ];

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->getContainer()->share(ServerRequestInterface::class, function () {
            return ServerRequestFactory::fromGlobals();
        });

        $this->getContainer()->share(ResponseInterface::class, Response::class);

        $this->getContainer()->share(EmitterInterface::class, SapiEmitter::class);

        $this->getContainer()->share(RouteCollection::class, function () {
            return require sprintf(
                '%s/config/routes.php',
                $this->getContainer()->get('baseDir')
            );
        });

        $this->getContainer()->add(PostController::class)
            ->withArgument(PostRepositoryInterface::class)
            ->withArgument('paginatorBuilder');
    }
}
