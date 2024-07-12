<?php
header('Content-Type: application/json');
include('../connection/connect.php');

if (isset($_GET['id'])) {
    $dishId = $_GET['id'];

    // Fetch dish details
    $stmt = $connection->prepare("SELECT id, dish, description, img, category, schedule, updated_at FROM dishes WHERE id = ?");
    $stmt->bind_param('i', $dishId);
    $stmt->execute();
    $stmt->bind_result($id, $dish, $description, $img, $category, $schedule, $updated);
    $stmt->fetch();
    $stmt->close();

    // Fetch dish ingredients
    $stmt = $connection->prepare("
        SELECT i.id as ingredient_id, i.name, i.category, di.qty, di.unit 
        FROM dish_ingredients di 
        JOIN ingredients i ON di.ing_id = i.id 
        WHERE di.dish_id = ?
    ");
    $stmt->bind_param('i', $dishId);
    $stmt->execute();
    $result = $stmt->get_result();
    $ingredients = [];
    while ($row = $result->fetch_assoc()) {
        $ingredients[] = $row;
    }
    $stmt->close();

    $response = [
        'id' => $id,
        'dish' => $dish,
        'description' => $description,
        'img' => $img,
        'category' => $category,
        'schedule' => $schedule,
        'updated' => $updated,
        'ingredients' => $ingredients
    ];

    echo json_encode($response);
} else {
    echo json_encode(['error' => 'Dish ID not provided']);
}

$connection->close();
