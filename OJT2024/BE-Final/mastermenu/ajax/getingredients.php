<?php
include('../connection/connect.php');
if (isset($_GET['category'])) {
    $category = $_GET['category'];
    $stmt = $connection->prepare("SELECT id, name FROM ingredients WHERE category = ?");
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();

    $ingredients = [];
    while ($row = $result->fetch_assoc()) {
        $ingredients[] = $row;
    }

    $stmt->close();
    $connection->close();

    echo json_encode($ingredients);
} else {
    echo json_encode([]);
}
