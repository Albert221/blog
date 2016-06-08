<?php

namespace Albert221\Blog\Controller;

use Albert221\Blog\Widget\TwigWidgetExtension;

class AbstractWidgetController extends AbstractController
{
    protected $widgetExtension;
    private $widgetsProvided = false;

    public function setWidgetExtension(TwigWidgetExtension $widgetExtension)
    {
        $this->widgetExtension = $widgetExtension;
    }
    
    protected function provideWidgets()
    {
        if ($this->widgetsProvided) {
            return;
        }
        
        $this->twig->addExtension($this->widgetExtension);
        $this->widgetsProvided = true;
    }
}
