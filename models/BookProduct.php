<?php


class BookProduct extends AbstractProduct
{
    private $weight;

    public function __construct($sku, $name, $price, $weight)
    {
        parent::__construct($sku, $name, $price);
        $this->weight = $weight;
    }

    public function save($conn)
    {
        global $conn;

        $sql = "INSERT INTO products(id, sku, name, price, attribute, attribute_value, created_at) VALUES(null, :sku, :name, :price, :attribute, :attribute_value, :created_at)";
        $stmt = $conn->prepare($sql);
        $created_at = date('Y-m-d');
        $sku = $this->getSku();
        $name = $this->getName();
        $price = $this->getPrice();
        $attribute = "Size";
        $weight = $this->weight;

        $stmt->bindParam(':sku', $sku);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':attribute', $attribute);
        $stmt->bindParam(':attribute_value', $weight);
        $stmt->bindParam(':created_at', $created_at);

        return $stmt->execute();
    }
}