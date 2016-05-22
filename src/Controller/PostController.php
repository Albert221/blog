<?php

namespace Albert221\Blog\Controller;

use Albert221\Blog\Pagination\PaginatorBuilder;
use Albert221\Blog\Repository\CategoryRepositoryInterface;
use Albert221\Blog\Repository\PostRepositoryInterface;
use Albert221\Blog\Sidebar\Widget\RecentPosts;
use Albert221\Blog\Sidebar\WidgetManager;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Request;

class PostController extends AbstractController
{
    /**
     * @var PostRepositoryInterface Posts
     */
    protected $posts;

    /**
     * @var CategoryRepositoryInterface Categories
     */
    protected $categories;

    /**
     * @var PaginatorBuilder Paginator builder
     */
    protected $paginatorBuilder;

    public function __construct(
        PostRepositoryInterface $posts,
        CategoryRepositoryInterface $categories,
        PaginatorBuilder $paginatorBuilder
    ) {
        $this->posts = $posts;
        $this->categories = $categories;
        $this->paginatorBuilder = $paginatorBuilder;
    }

    /**
     * Route: /
     *
     * @param  ServerRequestInterface $request
     *
     * @return string
     */
    public function index(ServerRequestInterface $request)
    {
        $paginator = $this->paginatorBuilder->build($request, $this->posts->count());

        $posts = $this->posts->paginated($paginator->getPage(), $paginator->getPerPage());

        // TODO: Move code from here
        
        $sidebarWidgetManager = new WidgetManager();

        $recentPostsWidget = new RecentPosts($this->posts, $this->twig);
        $sidebarWidgetManager->add($recentPostsWidget);

        // to here to place where this should be at

        return $this->view('index.twig', [
            'posts' => $posts,
            'paginator' => $paginator,
            'sidebarWidgets' => $sidebarWidgetManager->getWidgets()
        ]);
    }

    /**
     * Route: /{slug}
     *
     * @param string $slug
     * @return string
     */
    public function post($slug)
    {
        $post = $this->posts->bySlug($slug);
        
        return $this->view('post.twig', compact('post'));
    }

    /**
     * Route: /kategoria/{slug}
     *
     * @param ServerRequestInterface $request
     * @param string $slug
     * @return string
     */
    public function category(ServerRequestInterface $request, $slug)
    {
        $paginator = $this->paginatorBuilder->build($request, $this->categories->postsCount($slug));

        $posts = $this->categories->postsPaginated($slug, $paginator->getPage(), $paginator->getPerPage());

        return $this->view('index.twig', [
            'posts' => $posts,
            'paginator' => $paginator
        ]);
    }
}
