<?php

namespace Albert221\Blog\Controller;

use Albert221\Blog\Widget\TwigWidgetExtension;

class AbstractWidgetController extends AbstractController
{
    protected $widgetExtension;

    public function setWidgetExtension(TwigWidgetExtension $widgetExtension)
    {
        $this->widgetExtension = $widgetExtension;
    }
    
    protected function provideWidgets()
    {
        $this->twig->addExtension($this->widgetExtension);
    }
}
