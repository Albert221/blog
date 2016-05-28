<?php

use Albert221\Blog\Route\RouteCollection;
use League\Route\Strategy\ParamStrategy;
use Zend\Diactoros\Response;

$container = $this->getContainer();

$routes = (new RouteCollection($container))
            ->setStrategy((new ParamStrategy)->setContainer($container));

$routes->get('/', 'Albert221\Blog\Controller\PostController::index');
$routes->get('/kategoria/{slug}', 'Albert221\Blog\Controller\PostController::category');
$routes->get('/tag/{slug}', 'Albert221\Blog\Controller\PostController::tag');
$routes->get('/404', function() use ($container) { // TODO: Clean up this
    $body = $container->get('twig')->render('404.twig');

    $response = new Response;
    $response->getBody()->write($body);

    return $response->withStatus(404);
});
$routes->get('/{slug}', 'Albert221\Blog\Controller\PostController::post');

return $routes;
