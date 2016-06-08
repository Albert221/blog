<?php

namespace Albert221\Blog\Pagination;

use Doctrine\Common\Collections\Criteria;
use Twig_Environment;

class Paginator
{
    private $currentPage;
    private $perPage;
    private $count;
    private $criteria;
    private $twig;

    /**
     * Paginator constructor.
     *
     * @param $page
     * @param $perPage
     * @param $count
     * @param Twig_Environment $twig
     */
    public function __construct($page, $perPage, $count, Twig_Environment $twig)
    {
        $this->currentPage = $page;
        $this->perPage = $perPage;
        $this->count = $count;
        $this->twig = $twig;
        
        $this->criteria = Criteria::create()
            ->setFirstResult(($page - 1) * $perPage)
            ->setMaxResults($count);
    }

    /**
     * @return string
     */
    public function render()
    {
        return $this->twig->render('components/pagination.twig', [
            'currentPage' => $this->currentPage,
            'perPage' => $this->perPage,
            'pages' => ceil($this->count / $this->perPage)
        ]);
    }

    /**
     * @return int
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * @return int
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     * @return Criteria
     */
    public function getCriteria()
    {
        return $this->criteria;
    }
}
