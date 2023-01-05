<?php

declare(strict_types=1);

namespace Eric\Core;

interface ActionInterface
{
    public function execute($args);
}