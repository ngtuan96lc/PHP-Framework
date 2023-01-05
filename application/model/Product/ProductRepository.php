<?php

declare(strict_types=1);

namespace App\model\Product;

use Eric\database\MySql;

/**
 * Product Repository | CRUD actions
 */
class ProductRepository implements ProductRepositoryInterface
{

    /**
     * @var MySql
     */
    private $mysql;

    public function __construct()
    {
        $this->mysql = new MySql();
    }

    /**
     * @param $entityId
     * @return Product
     */
    public function get($entityId): Product
    {
        $query = "SELECT * FROM product WHERE entity_id = {$entityId}";
        $sqlExecuted = $this->mysql->execute($query);

        $productConvert = new ProductConvert();
        $productConverted = $productConvert->execute($sqlExecuted);
        $productConverted = $productConverted[0];

        $productModel = new Product();
        $productModel->setEntityId($productConverted[ProductInterface::ENTITY_ID]);
        $productModel->setName($productConverted[ProductInterface::NAME]);
        $productModel->setSku($productConverted[ProductInterface::SKU]);
        $productModel->setQuantity($productConverted[ProductInterface::QUANTITY]);

        return $productModel;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $query = "SELECT * FROM product";
        $sqlExecuted = $this->mysql->fetchAll($query);

        $productConvert = new ProductConvert();
        $productConverted = $productConvert->execute($sqlExecuted);

        $result = [];
        foreach ($productConverted as $item) {
            $productModel = new Product();
            $productModel->setEntityId($item[ProductInterface::ENTITY_ID]);
            $productModel->setName($item[ProductInterface::NAME]);
            $productModel->setSku($item[ProductInterface::SKU]);
            $productModel->setQuantity($item[ProductInterface::QUANTITY]);
            $result[] = $productModel;
        }
        return $result;
    }

    /**
     * @param $entityId
     * @return bool
     */
    public function delete($entityId): bool
    {
        $query = "DELETE FROM product WHERE entity_id = {$entityId}";
        $sqlExecuted = $this->mysql->execute($query);
        return (bool)$sqlExecuted;
    }

    /**
     * @param ProductInterface $product
     * @return Product
     */
    public function update(ProductInterface $product): Product
    {
        $query = "UPDATE product SET name = '{$product->getName()}', sku = '{$product->getSku()}', quantity = '{$product->getQuantity()}' WHERE entity_id = {$product->getEntityId()}";
        $sqlExecuted = $this->mysql->execute($query);
        return $this->get($product->getEntityId());
    }

    /**
     * @param ProductInterface $product
     * @return Product
     */
    public function add(ProductInterface $product): Product
    {
        $query = "INSERT INTO product (name, sku, quantity) VALUES ('{$product->getName()}', '{$product->getSku()}', {$product->getQuantity()})";
        $sqlExecuted = $this->mysql->execute($query);
        return $this->get($this->mysql->getLatestInsertId());
    }

    /**
     * @return mixed
     */
    private function latestId()
    {
        $query = "SELECT * FROM product ORDER BY entity_id DESC";
        $sqlExecuted = $this->mysql->execute($query);

        $productConvert = new ProductConvert();
        $productConverted = $productConvert->execute($sqlExecuted);
        return $productConverted['entity_id'];
    }
}