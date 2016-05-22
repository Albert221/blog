<?php

namespace Albert221\Blog\Sidebar;

use Albert221\Blog\Sidebar\Widget\WidgetInterface;

class WidgetManager
{
    /**
     * @var WidgetInterface[] Widgets
     */
    private $widgets;

    public function add(WidgetInterface $widget)
    {
        $this->widgets[] = $widget;
    }

    public function getWidgets()
    {
        return $this->widgets;
    }
}
