<?php

namespace Albert221\Blog\ServiceProvider;

use Albert221\Blog\Pagination\PaginatorBuilder;
use League\Container\ServiceProvider\AbstractServiceProvider;
use Twig_Environment;
use Twig_Loader_Filesystem;

class TwigServiceProvider extends AbstractServiceProvider
{
    /**
     * {@inheritdoc}
     */
    protected $provides = [
        'twig',
        'paginatorBuilder'
    ];

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->getContainer()->share('twig', function () {
            $loader = new Twig_Loader_Filesystem(
                $this->getContainer()->get('baseDir').'/views'
            );
            
            return new Twig_Environment($loader, [
                'autoescape' => false
            ]);
        });
        
        $this->getContainer()->share('paginatorBuilder', function () {
            return new PaginatorBuilder(
                $this->getContainer()->get('twig'),
                $this->getContainer()->get('config')['pagination']['perPage']
            );
        });
    }
}
