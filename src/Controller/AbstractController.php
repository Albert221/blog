<?php

namespace Albert221\Blog\Controller;

abstract class AbstractController
{
    /**
     * @var \Twig_Environment Twig
     */
    protected $twig;

    /**
     * @param $twig \Twig_Environment
     */
    public function setTwig($twig)
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
