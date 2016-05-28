<?php

namespace Albert221\Blog\Controller;

use Twig_Environment;

abstract class AbstractController
{
    /**
     * @var Twig_Environment Twig
     */
    protected $twig;

    /**
     * {@inheritdoc}
     */
    public function setTwig(Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param string $name View name
     * @param array  $data Data sent to view
     *
     * @return string
     */
    protected function view($name, $data = [])
    {
        return $this->twig->render($name, $data);
    }
}
