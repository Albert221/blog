<?php

namespace Albert221\Blog\Route;

use League\Route\RouteCollection as LeagueRouteCollection;

class RouteCollection extends LeagueRouteCollection
{
    /**
     * @param array|string $method
     * @param string $path
     * @param callable|string $handler
     * @return Route
     */
    public function map($method, $path, $handler)
    {
        $path = sprintf('/%s', ltrim($path, '/'));

        $route = (new Route)->setMethods((array) $method)->setPath($path)->setCallable($handler);

        $this->routes[] = $route;

        return $route;
    }
}
