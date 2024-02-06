<?php

include "db_connect.php";

// Function to Check if the connection is successful
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Function to Check if the 'edit' query parameter is present in the URL
if (isset($_GET["edit"])) {
  $editSupplierId = mysqli_real_escape_string($conn, $_GET["edit"]);

  // Fetch the supplier data based on the editSupplierId
  $editSql = "SELECT * FROM suppliers WHERE supplier_id = '$editSupplierId'";
  $editResult = mysqli_query($conn, $editSql);

  if ($editResult && mysqli_num_rows($editResult) > 0) {
      // Fetch the supplier data
      $supplierData = mysqli_fetch_assoc($editResult);
  }
}


if (isset($_POST["save"])) {
  // Get data from the form
  $company = mysqli_real_escape_string($conn, $_POST["company"]);
  $supplierName = mysqli_real_escape_string($conn, $_POST["supplier-name"]);
  $contactNumber = mysqli_real_escape_string($conn, $_POST["contact-number"]);
  $supplyDate = mysqli_real_escape_string($conn, $_POST["supply-date"]);
  $quantity = mysqli_real_escape_string($conn, $_POST["quantity"]);
  $amount = mysqli_real_escape_string($conn, $_POST["amount"]);
  $paymentStatus = mysqli_real_escape_string($conn, $_POST["payment-status"]);

  if (isset($_POST["supplier_id"])) {
      
      $supplierId = mysqli_real_escape_string($conn, $_POST["supplier_id"]);

      $updateSql = "UPDATE suppliers SET 
                    company = '$company',
                    supplier_name = '$supplierName',
                    contact_number = '$contactNumber',
                    supply_date = '$supplyDate',
                    quantity = '$quantity',
                    amount = '$amount',
                    payment_status = '$paymentStatus'
                    WHERE supplier_id = '$supplierId'";

      if (mysqli_query($conn, $updateSql)) {
      } else {
          // Update failed
          echo "Error updating supplier: " . mysqli_error($conn);
      }
  } else {
      
      $insertSql = "INSERT INTO suppliers (company, supplier_name, contact_number, supply_date, quantity, amount, payment_status) 
                  VALUES ('$company', '$supplierName', '$contactNumber', '$supplyDate', '$quantity', '$amount', '$paymentStatus')";

      if (mysqli_query($conn, $insertSql)) {
      } else {
          // Insert failed
          echo "Error adding supplier: " . mysqli_error($conn);
      }
  }
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Suppliers</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
<div class="header">
    <div class="rectangle"></div>
</div>
<div class="content">

  <!-- "Add Supplier" and "Home > Supplier" texts -->
  <div class="texts">
    <div class="add-supplier-text">Add Supplier</div>
    <div class="breadcrumb-text">Home &gt; Supplier</div>
  </div>

  <div hr class="heading-line">
  </div>


<!-- Add User Permission Form -->

<form class="add-supplier-form"  method="POST" action="index.php">


<div class="company">
    <label for="company">Company</label>
    <input type="text" id="company" name="company" placeholder="Enter Company Name" value="<?php echo isset($supplierData['company']) ? $supplierData['company'] : ''; ?>">
</div>

      <div class="supplier-name">
        <label for="supplier-name">Supplier Name</label>
        <input type="text" id="supplier-name" name="supplier-name" placeholder="Enter Supplier Name" value="<?php echo isset($supplierData['supplier_name']) ? $supplierData['supplier_name'] : ''; ?>">
      </div>

      <div class="contact-number">
        <label for="contact-number">Contact Number</label>
        <input type="text" id="contact-number" name="contact-number" placeholder="Enter Contact Number" value="<?php echo isset($supplierData['contact_number']) ? $supplierData['contact_number'] : ''; ?>">
      </div>

      <div class="supply-date">
        <label for="supply-date">Supply Date</label>
        <input type="text" id="supply-date" name="supply-date" placeholder="Enter Supply Date" value="<?php echo isset($supplierData['supply_date']) ? $supplierData['supply_date'] : ''; ?>">
      </div>

      <div class="quantity">
        <label for="quantity">Quantity</label>
        <input type="text" id="quantity" name="quantity" placeholder="Enter Total Product Quantity Purchased" value="<?php echo isset($supplierData['quantity']) ? $supplierData['quantity'] : ''; ?>">
      </div>

      <div class="amount">
        <label for="amount">Amount</label>
        <input type="text" id="amount" name="amount" placeholder="Enter Amount Paid for the Supplier" value="<?php echo isset($supplierData['amount']) ? $supplierData['amount'] : ''; ?>">
      </div>

      <div class="payment-status-dropdown">
        <label for="payment-status-select">Payment Status</label>
        <select id="payment-status-select" name="payment-status" value="<?php echo isset($supplierData['payment_status']) ? $supplierData['payment_status'] : ''; ?>">
        <option value="Paid">Paid</option>
        <option value="Unpaid">Unpaid</option>
        </select>
      </div>


      <div class="form-buttons">
      <button type="submit" class="save-button" name="save">Save</button>

      <a href="http://localhost/Kumara%20Stores%20Inventory_system/Manage_Supplier/">
    <button type="button" class="back-button" >Back
      </button>
  </a>
   
  </form>
</div>







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

    // function to disable zooming
    disableZoom();
  </script>

</body>
</html>
