<?php
include('../connection/connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $stock = $_POST['stock'];
    $unit = $_POST['unit'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    $stmt = $connection->prepare("INSERT INTO ingredients (name, stock, unit, price, category, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())");
    $stmt->bind_param('sssds', $name, $stock, $unit, $price, $category);

    if ($stmt->execute()) {
        $newId = $stmt->insert_id;
        $responseData = [
            'id' => $newId,
            'name' => $name,
            'stock' => $stock,
            'unit' => $unit,
            'price' => $price,
            'category' => $category
        ];

        $stmt->close();
        $connection->close();

        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'data' => $responseData]);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Failed to insert data']);
    }
}
