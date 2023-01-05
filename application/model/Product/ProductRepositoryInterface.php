<?php

declare(strict_types=1);

namespace App\model\Product;

interface ProductRepositoryInterface
{
    public function get($entityId);

    public function getAll(): array;

    public function delete($entityId);

    public function update(ProductInterface $product);

    public function add(ProductInterface $product);
}