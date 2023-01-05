<?php

declare(strict_types=1);

namespace App\model\Product;

interface ProductInterface
{
    const ENTITY_ID = 'entity_id';
    const NAME = 'name';
    const SKU = 'sku';
    const QUANTITY = 'quantity';

    public function getEntityId();

    public function setEntityId($entityId);

    public function getName();

    public function setName($name);

    public function getSku();

    public function setSku($sku);

    public function getQuantity();

    public function setQuantity($quantity);
}