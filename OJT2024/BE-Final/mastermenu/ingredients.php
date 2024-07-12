<?php include('includes/header.php') ?>

<?php
// Fetch all ingredients from the databases
$result = $connection->query("SELECT * FROM ingredients");

$ingredients = [];
while ($row = $result->fetch_assoc()) {
    $ingredients[] = $row;
}

$connection->close();
?>

<div class="wrapper">
    <?php include('includes/sidebar.php') ?>

    <div class="main">
        <?php include('includes/navbar.php') ?>

        <section class="p-3">
            <div class="row justify-content-end">
                <div class="col-auto">
                    <button class="btn btn-success newIngredient" data-bs-toggle="modal" data-bs-target="#ingredientForm">
                        <i class="bi bi-plus-lg"></i> Add Ingredient
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <table id="ingredientTable" class="table table-striped table-hover mt-3 text-center table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th class="text-center">Ingredient Name</th>
                                <th>Stock</th>
                                <th class="text-center">Unit</th>
                                <th>Price</th>
                                <th class="text-center">Category</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="data">
                            <?php foreach ($ingredients as $ingredient) { ?>
                                <tr>
                                    <td><?php echo $ingredient['id']; ?></td>
                                    <td><?php echo $ingredient['name']; ?></td>
                                    <td><?php echo $ingredient['stock']; ?></td>
                                    <td><?php echo $ingredient['unit']; ?></td>
                                    <td><?php echo $ingredient['price']; ?></td>
                                    <td><?php echo $ingredient['category']; ?></td>
                                    <td class="text-center">
                                        <button class="btn btn-success edit-ingredient" data-id="<?php echo $ingredient['id']; ?>"><i class="fa-regular fa-edit"></i></button>
                                        <button class="btn btn-danger delete-ingredient" data-id="<?php echo $ingredient['id']; ?>"><i class="fa-regular fa-trash-can"></i></button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!--Modal Form-->
        <div class="modal fade" id="ingredientForm">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Ingredient</h4>
                        </div>
                    <div class="modal-body">
                        <form action="#" id="ingForm" class="row g-3">
                            <div class="row">
                                <div class="col-md-6">
                                <div class="mb-3 margin-top-20">
                                        <label for="name" class="form-label"> Ingredient Name:</label>
                                        <input type="text" class="form-control" id="name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="stock" class="form-label">Stock:</label>
                                        <input type="text" class="form-control" id="stock" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3 margin-top-20">
                                        <label for="unit" class="form-label">Unit:</label>
                                        <select id="unit" class="form-select" required>
                                            <option value="kg">kg</option>
                                            <option value="lb">lb</option>
                                            <option value="pc">pc</option>
                                            <option value="l">l</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Price:</label>
                                        <input type="number" step="0.01" class="form-control" id="price" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <label for="category" class="form-label">Category:</label>
                                    <select id="category" class="form-select" required>
                                        <option value="Meat">Meat</option>
                                        <option value="Seafood">Seafood</option>
                                        <option value="Vegetables">Vegetables</option>
                                        <option value="Fruits">Fruits</option>
                                        <option value="Spices and Herbs">Spices and Herbs</option>
                                        <option value="Cereal and Pulses">Cereal and Pulses</option>
                                        <option value="Dairy Products">Dairy Products</option>
                                        <option value="Sugar and Sugar Products">Sugar and Sugar Products</option>
                                        <option value="Nuts and Oilseeds">Nuts and Oilseeds</option>
                                        <option value="Other Ingredients">Other Ingredients</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" form="ingForm" class="btn btn-success submit">Submit</button>
                    </div>
                </div>
            </div>
        </div>

        <!--Edit Data Modal-->
        <div class="modal fade" id="editIngredientModal">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Ingredient</h4>
                    </div>

                    <div class="modal-body">
                        <form action="#" id="editIngForm" class="row g-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="editName" class="form-label">Ingredient Name:</label>
                                        <input type="text" class="form-control" id="editName" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editStock" class="form-label">Stock:</label>
                                        <input type="text" class="form-control" id="editStock" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="editUnit" class="form-label">Unit:</label>
                                        <select id="editUnit" class="form-select" required>
                                            <option value="kg">kg</option>
                                            <option value="lb">lb</option>
                                            <option value="pc">pc</option>
                                            <option value="l">l</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editPrice" class="form-label">Price:</label>
                                        <input type="number" step="0.01" class="form-control" id="editPrice" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <label for="editCategory" class="form-label">Category:</label>
                                    <select id="editCategory" class="form-select" required>
                                        <option value="Meat">Meat</option>
                                        <option value="Seafood">Seafood</option>
                                        <option value="Vegetables">Vegetables</option>
                                        <option value="Fruits">Fruits</option>
                                        <option value="Spices and Herbs">Spices and Herbs</option>
                                        <option value="Cereal and Pulses">Cereal and Pulses</option>
                                        <option value="Dairy Products">Dairy Products</option>
                                        <option value="Sugar and Sugar Products">Sugar and Sugar Products</option>
                                        <option value="Nuts and Oilseeds">Nuts and Oilseeds</option>
                                        <option value="Other Ingredients">Other Ingredients</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" form="editIngForm" class="btn btn-success submit-edit">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#ingredientTable').DataTable({
            "order": [
                [0, 'desc']
            ]
        });

        $('#ingForm').on('submit', function(e) {
            e.preventDefault();

            const ingredientData = {
                name: $('#name').val(),
                stock: $('#stock').val(),
                unit: $('#unit').val(),
                price: $('#price').val(),
                category: $('#category').val()
            };

            $.ajax({
                type: 'POST',
                url: 'ajax/addingredients.php',
                data: ingredientData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Ingredient added successfully.'
                        }).then(function() {
                            location.reload(); // Reload page after success
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Failed to add ingredient: ' + response.message
                        });
                    }
                },
                error: function(error) {
                    console.log('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to add ingredient due to an internal error.'
                    });
                }
            });
        });

        // Handle click on edit-ingredient button
        $('.edit-ingredient').on('click', function() {
            var id = $(this).data('id');
            var ingredient = findIngredientById(id);

            // Check if ingredient was found
            if (ingredient) {
                // Populate edit modal fields with ingredient data
                $('#editName').val(ingredient.name);
                $('#editStock').val(ingredient.stock);
                $('#editUnit').val(ingredient.unit);
                $('#editPrice').val(ingredient.price);
                $('#editCategory').val(ingredient.category);

                // Set the `id` variable accessible globally
                window.editIngredientId = id;

                // Show the edit modal
                $('#editIngredientModal').modal('show');
            } else {
                console.error('Ingredient with ID ' + id + ' not found.');
                // Optionally, you can show an alert or handle this case as needed
            }
        });

        $('#editIngForm').on('submit', function(e) {
            e.preventDefault();

            const ingredientData = {
                id: window.editIngredientId,
                name: $('#editName').val(),
                stock: $('#editStock').val(),
                unit: $('#editUnit').val(),
                price: $('#editPrice').val(),
                category: $('#editCategory').val()
            };

            $.ajax({
                type: 'POST',
                url: 'ajax/editingredients.php',
                data: ingredientData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Ingredient updated successfully.'
                        }).then(function() {
                            location.reload(); // Reload page after success
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Failed to edit ingredient: ' + response.message
                        });
                    }
                },
                error: function(error) {
                    console.log('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to edit ingredient due to an internal error.'
                    });
                }
            });
        });

        $('.delete-ingredient').on('click', function() {
            var id = $(this).data('id');

            Swal.fire({
                icon: 'question',
                title: 'Are you sure?',
                text: 'you want to delete this ingredient?',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteIngredient(id);
                }
            });
        });

        function deleteIngredient(id) {
            $.ajax({
                type: 'POST',
                url: 'ajax/deleteingredients.php',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'Ingredient has been deleted successfully.'
                        }).then(function() {
                            location.reload(); // Reload page after success
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Failed to delete ingredient: ' + response.message
                        });
                    }
                },
                error: function(error) {
                    console.log('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to delete ingredient due to an internal error.'
                    });
                }
            });
        }

        // Function to find ingredient by ID (simulating data retrieval from the table)
        function findIngredientById(id) {
            // Loop through ingredients array (simulated data)
            var ingredients = <?php echo json_encode($ingredients); ?>;
            for (var i = 0; i < ingredients.length; i++) {
                if (ingredients[i].id == id) { // Use type coercion for comparison
                    return ingredients[i];
                }
            }
            return null; // Return null if ingredient with given ID is not found
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="Pages/script.js"></script>
<script src="Pages/app.js"></script>

</body>

</html>