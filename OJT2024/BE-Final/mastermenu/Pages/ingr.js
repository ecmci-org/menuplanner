// ingredient modal

var form = document.getElementById("ingForm"),
    nameInput = document.getElementById("name"),
    stockInput = document.getElementById("stock"), 
    unitInput = document.getElementById("unit"), 
    priceInput = document.getElementById("price"), 
    submitBtn = document.querySelector(".submit"),
    ingredientInfo = document.getElementById("data"),
    modal = document.getElementById("ingredientForm"),
    modalTitle = document.querySelector("#ingredientForm .modal-title"),
    newIngredientBtn = document.querySelector(".newIngredient");

let getData = localStorage.getItem('ingredientList') ? JSON.parse(localStorage.getItem('ingredientList')) : [];
let isEdit = false, editId;
showInfo();

newIngredientBtn.addEventListener('click', () => {
    submitBtn.innerText = 'Submit';
    modalTitle.innerText = "New Ingredient";
    isEdit = false;
    form.reset();
});

function showInfo() {
    ingredientInfo.innerHTML = ''; // Clear the table body before repopulating
    getData.forEach((element, index) => {
        let createElement = `<tr class="ingredientDetails">
            <td>${index + 1}</td>
            <td>${element.ingredientName}</td>
            <td>${element.ingredientStock}</td>
            <td>${element.ingredientUnit}</td>
            <td>${element.ingredientPrice}</td>
            <td>
            <button class="btn" onclick="readInfo('${element.ingredientName}', '${element.ingredientStock}', '${element.ingredientUnit}', '${element.ingredientPrice}')" data-bs-toggle="modal" data-bs-target="#readData"><i class="bi bi-eye"></i></button>
            <button class="btn" onclick="editInfo(${index}, '${element.ingredientName}', '${element.ingredientStock}', '${element.ingredientUnit}', '${element.ingredientPrice}')" data-bs-toggle="modal" data-bs-target="#ingredientForm"><i class="bi bi-pencil-square"></i></button>
            <button class="btn" onclick="deleteInfo(${index})"><i class="bi bi-trash"></i></button>
            </td>
        </tr>`;

        ingredientInfo.innerHTML += createElement;
    });
}

function readInfo(name, stock, unit, price) {
    document.querySelector('#showName').value = name;
    document.querySelector("#showStock").value = stock;
    document.querySelector("#showUnit").value = unit;
    document.querySelector("#showsPrice").value = price;
}

function editInfo(index, name, stock, unit, price) {
    isEdit = true;
    editId = index;
    nameInput.value = name;
    stockInput.value = stock;
    unitInput.value = unit;
    priceInput.value = price;
    submitBtn.innerText = 'Update';
    modalTitle.innerText = "Update Ingredient";
}

function deleteInfo(index) {
    getData.splice(index, 1);
    localStorage.setItem('ingredientList', JSON.stringify(getData));
    showInfo();
}

form.addEventListener('submit', function(e) {
    e.preventDefault();
    let ingredientObj = {
        ingredientName: nameInput.value,
        ingredientStock: stockInput.value, // Changed category to stockInput
        ingredientUnit: unitInput.value,
        ingredientPrice: priceInput.value
    };

    if (isEdit) {
        getData[editId] = ingredientObj;
        isEdit = false;
    } else {
        getData.push(ingredientObj);
    }

    localStorage.setItem('ingredientList', JSON.stringify(getData));
    form.reset();
    showInfo();
    modal.querySelector('.btn-close').click();
});
