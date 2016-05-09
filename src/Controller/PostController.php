<?php

namespace Albert221\Blog\Controller;

use Zend\Diactoros\Request;

class PostController extends AbstractController
{
    public function index()
    {
        return $this->view('index.twig');
    }
}