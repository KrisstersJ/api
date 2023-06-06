<?php

class ProductFactory
{
    private $productClassMapping = [
        'Book' => 'BookProduct',
        'DVD' => 'DVDProduct',
        'Furniture' => 'FurnitureProduct',
    ];

    public function createProduct($productType, $productData)
    {
        if (isset($this->productClassMapping[$productType])) {
            $className = $this->productClassMapping[$productType];
            return new $className($productData->sku, $productData->name, $productData->price, $productData->attribute_value);
        }

        return null;
    }
}