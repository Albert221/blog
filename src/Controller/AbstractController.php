<?php

namespace Albert221\Blog\Controller;

use Albert221\Blog\Twig\TwigAwareInterface;

abstract class AbstractController implements TwigAwareInterface
{
    /**
     * @var \Twig_Environment Twig
     */
    protected $twig;

    /**
     * {@inheritdoc}
     */
    public function setTwig($twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param string $name View name
     * @param array $data Data sent to view
     *
     * @return string
     */
    protected function view($name, $data = [])
    {
        return $this->twig->render($name, $data);
    }
}