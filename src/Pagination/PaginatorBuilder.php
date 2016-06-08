<?php

namespace Albert221\Blog\Pagination;

use Psr\Http\Message\ServerRequestInterface;

class PaginatorBuilder
{
    private $twig;
    private $perPage;

    /**
     * PaginatorBuilder constructor.
     *
     * @param \Twig_Environment $twig
     * @param int $perPage
     */
    public function __construct(\Twig_Environment $twig, $perPage)
    {
        $this->twig = $twig;
        $this->perPage = $perPage;
    }

    /**
     * @param ServerRequestInterface $request
     * @param int $count
     * @return Paginator
     */
    public function build(ServerRequestInterface $request, $count)
    {
        $page = isset($request->getQueryParams()['page']) &&
            (($page = $request->getQueryParams()['page']) > 0) ? $page : 1;
        
        return new Paginator(
            $page,
            $this->perPage,
            $count,
            $this->twig
        );
    }
}
