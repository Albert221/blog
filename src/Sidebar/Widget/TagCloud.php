<?php

namespace Albert221\Blog\Sidebar\Widget;

use Albert221\Blog\Repository\TagRepositoryInterface;
use Twig_Environment;

class TagCloud implements WidgetInterface
{
    /**
     * @var TagRepositoryInterface
     */
    private $tags;

    /**
     * @var Twig_Environment
     */
    private $twig;

    public function __construct(TagRepositoryInterface $tags, Twig_Environment $twig)
    {
        $this->tags = $tags;
        $this->twig = $twig;
    }
    
    public function getName()
    {
        return 'Chmura tagów';
    }

    public function getHTML()
    {
        $tags = $this->tags->paginated(1, 50);
        
        return $this->twig->render('widgets/tag_cloud.twig', compact('tags'));
    }
}
