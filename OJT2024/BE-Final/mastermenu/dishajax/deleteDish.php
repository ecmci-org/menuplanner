<?php
include('../connection/connect.php');

// Check if dish ID is provided and valid
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $dishId = $_GET['id'];

    // Fetch current image path from the database
    $stmtSelectImage = $connection->prepare("SELECT img FROM dishes WHERE id = ?");
    $stmtSelectImage->bind_param("i", $dishId);
    $stmtSelectImage->execute();
    $stmtSelectImage->bind_result($imgPath);
    $stmtSelectImage->fetch();
    $stmtSelectImage->close();

    // Delete dish ingredients first
    $stmtDeleteIngredients = $connection->prepare("DELETE FROM dish_ingredients WHERE dish_id = ?");
    $stmtDeleteIngredients->bind_param("i", $dishId);

    // Execute the statement to delete ingredients
    if ($stmtDeleteIngredients->execute()) {
        // Unlink the image file if it exists
        if ($imgPath && file_exists('../dish-images/' . $imgPath)) {
            unlink('../dish-images/' . $imgPath);
        }

        // Once ingredients are deleted, delete the dish
        $stmtDeleteDish = $connection->prepare("DELETE FROM dishes WHERE id = ?");
        $stmtDeleteDish->bind_param("i", $dishId);

        // Execute the statement to delete the dish
        if ($stmtDeleteDish->execute()) {
            // Success response
            $response = [
                'status' => 'success',
                'message' => 'Dish and associated ingredients deleted successfully!'
            ];
        } else {
            // Error response for deleting dish
            $response = [
                'status' => 'error',
                'message' => 'Failed to delete dish: ' . $stmtDeleteDish->error
            ];
        }

        $stmtDeleteDish->close();
    } else {
        // Error response for deleting ingredients
        $response = [
            'status' => 'error',
            'message' => 'Failed to delete ingredients: ' . $stmtDeleteIngredients->error
        ];
    }

    $stmtDeleteIngredients->close();
} else {
    // Invalid request response
    $response = [
        'status' => 'error',
        'message' => 'Invalid request. Please provide a valid dish ID.'
    ];
}

$connection->close();

// Output JSON response
header('Content-Type: application/json');
echo json_encode($response);
