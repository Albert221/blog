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

    /**
     * @dataProvider constructorProvider
     */
    public function testRender($page, $perPage, $count)
    {
        $paginator = new Paginator($page, $perPage, $count, $this->twig);
        
        $this->assertEquals($paginator->render(), $page.' '.$perPage.' '.ceil($count / $perPage));
    }

    /**
     * @dataProvider constructorProvider
     */
    public function testCriteria($page, $perPage, $count)
    {
        $paginator = new Paginator($page, $perPage, $count, $this->twig);
        $criteria = $paginator->getCriteria();
        
        $this->assertEquals(($page - 1) * $perPage, $criteria->getFirstResult());
        $this->assertEquals($count, $criteria->getMaxResults());
    }

    public function constructorProvider()
    {
        return [
            [1, 5, 11]
        ];
    }
}
