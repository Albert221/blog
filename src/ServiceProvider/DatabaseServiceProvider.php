<?php

namespace Albert221\Blog\ServiceProvider;

use Albert221\Blog\Entity\Category;
use Albert221\Blog\Entity\Post;
use Albert221\Blog\Entity\Setting;
use Albert221\Blog\Entity\Tag;
use Albert221\Blog\Repository\CategoryRepositoryInterface;
use Albert221\Blog\Repository\PostRepositoryInterface;
use Albert221\Blog\Repository\SettingRepositoryInterface;
use Albert221\Blog\Repository\TagRepositoryInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use DoctrineExtensions\Query\Mysql\MatchAgainst;
use League\Container\ServiceProvider\AbstractServiceProvider;

class DatabaseServiceProvider extends AbstractServiceProvider
{
    /**
     * {@inheritdoc}
     */
    protected $provides = [
        'entityManager',
        PostRepositoryInterface::class,
        CategoryRepositoryInterface::class,
        TagRepositoryInterface::class,
        SettingRepositoryInterface::class
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
            $config->addCustomStringFunction('MATCH', MatchAgainst::class);

            $connectionConfig = $this->getContainer()->get('config')['database'];

            return EntityManager::create($connectionConfig, $config);
        });

        $this->getContainer()->share(
            PostRepositoryInterface::class,
            $this->getContainer()->get('entityManager')->getRepository(Post::class)
        );

        $this->getContainer()->share(
            CategoryRepositoryInterface::class,
            $this->getContainer()->get('entityManager')->getRepository(Category::class)
        );
        
        $this->getContainer()->share(
            TagRepositoryInterface::class,
            $this->getContainer()->get('entityManager')->getRepository(Tag::class)
        );

        $this->getContainer()->share(
            SettingRepositoryInterface::class,
            $this->getContainer()->get('entityManager')->getRepository(Setting::class)
        );
    }
}
