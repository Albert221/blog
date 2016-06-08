<?php

namespace Albert221\Blog\Controller;

use Albert221\Blog\Pagination\PaginatorBuilder;
use Albert221\Blog\Repository\PostRepositoryInterface;
use League\Route\Http\Exception\NotFoundException;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Request;

class PostController extends AbstractWidgetController
{
    /**
     * @var PostRepositoryInterface Posts
     */
    protected $posts;

    /**
     * @var PaginatorBuilder Paginator builder
     */
    protected $paginatorBuilder;

    public function __construct(
        PostRepositoryInterface $posts,
        PaginatorBuilder $paginatorBuilder
    ) {
        $this->posts = $posts;
        $this->paginatorBuilder = $paginatorBuilder;
    }

    /**
     * /
     *
     * @param  ServerRequestInterface $request
     *
     * @return string
     */
    public function index(ServerRequestInterface $request)
    {
        $this->provideWidgets();

        if (isset($request->getQueryParams()['q'])) {
            return $this->search($request, $request->getQueryParams()['q']);
        }

        $paginator = $this->paginatorBuilder->build($request, $this->posts->count());

        $posts = $this->posts->paginated($paginator->getCriteria());

        return $this->view('index.twig', compact('posts', 'paginator'));
    }

    /**
     * /{slug}
     *
     * @param string $slug
     * @return string
     * @throws NotFoundException when post does not exist
     */
    public function post($slug)
    {
        $this->provideWidgets();

        $post = $this->posts->bySlug($slug);

        if (!$post) {
            throw new NotFoundException('Post has not been found');
        }
        
        return $this->view('post.twig', compact('post'));
    }

    /**
     * /kategoria/{slug}
     *
     * @param ServerRequestInterface $request
     * @param string $slug
     * @return string
     */
    public function category(ServerRequestInterface $request, $slug)
    {
        $this->provideWidgets();

        $paginator = $this->paginatorBuilder->build($request, $this->posts->byCategoryCount($slug));

        $posts = $this->posts->byCategory($slug, $paginator->getCriteria());

        return $this->view('index.twig', [
            'posts' => $posts,
            'paginator' => $paginator,
            'title' => 'Posty w kategorii \''.$posts[0]->getCategory()->getName().'\''
        ]);
    }

    /**
     * /tag/{slug}
     *
     * @param ServerRequestInterface $request
     * @param string $slug
     * @return string
     */
    public function tag(ServerRequestInterface $request, $slug)
    {
        $this->provideWidgets();

        $paginator = $this->paginatorBuilder->build($request, $this->posts->byTagCount($slug));

        $posts = $this->posts->byTag($slug, $paginator->getCriteria());

        return $this->view('index.twig', [
            'posts' => $posts,
            'paginator' => $paginator,
            'title' => 'Posty otagowane \''.$slug.'\''
        ]);
    }

    /**
     * /?q={term}
     *
     * @param ServerRequestInterface $request
     * @param string $term
     * @return string
     */
    public function search(ServerRequestInterface $request, $term)
    {
        $paginator = $this->paginatorBuilder->build($request, $this->posts->searchCount($term));

        $posts = $this->posts->search($term, $paginator->getCriteria());

        return $this->view('index.twig', [
            'posts' => $posts,
            'paginator' => $paginator,
            'title' => 'Wyniki wyszukiwania dla \''.$term.'\'',
            'searchTerm' => $term
        ]);
    }
}
