<?php

namespace Albert221\Blog\Sidebar\Widget;

class HTML implements WidgetInterface
{
    private $name;
    
    private $html;

    public function __construct($name, $html)
    {
        $this->name = $name;
        $this->html = $html;
    }
    
    public function getName()
    {
        return $this->name;
    }

    public function getHTML()
    {
        return $this->html;
    }
}
