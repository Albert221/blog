<?php

namespace Albert221\Blog\Pagination;

use Psr\Http\Message\ServerRequestInterface;

class PaginatorBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $twig = new \Twig_Environment;
        $perPage = 5;
        $page = 1;
        $pages = 11;

        $paginatorBuilder = new PaginatorBuilder($twig, $perPage);

        $request = $this->getMock(ServerRequestInterface::class);

        $request->method('getQueryParams')
            ->willReturn(['page' => $page]);
        
        $paginator = $paginatorBuilder->build($request, $pages);
        
        $this->assertEquals($perPage, $paginator->getPerPage());
        $this->assertEquals($page, $paginator->getCurrentPage());
    }
}
