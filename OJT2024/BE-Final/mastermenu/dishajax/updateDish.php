<?php
header('Content-Type: application/json');
include('../connection/connect.php');

$data = $_POST;  // Using $_POST since FormData was sent from JavaScript

if (isset($data['id'])) {
    $dishId = $data['id'];
    $dishName = $data['dish'];
    $category = $data['category'];
    $schedule = $data['schedule'];
    $description = $data['description'];
    $ingredients = json_decode($data['ingredients'], true);

    // Handle file upload if a new file is provided
    if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
        // Remove existing image if it exists
        $stmt = $connection->prepare("SELECT img FROM dishes WHERE id = ?");
        $stmt->bind_param('i', $dishId);
        $stmt->execute();
        $stmt->bind_result($currentImg);
        $stmt->fetch();
        $stmt->close();

        if ($currentImg && file_exists('../dish-images/' . $currentImg)) {
            unlink('../dish-images/' . $currentImg); // Unlink the current image
        }

        // Move uploaded file to dish-images directory with a unique filename
        $targetDir = '../dish-images/';
        $imgName = uniqid('dish_img_') . '_' . basename($_FILES['img']['name']); // Generate unique filename
        $newFileName = $targetDir . $imgName; // Full path to the new file
        $tmpName = $_FILES['img']['tmp_name'];

        if (!move_uploaded_file($tmpName, $newFileName)) {
            echo json_encode(['success' => false, 'message' => 'Failed to move uploaded file.']);
            exit;
        }

        // Update imgPath to the new filename (without path)
        $imgPath = $imgName;
    } else {
        $imgPath = null; // No new image provided
    }

    // Start transaction
    $connection->begin_transaction();

    try {
        // Update dish details including the image path if it's updated
        if ($imgPath) {
            $stmt = $connection->prepare("UPDATE dishes SET dish = ?, category = ?, schedule = ?, description = ?, img = ?, updated_at = NOW() WHERE id = ?");
            $stmt->bind_param('sssssi', $dishName, $category, $schedule, $description, $imgPath, $dishId);
        } else {
            $stmt = $connection->prepare("UPDATE dishes SET dish = ?, category = ?, schedule = ?, description = ?, updated_at = NOW() WHERE id = ?");
            $stmt->bind_param('ssssi', $dishName, $category, $schedule, $description, $dishId);
        }
        $stmt->execute();
        $stmt->close();

        // Delete existing ingredients for the dish
        $stmt = $connection->prepare("DELETE FROM dish_ingredients WHERE dish_id = ?");
        $stmt->bind_param('i', $dishId);
        $stmt->execute();
        $stmt->close();

        // Insert updated ingredients
        $stmt = $connection->prepare("INSERT INTO dish_ingredients (dish_id, ing_id, qty, unit, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
        foreach ($ingredients as $ingredient) {
            $stmt->bind_param('iiis', $dishId, $ingredient['id'], $ingredient['qty'], $ingredient['unit']);
            $stmt->execute();
        }
        $stmt->close();

        // Commit transaction
        $connection->commit();

        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        // Rollback transaction on error
        $connection->rollback();

        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}

$connection->close();
