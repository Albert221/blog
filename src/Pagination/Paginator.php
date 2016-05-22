<?php

namespace Albert221\Blog\Pagination;

class Paginator
{
    private $page;
    
    private $perPage;
    
    private $pages;
    
    private $twig;
    
    public function __construct($page, $perPage, $pages, \Twig_Environment $twig)
    {
        $this->page = $page;
        $this->perPage = $perPage;
        $this->pages = $pages;
        $this->twig = $twig;
    }

    public function render()
    {
        return $this->twig->render('components/pagination.twig', [
            'currentPage' => $this->page,
            'perPage' => $this->perPage,
            'pages' => $this->pages
        ]);
    }

    public function getPage()
    {
        return $this->page;
    }

    public function getPerPage()
    {
        return $this->perPage;
    }
}
