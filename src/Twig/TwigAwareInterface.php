<?php

namespace Albert221\Blog\Twig;

interface TwigAwareInterface
{
    /**
     * @param \Twig_Environment $twig
     */
    public function setTwig($twig);
}