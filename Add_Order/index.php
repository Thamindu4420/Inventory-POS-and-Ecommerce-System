<?php
include "db_connect.php";

// Function to Check if the connection is successful
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}




// Fetch element values from the database
$query = "SELECT elements_value FROM element_value";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error fetching element values: " . mysqli_error($conn));
}

$elementValues = array();
while ($row = mysqli_fetch_assoc($result)) {
    $elementValues[] = $row['elements_value'];
}

// Encode element values as JSON
$elementValuesJSON = json_encode($elementValues);


?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Orders</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="print.css" media="print">
</head>

<body>
<div class="header">
    <div class="rectangle"></div>
</div>
<div class="content">

  <!-- "Add New Order" and "Home > Orders" texts -->
  <div class="texts">
    <div class="add-new-order-text">Add New Order</div>
    <div class="breadcrumb-text">Home &gt; Orders</div>
  </div>

  <div hr class="heading-line">
  </div>

  <?php
include "db_connect.php";

// Check if the connection is successful
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Initialize variables for form fields
$client = ""; 
$contact = ""; 
$netAmount = ""; 
$paymentStatus = ""; 

// Function to Check if the "edit" parameter is present in the URL
if (isset($_GET["edit"])) {
  $editOrderId = $_GET["edit"];
  
  // Fetch data for the selected order from the database
  $sql = "SELECT * FROM orders WHERE order_id = $editOrderId";
  $result = mysqli_query($conn, $sql);
  
  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    
    // Set the variables to the values from the selected row
    $client = $row["client"];
    $contact = $row["contact"];
    $netAmount = $row["net_amount"];
    $paymentStatus = $row["payment_status"];
  } else {
    echo "Order not found.";
  }
}

// Close the database connection
mysqli_close($conn);
?>

<!-- Add Order Form -->
<form class="add-order-form" method="post" action="save_order.php">

      
<div class="client-name">
        <label for="client-name">Client Name</label>
        <input type="text" id="client-name" name="clientName" placeholder="Enter Client Name" value="<?php echo $client; ?>">
      </div>

<div class="client-phone">
        <label for="client-phone">Client Phone</label>
        <input type="text" id="client-phone" name="clientPhone" placeholder="Enter Client Phone Number" value="<?php echo $contact; ?>">
      </div>

<div class="form-row">

<div class="product-dropdown">
    <label for="product-search">Product</label>
    <input type="text" id="product-search" placeholder="Search for a product">
    <select id="product-select" name="product">
      
    </select>
  </div>

      <div class="element-dropdown">
    <label for="element-select">Element</label>
    <select id="element-select" name="element">
     
    </select>
  </div>

    <div class="quantity">
        <label for="quantity">Quantity</label>
        <input type="text" id="quantity" name="Quantity" placeholder="Enter Quantity" oninput="checkQuantity()">
    </div>

    <div class="rate">
        <label for="rate">Rate</label>
        <input type="text" id="rate" name="Rate" placeholder="Rate" readonly>
    </div>

    <div class="amount">
        <label for="amount">Amount</label>
        <input type="text" id="amount" name="Amount" placeholder="Amount">
    </div>
</div>



<div button type="button" class="add-button">ADD</button>
</div>


<div class="order-table">
    <table>
        <thead>
            <tr>
                <th style="width: 30%;">Product</th>
                <th style="width: 20%;">Element</th>
                <th style="width: 10%;">Quantity</th>
                <th style="width: 10%;">Rate</th>
                <th style="width: 20%;">Amount</th>
                <th style="width: 10%;">Action</th>
            </tr>
        </thead>
        <tbody id="order-table-body">
            
        </tbody>
    </table>
</div>

<div class="gross-amount">
    <label for="gross-amount">Gross Amount</label>
    <input type="text" id="gross-amount" name="grossAmount" placeholder="Enter Gross Amount">
</div>

<div class="discount">
    <label for="discount">Discount</label>
    <input type="text" id="discount" name="discount" placeholder="Enter Discount">
</div>

<div class="net-amount">
    <label for="net-amount">Net Amount</label>
    <input type="text" id="net-amount" name="netAmount" placeholder="Enter Net Amount"value="<?php echo $netAmount; ?>">
</div>

<div class="form-row">
        <div class="payment-status-dropdown">
            <label for="payment-status-select">Payment Status</label>
            <select id="payment-status-select" name="paymentStatus">
                <option value="Paid" <?php if ($paymentStatus === "Paid") echo "selected"; ?>>Paid</option>
                <option value="UnPaid" <?php if ($paymentStatus === "UnPaid") echo "selected"; ?>>Unpaid</option>
            </select>
        </div>
    </div>

<div class="button-container">
    <button class="create-order-button" type="submit">Create Order</button>
    <button class="print-button" onclick="printAddOrder()">Print</button>
    

    <a href="http://localhost/Kumara%20Stores%20Inventory_system/Manage_Order/">
    <button type="button" class="back-button">Back</button>
    </a>
</div>

</form>
</div>

<!-- JavaScript to populate the product dropdown -->
<script>
   document.addEventListener("DOMContentLoaded", function () {
    var productSelect = document.getElementById("product-select");
    var productSearch = document.getElementById("product-search");

    // Function to populate the product dropdown from the fetched product names
    function populateProductDropdown(productNames) {
      productSelect.innerHTML = ""; // Clear existing options

      productNames.forEach(function (productName) {
        var option = document.createElement("option");
        option.value = productName;
        option.text = productName;
        productSelect.appendChild(option);
      });
    }

    // Function to fetch product names from the database
    function fetchProductNames() {
      var xhr = new XMLHttpRequest();
      xhr.open("GET", "get_product_names.php", true); // Replace with the actual URL of your PHP script
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
          var productNames = JSON.parse(xhr.responseText);
          populateProductDropdown(productNames);
        }
      };
      xhr.send();
    }

    // Call the function to fetch product names and populate the dropdown
    fetchProductNames();

    // Add an event listener to the search input
    productSearch.addEventListener("input", function () {
      var filter = productSearch.value.toLowerCase();
      var options = productSelect.options;

      for (var i = 0; i < options.length; i++) {
        var option = options[i];
        var text = option.text.toLowerCase();
        if (text.includes(filter)) {
          option.style.display = "";
        } else {
          option.style.display = "none";
        }
      }
    });
  });


  document.addEventListener("DOMContentLoaded", function() {
  var elementValues = <?php echo $elementValuesJSON; ?>;
  
  // Function to create the dynamic element dropdown
  function populateElementDropdown() {
    var elementSelect = document.getElementById("element-select");

    // Clear existing options
    elementSelect.innerHTML = "";

    // Populate the element dropdown with options
    elementValues.forEach(function (elementValue) {
        var option = document.createElement("option");
        option.value = elementValue;
        option.text = elementValue; // Set the text of the option
        elementSelect.appendChild(option);
      });
    }
      
  // Call the function to populate the element dropdown
  populateElementDropdown();  
});





  // Check if the "edit" parameter is present in the URL
  const urlParams = new URLSearchParams(window.location.search);
  const editOrderId = urlParams.get("edit");

  if (editOrderId) {
    // Send an AJAX request to fetch the order data
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "get_order_data.php?edit=" + editOrderId, true);
    xhr.setRequestHeader("Content-type", "application/json");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var orderData = JSON.parse(xhr.responseText);

        // Populate the form fields with the retrieved data
        document.getElementById("client-name").value = orderData.client;
        document.getElementById("client-phone").value = orderData.contact;
        document.getElementById("net-amount").value = orderData.net_amount;
        document.getElementById("payment-status-select").value = orderData.payment_status;
      }
    };
    xhr.send();
  }




// Function to calculate and update the gross amount
function calculateGrossAmount() {
    var amountInputs = document.querySelectorAll("#order-table-body tr td:nth-child(5)");
    var grossAmountInput = document.getElementById("gross-amount");

    var totalAmount = 0;

    // Loop through all the amount inputs in the order table
    amountInputs.forEach(function (amountInput) {
        var amountText = amountInput.textContent;
        var amount = parseFloat(amountText.replace("Rs. ", ""));

        // Check if the amount is a valid number
        if (!isNaN(amount)) {
            totalAmount += amount;
        }
    });

    // Update the gross amount input field
    grossAmountInput.value = 'Rs. ' + totalAmount.toFixed(2);
    
}



// Function to Add Order

function addOrder() {
    var productName = document.getElementById("product-select").value;
    var elementName = document.getElementById("element-select").value;
    var quantity = document.getElementById("quantity").value;
    var rate = document.getElementById("rate").value;
    var amount = document.getElementById("amount").value;

    // Get a reference to the order table body
    var tableBody = document.getElementById("order-table-body");

    // Create a new row
    var newRow = tableBody.insertRow();

    // Insert cells for product, element, quantity, rate, amount, and action
    var productCell = newRow.insertCell(0);
    var elementCell = newRow.insertCell(1);
    var quantityCell = newRow.insertCell(2);
    var rateCell = newRow.insertCell(3);
    var amountCell = newRow.insertCell(4);
    var actionCell = newRow.insertCell(5);

    // Set the cell values
    productCell.innerHTML = productName;
    elementCell.innerHTML = elementName;
    quantityCell.innerHTML = quantity;
    rateCell.innerHTML = rate;
    amountCell.innerHTML = amount;
    actionCell.innerHTML = '<button type="button" onclick="removeOrder(this)">Remove</button>';

    // Clear the input fields
    document.getElementById("product-select").value = "";
    document.getElementById("element-select").value = "";
    document.getElementById("quantity").value = "";
    document.getElementById("rate").value = "";
    document.getElementById("amount").value = "";

     // After adding the order, calculate the gross amount
 calculateGrossAmount();

     // Update the product quantity in the database
    updateProductQuantity(productName, quantity);

    return false; // Prevent form submission
}


function removeOrder(button) {
    var row = button.parentNode.parentNode;
    var productName = row.cells[0].textContent;
    var quantity = parseFloat(row.cells[2].textContent);

    // Remove the row from the table
    row.parentNode.removeChild(row);

    // After removing the order, update the product quantity in the database
    updateProductQuantity(productName, -quantity);
}

// Add an event listener to the "ADD" button
document.querySelector(".add-button").addEventListener("click", function () {
    addOrder();
});

  

  // Add an event listener to the product dropdown
  document.getElementById("product-select").addEventListener("change", function () {
    var selectedProduct = this.value;
    var rateInput = document.getElementById("rate");

    // Check if a product is selected
    if (selectedProduct !== "") {
        // Send an AJAX request to get the price
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "get_product_price.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.price !== 'Not found') {
                    rateInput.value = response.price;
                } else {
                    rateInput.value = 'Price not found';
                }
            }
        };
        xhr.send("product=" + selectedProduct);
    } else {
        rateInput.value = "";
    }
  });




// Function to calculate and update the amount field
function calculateAmount() {
  var productSelect = document.getElementById("product-select");
  var quantityInput = document.getElementById("quantity");
  var rateInput = document.getElementById("rate");
  var amountInput = document.getElementById("amount");

  var selectedProduct = productSelect.value;
  var quantity = parseFloat(quantityInput.value); // Use parseFloat to parse quantity

  // Check if a product is selected and quantity is a valid number
  if (selectedProduct !== "" && !isNaN(quantity) && quantity >= 0) {
    // Send an AJAX request to get the price for the selected product
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "get_product_price.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);
        if (response.price !== 'Not found') {
          var price = parseFloat(response.price); 
          var amount = price * quantity;
          rateInput.value = 'Rs. ' + price.toFixed(2); 
          amountInput.value = 'Rs. ' + amount.toFixed(2); 
        } else {
          rateInput.value = 'Price not found';
          amountInput.value = '';
        }
      }
    };
    xhr.send("product=" + selectedProduct);
  } else {
    rateInput.value = "";
    amountInput.value = "";
  }
}

// Add event listeners to the product dropdown and quantity input
document.getElementById("product-select").addEventListener("change", calculateAmount);
document.getElementById("quantity").addEventListener("input", calculateAmount);



// Function to check and update quantity color
function checkQuantity() {
    var productSelect = document.getElementById("product-select");
    var quantityInput = document.getElementById("quantity");
    
    var selectedProduct = productSelect.value;
    var enteredQuantity = parseFloat(quantityInput.value);

    // Function to Check if a product is selected and quantity is a valid number
    if (selectedProduct !== "" && !isNaN(enteredQuantity) && enteredQuantity >= 0) {
        // Send an AJAX request to get the available quantity for the selected product
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "get_product_quantity.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.quantity !== 'Not found') {
                    var availableQuantity = parseFloat(response.quantity);

                    // Check if entered quantity exceeds available quantity
                    if (enteredQuantity > availableQuantity) {
                        quantityInput.style.color = 'red'; 
                    } else {
                        quantityInput.style.color = 'black'; 
                    }
                } else {
                    quantityInput.style.color = 'black'; 
                }
            }
        };
        xhr.send("product=" + selectedProduct);
    } else {
        quantityInput.style.color = 'black'; 
    }
}


// Add event listener to the discount input field
document.getElementById("discount").addEventListener("input", function () {
    calculateNetAmount();
});

// Function to calculate and update the net amount
function calculateNetAmount() {
    var grossAmountInput = document.getElementById("gross-amount");
    var discountInput = document.getElementById("discount");
    var netAmountInput = document.getElementById("net-amount");

    var grossAmountText = grossAmountInput.value;
    var discountText = discountInput.value;

    // Remove the "Rs. " part and convert to numbers
    var grossAmount = parseFloat(grossAmountText.replace("Rs. ", ""));
    var discount = parseFloat(discountText.replace("Rs. ", ""));

    // Check if the values are valid numbers
    if (!isNaN(grossAmount) && !isNaN(discount)) {
        var netAmount = grossAmount - discount;

        // Update the net amount input field
        netAmountInput.value = 'Rs. ' + netAmount.toFixed(2);
    } else {
        // Handle invalid input
        netAmountInput.value = 'Invalid input';
    }
}



// JavaScript function to print the Add Order page
function printAddOrder() {
  // Get the elements you want to print
  const clientName = document.getElementById("client-name").value;
  const clientPhone = document.getElementById("client-phone").value;
  const orderTable = document.querySelector(".order-table");
  const grossAmount = document.getElementById("gross-amount").value;
  const discount = document.getElementById("discount").value;
  const netAmount = document.getElementById("net-amount").value;
  const paymentStatus = document.getElementById("payment-status-select").value;
  
  // Remove the "Action" column from the order table
  const orderTableClone = orderTable.cloneNode(true);
  orderTableClone.querySelector("thead th:last-child").remove(); 
  const rows = orderTableClone.querySelectorAll("tbody tr");
  rows.forEach(row => {
    row.querySelector("td:last-child").remove(); 
  });

  // Create a new window for printing and write the HTML content
  const printWindow = window.open('', '_blank');
  let content = '<html><head><title>Print Add Order</title>';
  content += '<style>';
  content += 'body { font-family: "Segoe UI", sans-serif; }';
  content += 'h1 { text-align: center; }';
  content += 'img.logo { display: block; margin-left: 50px; width: 50px; height: 50px; float: left; }';
  content += '.store-text { display: block; margin-left: 70px; }';
  content += '.container { padding: 20px; }';
  content += '.thank-you { text-align: center; font-weight: bold; margin-top: 20px; }';
  content += '</style>';
  content += '</head><body>';
  content += '<h1><img class="logo" src="https://i.ibb.co/jrp6hSp/Screenshot-1183.png" alt="Kumara Stores Logo"><span class="store-text">Kumara Stores</span></h1>';
  content += `<p><strong>Client Name:</strong> ${clientName}</p>`;
  content += `<p><strong>Client Phone:</strong> ${clientPhone}</p>`;
  content += '<h2>Order Details</h2>';
  content += orderTableClone.outerHTML; 
  content += `<p><strong>Gross Amount:</strong> ${grossAmount}</p>`;
  content += `<p><strong>Discount:</strong> ${discount}</p>`;
  content += `<p><strong>Net Amount:</strong> ${netAmount}</p>`;
  content += `<p><strong>Payment Status:</strong> ${paymentStatus}</p>`;
  content += '<p class="thank-you">Thank You, Come Again</p>';
  content += '</body></html>';

  // Write the content to the new window and initiate the printing process
  printWindow.document.write(content);
  printWindow.document.close();
  printWindow.print();
}





// Function to update product quantity in the database via AJAX
function updateProductQuantity(productName, quantity) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "update_quantity.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = xhr.responseText;
            console.log(response); // Log the response for debugging
        }
    };
    xhr.send("product_name=" + encodeURIComponent(productName) + "&quantity=" + quantity);
}


</script>






<!-- Side Bar -->
<div class="sidebar" style="transform: translateY(98px);">
  <ul class="menu">
    <li><img src="https://icon-library.com/images/meter-icon/meter-icon-1.jpg" alt="Dashboard"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Dashboard/">Dashboard</a></li>
    <li><img src="https://www.nicepng.com/png/full/204-2049036_download-3-cube-icon.png" alt="Items"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Items/index.php">Items</a></li>
    <li><img src="https://www.nicepng.com/png/full/204-2049036_download-3-cube-icon.png" alt="Category"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Category/">Category</a></li>
    <li><img src="https://toppng.com/uploads/preview/open-warehouse-icon-font-awesome-11563302767pao8zak6mz.png" alt="Warehouse"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Warehouse/">Warehouse</a></li>
    <li><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT5afpx3wsQgzXLHss8vgGV55nP5_B6fdhK6w&usqp=CAU" alt="Elements"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Elements/">Elements</a></li>
    <li class="submenu">
      <img src="https://www.svgrepo.com/show/57782/closed-box.svg" alt="Products"><a href="#">Products</a>
      <span class="dropdown-icon">&#9660;</span>
      <ul class="sub-menu">
        <li><span class="icon"><img src="https://cdn-icons-png.flaticon.com/512/7613/7613915.png" alt="Add Products"></span><a href="http://localhost/Kumara%20Stores%20Inventory_system/Add_Product/">Add Products</a></li>
        <li><span class="icon"><img src="https://cdn-icons-png.flaticon.com/512/7613/7613915.png" alt="Manage Products"></span><a href="http://localhost/Kumara%20Stores%20Inventory_system/Manage_Product/">Manage Products</a></li>
      </ul>
    </li>
    <li class="submenu">
      <img src="https://cdn3.iconfinder.com/data/icons/pyconic-icons-3-1/512/dollar-512.png" alt="Orders"><a href="#">Orders</a>
      <span class="dropdown-icon">&#9660;</span>
      <ul class="sub-menu">
        <li><span class="icon"><img src="https://cdn-icons-png.flaticon.com/512/7613/7613915.png" alt="Add Orders"></span><a href="http://localhost/Kumara%20Stores%20Inventory_system/Add_Order/">Add Order</a></li>
        <li><span class="icon"><img src="https://cdn-icons-png.flaticon.com/512/7613/7613915.png" alt="Manage Orders"></span><a href="http://localhost/Kumara%20Stores%20Inventory_system/Manage_Order/">Manage Orders</a></li>
      </ul>
    </li>
    <li class="submenu">
      <img src="https://cdn-icons-png.flaticon.com/512/2118/2118701.png" alt="Members"><a href="#">Members</a>
      <span class="dropdown-icon">&#9660;</span>
      <ul class="sub-menu">
        <li><span class="icon"><img src="https://cdn-icons-png.flaticon.com/512/7613/7613915.png" alt="Add Members"></span><a href="http://localhost/Kumara%20Stores%20Inventory_system/Add_Member/">Add Members</a></li>
        <li><span class="icon"><img src="https://cdn-icons-png.flaticon.com/512/7613/7613915.png" alt="Manage Members"></span><a href="http://localhost/Kumara%20Stores%20Inventory_system/Manage_Member/">Manage Members</a></li>
      </ul>
    </li>
    <li class="submenu">
      <img src="https://www.freeiconspng.com/thumbs/recycle-icon-png/black-recycle-icon-png-2.png" alt="Suppliers"><a href="#">Suppliers</a>
      <span class="dropdown-icon">&#9660;</span>
      <ul class="sub-menu">
        <li><span class="icon"><img src="https://cdn-icons-png.flaticon.com/512/7613/7613915.png" alt="Add Supplier"></span><a href="http://localhost/Kumara%20Stores%20Inventory_system/Add_Supplier/">Add Supplier</a></li>
        <li><span class="icon"><img src="https://cdn-icons-png.flaticon.com/512/7613/7613915.png" alt="Manage Suppliers"></span><a href="http://localhost/Kumara%20Stores%20Inventory_system/Manage_Supplier/">Manage Suppliers</a></li>
      </ul>
    </li>
    <li><img src="https://www.iconpacks.net/icons/1/free-building-icon-1062-thumb.png" alt="Invoice"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Invoice/">Invoice</a></li>
    <div>
    <li><img src="https://banner2.cleanpng.com/20180508/uyw/kisspng-power-symbol-computer-icons-5af247e6b7df19.0515539515258275587532.jpg" alt="Logout"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Login/">Logout</a></li>
  </div>
  </ul>
</div>

<!--Kumara Stores Logo-->
<div class="logo">
      <img src="https://i.ibb.co/jrp6hSp/Screenshot-1183.png" alt="Logo">
    </div>
    </div> 
    <script src="script.js"></script>
</div>


<script>
    // Disable zooming on the page
    function disableZoom() {
      document.addEventListener('keydown', function (event) {
        if (event.ctrlKey === true || event.metaKey) {
          event.preventDefault();
        }
      }, false);

      window.addEventListener('wheel', function (event) {
        if (event.ctrlKey === true || event.metaKey) {
          event.preventDefault();
        }
      }, { passive: false });

      document.addEventListener('gesturestart', function (e) {
        e.preventDefault();
      });
    }

    //function to disable zooming
    disableZoom();
  </script>

</body>
</html>

  


