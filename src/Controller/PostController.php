<?php

namespace Albert221\Blog\Controller;

use Albert221\Blog\Pagination\PaginatorBuilder;
use Albert221\Blog\Repository\CategoryRepositoryInterface;
use Albert221\Blog\Repository\PostRepositoryInterface;
use Albert221\Blog\Repository\TagRepositoryInterface;
use Albert221\Blog\Sidebar\Widget\HTML;
use Albert221\Blog\Sidebar\Widget\RecentCategories;
use Albert221\Blog\Sidebar\Widget\RecentPosts;
use Albert221\Blog\Sidebar\Widget\TagCloud;
use Albert221\Blog\Sidebar\WidgetManager;
use Psr\Http\Message\ServerRequestInterface;
use Twig_Environment;
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
        TagRepositoryInterface $tags,
        PaginatorBuilder $paginatorBuilder,
        Twig_Environment $twig
    ) {
        parent::__construct($twig);
        
        $this->posts = $posts;
        $this->categories = $categories;
        $this->paginatorBuilder = $paginatorBuilder;

        // TODO: Find a better place for everything below.

        $sidebarWidgetManager = new WidgetManager();
        $sidebarWidgetManager->add(new RecentPosts($this->posts, $twig, 10));
        $sidebarWidgetManager->add(new TagCloud($tags, $twig));

        $footerWidgetManager = new WidgetManager();
        $footerWidgetManager->add(new RecentPosts($this->posts, $twig, 5));
        $footerWidgetManager->add(new RecentCategories($this->categories, $twig, 5));
        $footerWidgetManager->add(new HTML('Polecane strony', '<ul>
            <li><a href="#">Lorem ipsum.</a></li>
            <li><a href="#">Amet, ipsam?</a></li>
            <li><a href="#">Animi, alias.</a></li>
            <li><a href="#">Sed, non.</a></li>
            <li><a href="#">Officiis, harum.</a></li>
        </ul>'));

        $this->twig->addGlobal('sidebarWidgets', $sidebarWidgetManager->getWidgets());
        $this->twig->addGlobal('footerWidgets', $footerWidgetManager->getWidgets());
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

        return $this->view('index.twig', [
            'posts' => $posts,
            'paginator' => $paginator
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
        $paginator = $this->paginatorBuilder->build($request, $this->posts->byCategoryCount($slug));

        $posts = $this->posts->byCategory($slug, $paginator->getPage(), $paginator->getPerPage());

        return $this->view('index.twig', compact('posts', 'paginator'));
    }

    /**
     * @param ServerRequestInterface $request
     * @param string $slug
     * @return string
     */
    public function tag(ServerRequestInterface $request, $slug)
    {
        $paginator = $this->paginatorBuilder->build($request, $this->posts->byTagCount($slug));

        $posts = $this->posts->byTag($slug, $paginator->getPage(), $paginator->getPerPage());

        return $this->view('index.twig', compact('posts', 'paginator'));
    }
}
