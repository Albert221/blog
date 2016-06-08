<?php

namespace Albert221\Blog\Widget;

use Albert221\Blog\Repository\TagRepositoryInterface;
use Doctrine\Common\Collections\Criteria;
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
        $criteria = Criteria::create()
            ->setMaxResults(50);
        
        $tags = $this->tags->paginated($criteria);
        
        return $this->twig->render('widgets/tag_cloud.twig', compact('tags'));
    }
}
