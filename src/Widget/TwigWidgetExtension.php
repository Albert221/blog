<?php

namespace Albert221\Blog\Widget;

use Albert221\Blog\Repository\CategoryRepositoryInterface;
use Albert221\Blog\Repository\PostRepositoryInterface;
use Albert221\Blog\Repository\TagRepositoryInterface;
use Twig_Environment;
use Twig_Extension;
use Twig_Extension_GlobalsInterface;

// TODO: Load widgets from database
class TwigWidgetExtension extends Twig_Extension implements Twig_Extension_GlobalsInterface
{
    private $twig;
    private $posts;
    private $categories;
    private $tags;

    public function __construct(
        Twig_Environment $twig,
        PostRepositoryInterface $posts,
        CategoryRepositoryInterface $categories,
        TagRepositoryInterface $tags
    ) {
        $this->twig = $twig;
        $this->posts = $posts;
        $this->categories = $categories;
        $this->tags = $tags;
    }

    private function getSidebarWidgets()
    {
        $sidebarWidgetManager = new WidgetManager();
        $sidebarWidgetManager->add(new RecentPosts($this->posts, $this->twig, 10));
        $sidebarWidgetManager->add(new TagCloud($this->tags, $this->twig));
        
        return $sidebarWidgetManager->getWidgets();
    }

    private function getFooterWidgets()
    {
        $footerWidgetManager = new WidgetManager();
        $footerWidgetManager->add(new RecentPosts($this->posts, $this->twig, 5));
        $footerWidgetManager->add(new RecentCategories($this->categories, $this->twig, 5));
        $footerWidgetManager->add(new HTML('Polecane strony', '<ul>
            <li><a href="#">Lorem ipsum.</a></li>
            <li><a href="#">Amet, ipsam?</a></li>
            <li><a href="#">Animi, alias.</a></li>
            <li><a href="#">Sed, non.</a></li>
            <li><a href="#">Officiis, harum.</a></li>
        </ul>'));
        
        return $footerWidgetManager->getWidgets();
    }

    /**
     * {@inheritdoc}
     */
    public function getGlobals()
    {
        return [
            'sidebarWidgets' => $this->getSidebarWidgets(),
            'footerWidgets' => $this->getFooterWidgets()
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'widgets';
    }
}
