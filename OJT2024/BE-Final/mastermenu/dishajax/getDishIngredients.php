<?php
include('../connection/connect.php');

if (isset($_GET['dish_id'])) {
    $dish_id = $_GET['dish_id'];

    $stmt = $connection->prepare("
        SELECT di.id, di.qty, di.unit, i.id AS ingredient_id, i.name, i.category 
        FROM dish_ingredients di
        JOIN ingredients i ON di.ing_id = i.id
        WHERE di.dish_id = ?
    ");
    $stmt->bind_param("i", $dish_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $dishIngredients = [];
    while ($row = $result->fetch_assoc()) {
        $dishIngredients[] = $row;
    }

    $stmt->close();
    $connection->close();

    echo json_encode($dishIngredients);
} else {
    echo json_encode([]);
}
