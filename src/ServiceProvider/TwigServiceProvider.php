<?php

namespace Albert221\Blog\ServiceProvider;

use Albert221\Blog\Twig\TwigAwareInterface;
use League\Container\ServiceProvider\AbstractServiceProvider;
use Twig_Environment;
use Twig_Loader_Filesystem;

class TwigServiceProvider extends AbstractServiceProvider
{
    /**
     * {@inheritdoc}
     */
    protected $provides = [
        'twig'
    ];

    public function boot()
    {
//        $this->getContainer()
//            ->inflector(TwigAwareInterface::class)
//            ->invokeMethod('setTwig', ['twig']);
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->getContainer()->share('twig', function () {
            $loader = new Twig_Loader_Filesystem(
                $this->getContainer()->get('baseDir').'/views'
            );
            
            return new Twig_Environment($loader);
        });
    }
}