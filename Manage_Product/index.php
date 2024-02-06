<?php
// database connection file
include "db_connect.php";


if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Function to Check if the 'imageData' query parameter is set
if (isset($_GET['imageData'])) {
  $imageData = base64_decode(urldecode($_GET['imageData']));
}

// Function to Check if the delete button is clicked
if (isset($_GET['delete'])) {
    $productIdToDelete = $_GET['delete'];
  
    // Delete the record from the database
    $sqlDelete = "DELETE FROM products WHERE product_id = '$productIdToDelete'";
    $resultDelete = mysqli_query($conn, $sqlDelete);
  
    if ($resultDelete) {
      // Query successful, update the total product count in the session
      session_start();
      $sqlCountProduct = "SELECT COUNT(*) AS total_products FROM products";
      $resultCountProduct = mysqli_query($conn, $sqlCountProduct);
      $data = mysqli_fetch_assoc($resultCountProduct);
      $_SESSION['total_products'] = $data['total_products'];
    }
  }
  
  // Fetch all items from the 'product' table
  $sql = "SELECT * FROM products";
  $result = mysqli_query($conn, $sql);

  
  // Function to get the button class based on the status
  function getButtonClass($status) {
    return ($status === 'Active') ? 'active' : 'inactive';
  }
  
  // Get the total number of warehouse
  $totalProducts = mysqli_num_rows($result);
  
  
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  
  // Store the total products count in the session variable
  $_SESSION['total_products'] = $totalProducts;

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products</title>
  <link rel="stylesheet" href="style.css">

  <script>
  function deleteproduct(productId) {
    if (confirm('Are you sure you want to delete this Product?')) {
      // Redirect back to the product page after deleting
      window.location.href = 'http://localhost/Kumara%20Stores%20Inventory_system/Manage_Product/?delete=' + productId;
    }
  }
</script>


</head>
<body>
<div class="header">
    <div class="rectangle"></div>
</div>
<div class="content">
  <!-- "Manage Products" and "Home > Products" texts -->
  <div class="texts">
    <div class="manage-products-text">Manage Products</div>
    <div class="breadcrumb-text">Home &gt; Products</div>
  </div>
  <div>
  <!-- Add product Button -->
  <a href="http://localhost/Kumara%20Stores%20Inventory_system/Add_Product/">
  <button class="add-product-button">
    <span class="button-text">Add Product</span>
  </button>
  </a>
<div>
  <!-- Print Button -->
  <button class="print-button" onclick="printTable()">
    <span class="button-text">Print</span>
  </button>
</div>
  <!-- Search text box -->
  <div class="search-box">
  <input type="text" id="productSearchInput" placeholder="Search Product">
</div>

<script>
  function searchProduct() {
    
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("productSearchInput");
    filter = input.value.toUpperCase();
    table = document.querySelector(".product-table");
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows and hide those that do not match the search query
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[1]; 
      if (td) {
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }
    }
  }

  // Attach the searchProduct function to the "input" event of the search input
  document.getElementById("productSearchInput").addEventListener("input", searchProduct);
</script>


<!-- Table -->
<table class="product-table" style="transform: translateY(40px);">
  <thead>
    <tr>
      <th style="width: 10%;">Image</th>
      <th style="width: 30%;">Product</th>
      <th style="width: 10%;">Element</th>
      <th style="width: 10%;">Price</th>
      <th style="width: 10%;">Quantity</th>
      <th style="width: 10%;">Warehouse</th>
      <th class="availability-column" style="width: 10%;">Availability</th>
      <th style="width: 20%;">Action</th>
    </tr>
  </thead>
  <tbody>

  <?php
while ($row = mysqli_fetch_assoc($result)) {
    $productId = $row['product_id'];
    $imageData = base64_encode($row['image']);
    $productName = $row['product_name'];
    $elementValue = $row['element_value'];
    $price = $row['price'];
    $quantity = $row['quantity'];
    $warehouse = $row['warehouse'];
    $status = $row['availability'];

    // Determine the button class based on the status value
  $buttonClass = ($status === 'active') ? 'active' : 'inactive';
  $buttonText = ucfirst($status); 

  // Function to Check if quantity is less than 10 and add "Low" message
  $quantityClass = ($quantity < 10) ? 'low-quantity' : '';

  // Output the table row
  echo '<tr>';
  echo '<td>';
  echo '<div class="image-circle">';
  echo '<img src="data:image/jpeg;base64,' . $imageData . '" alt="Product Image">';
  echo '</div>';
  echo '</td>';
  echo '<td>';
if ($quantity < 10) {
  // If quantity is less than 10, display both the product name and "Low" in red
  echo '<span class="low-quantity" style="color: red;">' . $productName . ' (Low)</span>';
} else {
  // If quantity is 10 or more, display only the product name without the "Low" text
  echo $productName;
}
echo '</td>';
  echo '<td>' . $elementValue . '</td>';
  echo '<td>' . $price . '</td>';
  echo '<td>' . $quantity . '</td>';
  echo '<td>' . $warehouse . '</td>';
  echo '<td class="availability-column">';
  echo '<input type="button" class="status-button ' . $buttonClass . '" value="' . ucfirst($status) . '" disabled>';
  echo '</div>';
  echo '</td>';
  echo '<td>';
  echo '<a href="http://localhost/Kumara%20Stores%20Inventory_system/Add_Product/?edit=' . $productId . '">';
  echo '<button class="edit-button">';
  echo '<img class="button-icon" src="https://www.freeiconspng.com/thumbs/edit-icon-png/edit-editor-pen-pencil-write-icon--4.png" alt="Edit">';
  echo '</button>';
  echo '</a>';
  echo '<button class="delete-button" onclick="deleteproduct(' . $productId . ')">';
  echo '<img class="button-icon" src="https://icons.veryicon.com/png/o/transport/shopping-mall/delete-127.png" alt="Delete">';
  echo '</button>';
  echo '</td>';
  echo '</tr>';
}
    ?>
    <?php  ?>
  </tbody>
</table>


<script>
  function toggleAvailability(button) {
    if (button.classList.contains('active')) {
      button.classList.remove('active');
      button.classList.add('inactive');
      button.innerText = 'Inactive';
    } else {
      button.classList.remove('inactive');
      button.classList.add('active');
      button.innerText = 'Active';
    }
  }
</script>



<!-- Side Bar -->
<div class="sidebar" style="transform: translateY(98px);" >
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