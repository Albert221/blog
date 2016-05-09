<?php

use League\Route\Strategy\ParamStrategy;

$routes = (new \League\Route\RouteCollection($this->getContainer()))
            ->setStrategy((new ParamStrategy)->setContainer($this->getContainer()));

$routes->get('/', 'Albert221\Blog\Controller\PostController::index');

return $routes;