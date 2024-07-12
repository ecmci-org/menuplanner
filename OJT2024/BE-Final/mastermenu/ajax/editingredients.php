<?php
// Include your database connection file
include('../connection/connect.php');

// Check if data is received via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve POST data
    $id = $_POST['id']; // Assuming the ingredient ID is passed
    $name = $_POST['name'];
    $stock = $_POST['stock'];
    $unit = $_POST['unit'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    // Validate input (you may need more robust validation as per your requirements)
    if (empty($name) || empty($stock) || empty($unit) || empty($price) || empty($category)) {
        $response = array(
            'success' => false,
            'message' => 'Please fill all required fields.'
        );
    } else {
        // Sanitize input data (optional, depending on your database library)
        $name = mysqli_real_escape_string($connection, $name);
        $stock = mysqli_real_escape_string($connection, $stock);
        $unit = mysqli_real_escape_string($connection, $unit);
        $price = mysqli_real_escape_string($connection, $price);

        // Update ingredient in the database
        // Update ingredient in the database
        $query = "UPDATE ingredients SET name='$name', stock='$stock', unit='$unit', price='$price', category='$category', updated_at=CURRENT_TIMESTAMP WHERE id='$id'";
        if ($connection->query($query) === TRUE) {
            $response = array(
                'success' => true,
                'message' => 'Ingredient updated successfully.'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Error updating ingredient: ' . $connection->error
            );
        }
    }

    // Close database connection
    $connection->close();

    // Return JSON response to the client-side JavaScript
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // If not a POST request, handle accordingly (optional)
    $response = array(
        'success' => false,
        'message' => 'Invalid request method.'
    );
    header('Content-Type: application/json');
    echo json_encode($response);
}
