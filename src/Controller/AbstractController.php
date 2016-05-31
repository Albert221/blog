<?php

namespace Albert221\Blog\Controller;

use Albert221\Blog\Repository\SettingRepositoryInterface;
use Twig_Environment;

abstract class AbstractController
{
    /**
     * @var Twig_Environment Twig
     */
    protected $twig;

    /**
     * @var SettingRepositoryInterface Settings
     */
    protected $settings;

    /**
     * @param Twig_Environment $twig
     */
    public function setTwig(Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param SettingRepositoryInterface $settings
     */
    public function setSettings(SettingRepositoryInterface $settings)
    {
        $this->settings = $settings;
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
