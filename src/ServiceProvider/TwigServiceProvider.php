<?php

namespace Albert221\Blog\ServiceProvider;

use Albert221\Blog\Pagination\PaginatorBuilder;
use Albert221\Blog\Repository\CategoryRepositoryInterface;
use Albert221\Blog\Repository\PostRepositoryInterface;
use Albert221\Blog\Repository\SettingRepositoryInterface;
use Albert221\Blog\Repository\TagRepositoryInterface;
use Albert221\Blog\Widget\TwigWidgetExtension;
use League\Container\ServiceProvider\AbstractServiceProvider;
use Psr\Http\Message\ServerRequestInterface;
use Twig_Environment;
use Twig_Loader_Filesystem;

class TwigServiceProvider extends AbstractServiceProvider
{
    /**
     * {@inheritdoc}
     */
    protected $provides = [
        'twig',
        'twigWidgetExtension',
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

            $config = [
                'autoescape' => false
            ];

            if (!$this->getContainer()->get('config')['debug']) {
                $config['cache'] = sprintf('%s/cache/twig', $this->getContainer()->get('baseDir'));
            }

            $twig = new Twig_Environment($loader, $config);
            $twig->addGlobal('settings', $this->getContainer()->get(SettingRepositoryInterface::class));

            $currentUrl = $this->getContainer()->get(ServerRequestInterface::class)
                ->getUri()->withFragment('')->withQuery('');
            $twig->addGlobal('currentUrl', $currentUrl);

            return $twig;
        });
        
        $this->getContainer()->share('twigWidgetExtension', function () {
            return new TwigWidgetExtension(
                $this->getContainer()->get('twig'),
                $this->getContainer()->get(PostRepositoryInterface::class),
                $this->getContainer()->get(CategoryRepositoryInterface::class),
                $this->getContainer()->get(TagRepositoryInterface::class)
            );
        });
        
        $this->getContainer()->share('paginatorBuilder', function () {
            return new PaginatorBuilder(
                $this->getContainer()->get('twig'),
                $this->getContainer()->get(SettingRepositoryInterface::class)['pagination.per_page']->getValue()
            );
        });
    }
}
