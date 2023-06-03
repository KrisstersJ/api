<?php

class ProductFactory
{
    private $productClassMapping = [
        'book' => 'BookProduct',
        'dvd' => 'DVDProduct',
        'furniture' => 'FurnitureProduct',
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
