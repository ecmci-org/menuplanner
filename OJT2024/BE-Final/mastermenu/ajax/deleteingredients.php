<?php
include('../connection/connect.php');

// Check if ID is provided via POST
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Prepare SQL statement to delete the ingredient
    $stmt = $connection->prepare("DELETE FROM ingredients WHERE id = ?");
    $stmt->bind_param("i", $id);

    // Execute the statement
    if ($stmt->execute()) {
        $response = [
            'success' => true,
            'message' => 'Ingredient deleted successfully.'
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'Failed to delete ingredient.'
        ];
    }

    // Close statement and connection
    $stmt->close();
    $connection->close();

    // Return the response as JSON
    echo json_encode($response);
} else {
    // If ID is not provided, return an error response
    $response = [
        'success' => false,
        'message' => 'ID not provided.'
    ];
    echo json_encode($response);
}
