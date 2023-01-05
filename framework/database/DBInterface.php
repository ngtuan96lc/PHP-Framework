<?php

declare(strict_types=1);

namespace Eric\database;

interface DBInterface
{
    public function execute($sqlQuery);

    public function fetch($sqlQuery);

    public function fetchAll($sqlQuery): array;

    public function errorCode(): string;

    public function errorInfo();

    public function getLatestInsertId();
}