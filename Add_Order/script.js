// JavaScript function to add a new row
function addRow() {
    var table = document.querySelector('.order-table table tbody');
    var newRow = table.insertRow(table.rows.length);

    var productCell = newRow.insertCell(0);
    var quantityCell = newRow.insertCell(1);
    var rateCell = newRow.insertCell(2);
    var amountCell = newRow.insertCell(3);
    var actionCell = newRow.insertCell(4);

    productCell.innerHTML = `
        <div class="product-dropdown">
            <select>
                <option value="product1">Product 1</option>
                <option value="product2">Product 2</option>
                <option value="product3">Product 3</option>
            </select>
        </div>
    `;
    quantityCell.innerHTML = '<input type="text" name="quantity">';
    rateCell.innerHTML = '<input type="text" name="rate">';
    amountCell.innerHTML = '<input type="text" name="amount">';
    actionCell.innerHTML = '<button class="delete-button" onclick="deleteRow(this)">X</button>';
}

// JavaScript function to delete a row
function deleteRow(button) {
    var row = button.parentNode.parentNode;
    row.parentNode.removeChild(row);
}




  