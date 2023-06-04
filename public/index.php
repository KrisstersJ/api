<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE");

include '../database/DbConnect.php';
include '../controllers/ProductController.php';

$objDb = new DbConnect;
$conn = $objDb->connect();

$method = $_SERVER['REQUEST_METHOD'];

$productController = new ProductController();

switch ($method) {
    case "GET":
        $sql = "SELECT * FROM products ORDER BY id ASC";
        $path = explode('/', $_SERVER['REQUEST_URI']);
        if (isset($path[3]) && is_numeric($path[3])) {
            $sql .= " WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $path[3]);
            $stmt->execute();
            $products = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $products = $productController->getAllProducts($conn);
        }

        echo json_encode($products);
        break;
    case "POST":
        $productData = json_decode(file_get_contents('php://input'));

        $product = $productController->createProduct($productData, $conn);
        if ($product) {
            $response = ['status' => 1, 'message' => 'Record created successfully'];
        } else {
            $response = ['status' => 0, 'message' => 'Failed to create record'];
        }

        echo json_encode($response);
        break;
    case "DELETE":
        $productIds = json_decode(file_get_contents('php://input'));
        $result = $productController->deleteProduct($productIds, $conn);
        if ($result) {
            $response = ['status' => 1, 'message' => 'Products deleted successfully'];
        } else {
            $response = ['status' => 0, 'message' => 'Failed to delete products'];
        }

        echo json_encode($response);
        break;

}