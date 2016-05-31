<?php

namespace Albert221\Blog\Pagination;

class Paginator
{
    private $currentPage;
    
    private $perPage;
    
    private $pages;
    
    private $twig;
    
    public function __construct($page, $perPage, $pages, \Twig_Environment $twig)
    {
        $this->currentPage = $page;
        $this->perPage = $perPage;
        $this->pages = $pages;
        $this->twig = $twig;
    }

    public function render()
    {
        return $this->twig->render('components/pagination.twig', [
            'currentPage' => $this->currentPage,
            'perPage' => $this->perPage,
            'pages' => $this->pages
        ]);
    }

    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    public function getPerPage()
    {
        return $this->perPage;
    }
}
