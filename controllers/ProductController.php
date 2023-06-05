<?php
include '../models/AbstractProduct.php';
include '../models/DVDProduct.php';
include '../models/BookProduct.php';
include '../models/FurnitureProduct.php';
include '../models/ProductFactory.php';
include '../database/Dbconnect.php';

class ProductController
{
    public function createProduct($productData, $conn)
    {
        $productFactory = new ProductFactory();

        $productType = $productData->attribute;
        $product = $productFactory->createProduct($productType, $productData);

        if ($product) {
            $existingProduct = $this->getProductBySku($product->getSku(), $conn);
            if ($existingProduct) {
                return ['status' => 0, 'message' => 'SKU already exists', 'product' => $existingProduct];
            }

            $result = $product->save($conn);
            if ($result) {
                return ['status' => 1, 'message' => 'Record created successfully'];
            } else {
                return ['status' => 0, 'message' => 'Failed to create record'];
            }
        }

        return ['status' => 0, 'message' => 'Invalid product type'];
    }

    private function getProductBySku($sku, $conn)
    {
        $sql = "SELECT * FROM products WHERE sku = :sku";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':sku', $sku);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        return $product;
    }

    public function getAllProducts($conn)
    {
        $sql = "SELECT * FROM products";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    }

    public function deleteProduct($productIds, $conn)
    {
        $sql = "DELETE FROM products WHERE id IN (" . implode(",", $productIds) . ")";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}