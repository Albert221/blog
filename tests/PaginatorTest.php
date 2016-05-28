<?php

namespace Albert221\Blog\Pagination;

class PaginatorTest extends \PHPUnit_Framework_TestCase
{
    protected $twig;

    protected function setUp()
    {
        $this->twig = new \Twig_Environment(new \Twig_Loader_Array([
            'components/pagination.twig' => "{{ currentPage ~ ' ' ~ perPage ~ ' ' ~ pages }}"
        ]), [
            'autoescape' => false
        ]);
    }

    public function testRender()
    {
        $page = 1;
        $perPage = 5;
        $pages = 11;
        
        $paginator = new Paginator($page, $perPage, $pages, $this->twig);
        
        $this->assertEquals($paginator->render(), $page.' '.$perPage.' '.$pages);
    }
}
