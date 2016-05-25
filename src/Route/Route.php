<?php

namespace Albert221\Blog\Route;

use InvalidArgumentException;
use League\Route\Route as LeagueRoute;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Route extends LeagueRoute
{
    /**
     * @var callable
     */
    protected $middleware;

    /**
     * @param callable $middleware
     * @return $this
     */
    public function setMiddleware($middleware)
    {
        if (!is_callable($middleware)) {
            throw new InvalidArgumentException(sprintf(
                'Second parameter must be a callable, %s given.',
                is_scalar($middleware) ? gettype($middleware) : get_class($middleware)
            ));
        }
        $this->middleware = $middleware;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(ServerRequestInterface $request, ResponseInterface $response, array $vars)
    {
        $response = parent::dispatch($request, $response, $vars);
        
        if (is_null($this->middleware)) {
            return $response;
        }
        
        return call_user_func_array($this->middleware, [$request, $response]);
    }
}
