<?php

namespace Albert221\Blog\Widget;

use Albert221\Blog\Repository\CategoryRepositoryInterface;
use Twig_Environment;

class RecentCategories implements WidgetInterface
{
    /**
     * @var CategoryRepositoryInterface
     */
    private $categories;

    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * @var int
     */
    private $count;

    public function __construct(CategoryRepositoryInterface $categories, Twig_Environment $twig, $count)
    {
        $this->categories = $categories;
        $this->twig = $twig;
        $this->count = $count;
    }

    public function getName()
    {
        return 'Ostatnie kategorie';
    }

    public function getHTML()
    {
        $categories = $this->categories->lastCategories($this->count);

        return $this->twig->render('widgets/recent_categories.twig', compact('categories'));
    }
}
