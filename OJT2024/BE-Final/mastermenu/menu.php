<?php include('includes/header.php') ?>

<div class="wrapper">
    <?php include('includes/sidebar.php') ?>

    <div class="main">
        <?php include('includes/navbar.php') ?>

        <section class="p-3">
            <div class="row justify-content-end">
                <div class="col-auto">
                    <button class="btn btn-success newMenu" data-bs-toggle="modal" data-bs-target="#menuForm">
                        <i class="bi bi-plus-lg"></i> New Dish
                    </button>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-12 mb-3">
                        <h1>Category</h1>
                        <button type="button" class="btn btn-success filter-category" data-category="All">All</button>
                        <button type="button" class="btn btn-success filter-category" data-category="Breakfast">Breakfast</button>
                        <button type="button" class="btn btn-success filter-category" data-category="Lunch">Lunch</button>
                        <button type="button" class="btn btn-success filter-category" data-category="Snacks">Snacks</button>
                        <button type="button" class="btn btn-success filter-category" data-category="Dinner">Dinner</button>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row row-cols-12" id="menu-items">
                    <?php
                    include('connection/connect.php');

                    $stmt = $connection->prepare("SELECT id, dish, description, img, category FROM dishes");
                    $stmt->execute();
                    $stmt->bind_result($id, $dish, $description, $img, $category);

                    while ($stmt->fetch()) {
                        echo '
                            <div class="col-3 dish-item" data-category="' . $category . '">
                                <div class="card px-0">
                                    <img src="dish-images/' . $img . '" class="card-img-top" alt="' . $dish . '">
                                    <div class="card-body">
                                        <h5 class="card-title">' . $dish . '</h5>
                                        <p class="card-text text-truncate">' . $description . '</p>
                                        <a href="#" class="btn btn-success view-details" data-id="' . $id . '">View Details</a>
                                        <button class="btn btn-danger delete-dish" data-id="' . $id . '"><i class="bi bi-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                            ';
                    }

                    $stmt->close();
                    $connection->close();
                    ?>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- Add Dish Modal Form -->
<div class="modal fade" id="menuForm">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Dish</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="myForm" class="row g-3" enctype="multipart/form-data">
                    <div class="col-md-4">
                        <div class="card imgholder text-center">
                            <label for="imgInput" class="upload">
                                <input type="file" id="imgInput" name="img">
                                <i class="bi bi-plus-circle-dotted"></i>
                            </label>
                            <img src="./images/Foodd.jpg" alt="" class="img-fluid img">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="name" class="form-label">Dish Name:</label>
                            <input type="text" class="form-control" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Category:</label>
                            <select id="category" class="form-select" required>
                                <option value="Breakfast">Breakfast</option>
                                <option value="Lunch">Lunch</option>
                                <option value="Dinner">Dinner</option>
                                <option value="Snacks">Snacks</option>
                                <!-- Add more options as needed -->
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="unit" class="form-label">Ingredients:</label>
                            <div id="ingredient-tags" class="mt-2 overflow-y-auto border rounded p-2" style="max-height: 200px;">
                                <button type="button" class="btn btn-primary" style="background-color: rgba(213, 255, 194, 0.93);" onclick="addRow()">Add Ingredient</button>
                                <table class="table">
                                    <tbody id="ingredientTable">
                                        <tr>
                                            <td>
                                                <select class="form-select category-select" name="category[]" required>
                                                    <option value="">Select Category</option>
                                                    <?php
                                                    $categories = [
                                                        "Meat", "Seafood", "Vegetables", "Fruits",
                                                        "Spices and Herbs", "Cereal and Pulses",
                                                        "Dairy Products", "Sugar and Sugar Products",
                                                        "Nuts and Oilseeds", "Other Ingredients"
                                                    ];
                                                    foreach ($categories as $category) {
                                                        echo "<option value='$category'>$category</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-select ingredient-select" name="ingredient[]" required>
                                                    <option value=''>Select Ingredient</option>
                                                </select>
                                            </td> <!-- Placeholder for dynamic ingredient select -->
                                            <td><input type="number" class="form-control" name="qty[]" placeholder="Qty" required></td>
                                            <td><input type="text" class="form-control" name="unit[]" placeholder="Unit" required></td>
                                            <td><button type="button" class="btn btn-danger" onclick="removeRow(this)">Delete</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="sDate" class="form-label">Schedule:</label>
                            <input type="date" class="form-control" id="sDate" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description:</label>
                            <textarea id="description" class="form-control" required></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" onclick="submitForm()">Submit</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Viewing Dish Details -->
<div class="modal fade" id="dishDetailsModal" tabindex="-1" aria-labelledby="dishDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dishDetailsModalLabel">Dish Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h3 id="dish-name"></h3>
                <p id="dish-category"></p>
                <img id="dish-img" src="" class="img-fluid mb-3" alt="">
                <p id="dish-description"></p>
                <h4>Ingredients List:</h4>
                <ul id="dish-ingredients"></ul>
                <p><strong>Schedule:</strong> <span id="dish-schedule"></span></p>
                <p><strong>Last Updated:</strong> <span id="dish-updated"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="editDishButton">Edit</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Dish Modal Form -->
<div class="modal fade" id="editMenuForm" tabindex="-1" aria-labelledby="editMenuFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Dish</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" class="row g-3" enctype="multipart/form-data">
                    <div class="col-md-4">
                        <div class="card imgholder text-center">
                            <label for="editImgInput" class="upload">
                                <input type="file" id="editImgInput">
                                <i class="bi bi-plus-circle-dotted"></i>
                            </label>
                            <img src="./images/Foodd.jpg" alt="" class="img-fluid img" id="editImg">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <input type="hidden" id="editDishId">
                        <div class="mb-3">
                            <label for="editName" class="form-label">Dish Name:</label>
                            <input type="text" class="form-control" id="editName" required>
                        </div>
                        <div class="mb-3">
                            <label for="editCategory" class="form-label">Category:</label>
                            <select id="editCategory" class="form-select" required>
                                <option value="Breakfast">Breakfast</option>
                                <option value="Lunch">Lunch</option>
                                <option value="Dinner">Dinner</option>
                                <option value="Snacks">Snacks</option>
                                <!-- Add more options as needed -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editUnit" class="form-label">Ingredients:</label>
                            <div id="editIngredientTags" class="mt-2 overflow-y-auto border rounded p-2" style="max-height: 200px;">
                                <button type="button" class="btn btn-primary" style="background-color: rgba(213, 255, 194, 0.93);" onclick="addEditRow()">Add Ingredient</button>
                                <table class="table">
                                    <tbody id="editIngredientTable">
                                        <!-- Dynamically populated rows -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editSDate" class="form-label">Schedule:</label>
                            <input type="date" class="form-control" id="editSDate" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDescription" class="form-label">Description:</label>
                            <textarea id="editDescription" class="form-control" required></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" onclick="submitEditForm()">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add event listeners to filter buttons
        const filterButtons = document.querySelectorAll('.filter-category');
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                const category = this.getAttribute('data-category');
                filterDishes(category);
            });
        });

        // Add event listeners to "View Details" buttons
        const viewDetailsButtons = document.querySelectorAll('.view-details');
        viewDetailsButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const dishId = this.getAttribute('data-id');
                fetchDishDetails(dishId);
            });
        });

        // Add event listener for edit button in dish details modal
        document.getElementById('editDishButton').addEventListener('click', function() {
            fetchDishDetailsForEdit(currentDishId);
        });

        // Add event listener for delete buttons
        const deleteButtons = document.querySelectorAll('.delete-dish');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const dishId = this.getAttribute('data-id');
                deleteDish(dishId);
            });
        });
    });

    let currentDishId = null;

    function filterDishes(category) {
        const dishes = document.querySelectorAll('.dish-item');
        dishes.forEach(dish => {
            const dishCategory = dish.getAttribute('data-category');
            if (category === 'All' || dishCategory === category) {
                dish.style.display = 'block';
            } else {
                dish.style.display = 'none';
            }
        });
    }

    function fetchDishDetails(dishId) {
        fetch(`dishajax/getDishDetails.php?id=${dishId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('dish-name').innerText = data.dish;
                document.getElementById('dish-category').innerText = data.category;
                document.getElementById('dish-img').src = 'dish-images/' + data.img;
                document.getElementById('dish-description').innerText = data.description;
                document.getElementById('dish-schedule').innerText = data.schedule;
                document.getElementById('dish-updated').innerText = data.updated;

                const ingredientsList = document.getElementById('dish-ingredients');
                ingredientsList.innerHTML = '';
                data.ingredients.forEach(ingredient => {
                    const li = document.createElement('li');
                    li.innerText = `${ingredient.qty} ${ingredient.unit} ${ingredient.name}`;
                    li.style.listStyleType = 'disc';
                    ingredientsList.appendChild(li);
                });

                // Set the current dish ID for editing
                currentDishId = dishId;

                // Set the dish ID for the edit button
                const editButton = document.getElementById('editDishButton');
                editButton.setAttribute('data-id', dishId);

                const dishDetailsModal = new bootstrap.Modal(document.getElementById('dishDetailsModal'));
                dishDetailsModal.show();
            })
            .catch(error => console.error('Error fetching dish details:', error));
    }

    function addRow() {
        var table = document.getElementById('ingredientTable');
        var row = table.insertRow();
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var cell5 = row.insertCell(4);

        cell1.innerHTML = `<select class="form-select category-select" name="category[]" required>
        <option value="">Select Category</option>
        <?php
        foreach ($categories as $category) {
            echo "<option value='$category'>$category</option>";
        }
        ?>
    </select>`;
        cell2.innerHTML = '<select class="form-select ingredient-select" name="ingredient[]" required><option value="">Select Ingredient</option></select>'; // Default select tag with default option
        cell3.innerHTML = '<input type="number" class="form-control" name="qty[]" placeholder="Qty" required>';
        cell4.innerHTML = '<input type="text" class="form-control" name="unit[]" placeholder="Unit" required>';
        cell5.innerHTML = '<button type="button" class="btn btn-danger" onclick="removeRow(this)">Delete</button>';

        // Add event listener for the new category select
        const newCategorySelect = row.querySelector('.category-select');
        newCategorySelect.addEventListener('change', handleCategoryChange);
    }

    function removeRow(button) {
        var row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }

    function submitForm() {
        const name = document.getElementById('name').value;
        const category = document.getElementById('category').value;
        const schedule = document.getElementById('sDate').value;
        const description = document.getElementById('description').value;

        // Ensure the image input is handled correctly
        const imgInput = document.getElementById('imgInput');
        const imgFile = imgInput.files[0]; // Get the file object
        const img = imgFile ? imgFile.name : ''; // Get the filename if file exists

        const ingredients = [];
        document.querySelectorAll('#ingredientTable tr').forEach(row => {
            const ingredientSelect = row.querySelector('.ingredient-select');
            const qtyInput = row.querySelector('input[name="qty[]"]');
            const unitInput = row.querySelector('input[name="unit[]"]');

            if (ingredientSelect && qtyInput && unitInput) {
                ingredients.push({
                    id: ingredientSelect.value,
                    qty: qtyInput.value,
                    unit: unitInput.value
                });
            }
        });

        const formData = new FormData(); // Create FormData object for file upload
        formData.append('dish', name);
        formData.append('category', category);
        formData.append('schedule', schedule);
        formData.append('description', description);
        formData.append('img', imgFile); // Append the file object directly

        // Append ingredients as JSON string (if needed by backend)
        formData.append('ingredients', JSON.stringify(ingredients));

        fetch('dishajax/insertDish.php', {
                method: 'POST',
                body: formData // Use FormData instead of JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.status === 'success') {
                    // Handle success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Dish Added',
                        text: 'The dish has been added successfully!',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.reload(); // Reload the page on success
                    });
                } else {
                    // Handle error message
                    console.error('Error adding dish:', result.message);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'There was an error adding the dish. Please try again.',
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'There was an error adding the dish. Please try again.',
                });
            });
    }

    // Initial setup for existing category selects
    const categorySelects = document.querySelectorAll('.category-select');
    categorySelects.forEach(select => {
        select.addEventListener('change', handleCategoryChange);
    });

    function handleCategoryChange() {
        const selectedCategory = this.value;
        const row = this.closest('tr');
        const ingredientSelect = row.querySelector('.ingredient-select');
        if (selectedCategory) {
            fetchIngredients(selectedCategory, ingredientSelect);
        } else {
            ingredientSelect.innerHTML = '<option value="">Select Ingredient</option>'; // Reset ingredients if no category is selected
        }
    }

    function fetchIngredients(category, ingredientSelect, selectedIngredientId = null) {
        fetch(`ajax/getingredients.php?category=${category}`)
            .then(response => response.json())
            .then(data => updateIngredientSelect(data, ingredientSelect, selectedIngredientId))
            .catch(error => console.error('Error fetching ingredients:', error));
    }

    function updateIngredientSelect(ingredients, ingredientSelect, selectedIngredientId = null) {
        ingredientSelect.innerHTML = '<option value="">Select Ingredient</option>'; // Clear previous options and add default
        ingredients.forEach(ingredient => {
            const option = document.createElement('option');
            option.value = ingredient.id;
            option.textContent = ingredient.name;
            if (selectedIngredientId && ingredient.id == selectedIngredientId) {
                option.selected = true;
            }
            ingredientSelect.appendChild(option);
        });
    }

    function fetchDishDetailsForEdit(dishId) {
        fetch(`dishajax/getDishDetails.php?id=${dishId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.error) {
                    throw new Error(data.error);
                }

                // Populate form fields with data
                document.getElementById('editDishId').value = data.id;
                document.getElementById('editName').value = data.dish;
                document.getElementById('editCategory').value = data.category;
                document.getElementById('editImg').src = 'dish-images/' + data.img;
                // Ensure correct date formatting
                const scheduleDate = new Date(data.schedule.split(' ')[0]).toISOString().split('T')[0];
                document.getElementById('editSDate').value = scheduleDate;
                document.getElementById('editDescription').value = data.description;

                // Fetch ingredients for the dish
                const editIngredientTable = document.getElementById('editIngredientTable');
                editIngredientTable.innerHTML = '';

                data.ingredients.forEach(ingredient => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                <td>
                    <select class="form-select category-select" name="editCategory[]" required>
                        <option value="">Select Category</option>
                        <!-- Populate options based on your data -->
                    </select>
                </td>
                <td>
                    <select class="form-select ingredient-select" name="editIngredient[]" required>
                        <option value="">Select Ingredient</option>
                    </select>
                </td>
                <td><input type="number" class="form-control" name="editQty[]" placeholder="Qty" value="${ingredient.qty}" required></td>
                <td><input type="text" class="form-control" name="editUnit[]" placeholder="Unit" value="${ingredient.unit}" required></td>
                <td><button type="button" class="btn btn-danger" onclick="removeEditRow(this)">Delete</button></td>
            `;
                    editIngredientTable.appendChild(row);

                    const categorySelect = row.querySelector('.category-select');
                    // Populate category options (assuming you have a predefined list of categories)
                    categorySelect.innerHTML = `<option value="${ingredient.category}">${ingredient.category}</option>`;

                    const ingredientSelect = row.querySelector('.ingredient-select');
                    // Populate ingredient options (assuming you have a predefined list of ingredients)
                    ingredientSelect.innerHTML = `<option value="${ingredient.ingredient_id}">${ingredient.name}</option>`;
                });

                // Initialize and show the modal after data is fetched
                const editMenuFormModal = new bootstrap.Modal(document.getElementById('editMenuForm'));
                editMenuFormModal.show();
            })
            .catch(error => console.error('Error fetching dish details for edit:', error));
    }

    function addEditRow() {
        var table = document.getElementById('editIngredientTable');
        var row = table.insertRow();
        row.innerHTML = `
        <td>
            <select class="form-select category-select" name="editCategory[]" required>
                <option value="">Select Category</option>
                <?php
                foreach ($categories as $category) {
                    echo "<option value='$category'>$category</option>";
                }
                ?>
            </select>
        </td>
        <td>
            <select class="form-select ingredient-select" name="editIngredient[]" required>
                <option value="">Select Ingredient</option>
            </select>
        </td>
        <td><input type="number" class="form-control" name="editQty[]" placeholder="Qty" required></td>
        <td><input type="text" class="form-control" name="editUnit[]" placeholder="Unit" required></td>
        <td><button type="button" class="btn btn-danger" onclick="removeEditRow(this)">Delete</button></td>
    `;

        const categorySelect = row.querySelector('.category-select');
        categorySelect.addEventListener('change', handleCategoryChangeForEdit);
    }

    function removeEditRow(button) {
        var row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }

    function handleCategoryChangeForEdit() {
        const selectedCategory = this.value;
        const row = this.closest('tr');
        const ingredientSelect = row.querySelector('.ingredient-select');
        if (selectedCategory) {
            fetchIngredients(selectedCategory, ingredientSelect);
        } else {
            ingredientSelect.innerHTML = '<option value="">Select Ingredient</option>';
        }
    }

    function submitEditForm() {
        const id = document.getElementById('editDishId').value;
        const name = document.getElementById('editName').value;
        const category = document.getElementById('editCategory').value;
        const schedule = document.getElementById('editSDate').value;
        const description = document.getElementById('editDescription').value;

        // Ensure the image input is handled correctly
        const imgInput = document.getElementById('editImgInput');
        const img = imgInput.files.length > 0 ? imgInput.files[0] : null;

        const ingredients = [];
        document.querySelectorAll('#editIngredientTable tr').forEach(row => {
            const ingredientSelect = row.querySelector('.ingredient-select');
            const qtyInput = row.querySelector('input[name="editQty[]"]');
            const unitInput = row.querySelector('input[name="editUnit[]"]');

            if (ingredientSelect && qtyInput && unitInput) {
                ingredients.push({
                    id: ingredientSelect.value,
                    qty: qtyInput.value,
                    unit: unitInput.value
                });
            }
        });

        // Create FormData object to send mixed data (including files)
        const formData = new FormData();
        formData.append('id', id);
        formData.append('dish', name);
        formData.append('category', category);
        formData.append('schedule', schedule);
        formData.append('description', description);
        if (img) {
            formData.append('img', img);
        }
        formData.append('ingredients', JSON.stringify(ingredients));

        fetch('dishajax/updateDish.php', {
                method: 'POST',
                body: formData // Send FormData instead of JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Dish updated successfully!'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to update dish. Please try again.'
                    });
                }
            })
            .catch(error => {
                console.error('Error updating dish:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to update dish. Please try again.'
                });
            });
    }

    function deleteDish(dishId) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success ms-1",
                cancelButton: "btn btn-danger me-1"
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`dishajax/deleteDish.php?id=${dishId}`, {
                        method: 'DELETE',
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.status === 'success') {
                            swalWithBootstrapButtons.fire({
                                title: "Deleted!",
                                text: "The dish has been deleted successfully.",
                                icon: "success",
                            }).then(() => {
                                // Reload the page or remove the deleted dish from the DOM
                                window.location.reload();
                            });
                        } else {
                            console.error('Error deleting dish:', result.message);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'There was an error deleting the dish. Please try again.',
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'There was an error deleting the dish. Please try again.',
                        });
                    });
            } else if (
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire({
                    title: "Cancelled",
                    text: "Your dish is safe :)",
                    icon: "error",
                });
            }
        });
    }
</script>

<?php include('includes/footer.php') ?>