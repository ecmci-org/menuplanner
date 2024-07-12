<?php
include('../connection/connect.php');


// Check if file upload is set and handle errors
if (!isset($_FILES['img']) || $_FILES['img']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid or missing file upload.']);
    exit();
}

// Directory where you want to store uploaded images
$uploadDir = '../dish-images/';

// Ensure the upload directory exists, create it if not
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Check file type if needed (example: allow only JPEG images)
$allowedTypes = ['image/jpeg', 'image/jpg', 'image/png']; // Add more if needed
if (!in_array($_FILES['img']['type'], $allowedTypes)) {
    echo json_encode(['status' => 'error', 'message' => 'Only JPG, JPEG, or PNG files are allowed.']);
    exit();
}

// Generate a unique filename for the uploaded image
$imgName = uniqid('dish_img_') . '_' . basename($_FILES['img']['name']);
$imgPath = $uploadDir . $imgName;

// Move the uploaded file to the specified directory
if (!move_uploaded_file($_FILES['img']['tmp_name'], $imgPath)) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to move uploaded file.']);
    exit();
}

// Retrieve other form data
$dish = $_POST['dish'];
$category = $_POST['category'];
$schedule = $_POST['schedule'];
$description = $_POST['description'];
$ingredients = json_decode($_POST['ingredients'], true); // Decode JSON string

// Insert the dish into the `dishes` table
$stmt = $connection->prepare("INSERT INTO dishes (dish, category, schedule, description, img) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $dish, $category, $schedule, $description, $imgName);

if ($stmt->execute()) {
    $dishId = $stmt->insert_id;

    // Insert each ingredient into the `dish_ingredients` table
    $stmtIngredients = $connection->prepare("INSERT INTO dish_ingredients (dish_id, ing_id, qty, unit) VALUES (?, ?, ?, ?)");
    foreach ($ingredients as $ingredient) {
        $stmtIngredients->bind_param("iiss", $dishId, $ingredient['id'], $ingredient['qty'], $ingredient['unit']);
        $stmtIngredients->execute();
    }
    $stmtIngredients->close();

    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => $stmt->error]);
}

$stmt->close();
$connection->close();
