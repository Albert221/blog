<?php

use Albert221\Blog\Route\RouteCollection;
use League\Route\Strategy\ParamStrategy;

$routes = (new RouteCollection($this->getContainer()))
            ->setStrategy((new ParamStrategy)->setContainer($this->getContainer()));

$routes->get('/', 'Albert221\Blog\Controller\PostController::index');
$routes->get('/kategoria/{slug}', 'Albert221\Blog\Controller\PostController::category');
$routes->get('/tag/{slug}', 'Albert221\Blog\Controller\PostController::tag');
$routes->get('/{slug}', 'Albert221\Blog\Controller\PostController::post');

return $routes;
