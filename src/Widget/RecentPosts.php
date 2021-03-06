<?php

namespace Albert221\Blog\Widget;

use Albert221\Blog\Repository\PostRepositoryInterface;
use Doctrine\Common\Collections\Criteria;
use Twig_Environment;

class RecentPosts implements WidgetInterface
{
    /**
     * @var PostRepositoryInterface
     */
    private $posts;

    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * @var int
     */
    private $count;

    public function __construct(PostRepositoryInterface $posts, Twig_Environment $twig, $count)
    {
        $this->posts = $posts;
        $this->twig = $twig;
        $this->count = $count;
    }

    public function getName()
    {
        return 'Ostatnie posty';
    }

    public function getHTML()
    {
        $criteria = Criteria::create()
            ->setMaxResults($this->count);

        $posts = $this->posts->paginated($criteria);

        return $this->twig->render('widgets/recent_posts.twig', compact('posts'));
    }
}
