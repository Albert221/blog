<?php

namespace Albert221\Blog\ServiceProvider;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class WhoopsServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        (new Run)->pushHandler(new PrettyPageHandler)->register();
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        //
    }
}
