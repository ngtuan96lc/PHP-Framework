<?php

declare(strict_types=1);

namespace App\model\Product;

/**
 * Model Product Convert
 */
class ProductConvert
{
    const COLUMNS = [
        'entity_id',
        'name',
        'sku',
        'quantity'
    ];

    /**
     * @param $rawData
     * @return array
     */
    public function execute($rawData): array
    {
        $result = [];
        foreach ($rawData as $item) {
            $result[] = array_combine(self::COLUMNS, $item);
        }
        return $result;
    }
}