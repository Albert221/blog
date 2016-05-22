<?php

namespace Albert221\Blog\Sidebar\Widget;

use Albert221\Blog\Repository\PostRepositoryInterface;
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

    public function __construct(PostRepositoryInterface $posts, Twig_Environment $twig)
    {
        $this->posts = $posts;
        $this->twig = $twig;
    }

    public function getName()
    {
        return 'Najnowsze posty';
    }

    public function getHTML()
    {
        $posts = $this->posts->paginated(1, 10);

        return $this->twig->render('widgets/recent_posts.twig', compact('posts'));
    }
}
