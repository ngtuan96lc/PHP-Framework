<?php

declare(strict_types=1);

namespace Eric\Core;

/**
 * Class View Core
 */
class View
{
    protected $template = null;

    protected $data = [];

    /**
     * @param $template
     */
    public function __construct($template)
    {
        $this->template = $template;
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function render()
    {
        $area = $this->getArea();
        $file = VIEW_PATH . $area . $this->template . ".phtml";
        if (file_exists($file)) {
            include($file);
        } else {
            throw new \Exception("Template {$this->template} not found!");
        }
    }

    /**
     * @return string
     */
    public function getArea(): string
    {
        return (!empty($pathInfo[1]) && $pathInfo[1] == "admin") ? "admin/" : "frontend/";
    }

    /**
     * @param $variable
     * @param $data
     * @return void
     */
    public function assign($variable, $data)
    {
        $this->data[$variable] = $data;
    }

    /**
     * @return array
     */
    public function toString(): array
    {
        return get_object_vars($this);
    }
}