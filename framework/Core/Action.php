<?php

declare(strict_types=1);

namespace Eric\Core;

abstract class Action implements \Eric\Core\ActionInterface
{
    /**
     * @return string
     */
    public function getArea(): string
    {
        return (!empty($pathInfo[1]) && $pathInfo[1] == "admin") ? "admin" : "frontend";
    }
}