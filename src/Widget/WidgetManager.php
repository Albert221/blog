<?php

namespace Albert221\Blog\Widget;

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
