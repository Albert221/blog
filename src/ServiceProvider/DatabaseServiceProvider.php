<?php

namespace Albert221\Blog\ServiceProvider;

use Albert221\Blog\Entity\Category;
use Albert221\Blog\Entity\Post;
use Albert221\Blog\Repository\CategoryRepositoryInterface;
use Albert221\Blog\Repository\PostRepositoryInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use League\Container\ServiceProvider\AbstractServiceProvider;

class DatabaseServiceProvider extends AbstractServiceProvider
{
    /**
     * {@inheritdoc}
     */
    protected $provides = [
        'entityManager',
        PostRepositoryInterface::class,
        CategoryRepositoryInterface::class
    ];

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->getContainer()->share('entityManager', function () {
            $config = Setup::createAnnotationMetadataConfiguration(
                [dirname(__DIR__)],
                $this->getContainer()->get('config')['debug']
            );

            return EntityManager::create([
                'dbname' => 'blog',
                'user' => 'root',
                'password' => '',
                'host' => 'localhost',
                'charset' => 'utf8',
                'driver' => 'pdo_mysql'
            ], $config);
        });

        $this->getContainer()->share(
            PostRepositoryInterface::class,
            $this->getContainer()->get('entityManager')->getRepository(Post::class)
        );

        $this->getContainer()->share(
            CategoryRepositoryInterface::class,
            $this->getContainer()->get('entityManager')->getRepository(Category::class)
        );
    }
}
