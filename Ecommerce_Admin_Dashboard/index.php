<?php
include "db_connect.php";

// Function to Check if the connection is successful
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}



// Query to fetch the total number of USERS
$sql = "SELECT COUNT(*) as total_users FROM users";

$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $totalUsers = $row['total_users'];
} else {
    // Handle the query error if needed
    $totalUsers = 0;
}



// Query to fetch the total number of CATEGORY
$sql = "SELECT COUNT(*) as total_category FROM category";

$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $totalCategory = $row['total_category'];
} else {
    // Handle the query error if needed
    $totalCategory = 0;
}



// Query to fetch the total number of PRODUCTS
$sql = "SELECT COUNT(*) as total_products FROM products";

$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $totalProducts = $row['total_products'];
} else {
    // Handle the query error if needed
    $totalProducts = 0;
}



// Query to fetch the total number of CUSTOMERS
$sql = "SELECT COUNT(*) as total_customers FROM customers";

$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $totalCustomers = $row['total_customers'];
} else {
    // Handle the query error if needed
    $totalCustomers = 0;
}




// Query to fetch the total number of ITEMS
$sql = "SELECT COUNT(*) as total_items FROM items";

$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $totalItems = $row['total_items'];
} else {
    // Handle the query error if needed
    $totalItems = 0;
}



// Query to fetch the total number of orders
$sql = "SELECT COUNT(DISTINCT CONCAT(name, sub_total)) as total_orders FROM customer_orders";

$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $totalOrders = $row['total_orders'];
} else {
    // Handle the query error if needed
    $totalOrders = 0;
}


// Query to fetch the total income
$sql = "SELECT SUM(sub_total) as total_income FROM (SELECT DISTINCT name, sub_total FROM customer_orders) AS unique_orders";

$result = mysqli_query($conn, $sql);

// Initialize the total income variable
$totalIncome = 0;

// Check if the query was successful
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $totalIncome = $row['total_income'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ecommerce Admin Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="header">
    <div class="rectangle"></div>
    <div class="admin-panel-text">E-Commerce Admin Panel</div>
  </div>
    </div>
    <div class="texts">  
      <div class="dashboard-subtitle">Home&gt;Dashboard
    </div>
  </div>
</div>
<div hr class="heading-line">
  </div>
<div>
  <div class="sidebar">
    <ul class="menu">
      <li><img src="https://icon-library.com/images/meter-icon/meter-icon-1.jpg" alt="Dashboard"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Ecommerce_Admin_Dashboard/">Dashboard</a></li>
      <li><img src="https://toppng.com/uploads/preview/eye-icon-11563577054kb8jtnflax.png" alt="Complaints"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Ecommerce_Admin_Complaints/">Complaints</a></li>
      <li><img src="https://cdn-icons-png.flaticon.com/512/25/25645.png" alt="Add Slider"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Add_Slider/">Add Slider</a></li>
      <li><img src="https://icon-library.com/images/free-file-icon/free-file-icon-28.jpg" alt="Manage Slider"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Manage_Slider/">Manage Slider</a></li>
      <li><img src="https://www.svgrepo.com//show/8335/list.svg" alt="Customers"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Customers/">Customers</a></li>
      <li><img src="https://cdn-icons-png.flaticon.com/512/55/55281.png" alt="Manage Order"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Ecommerce_Manage_Order/">Manage Order</a></li>
      <li><img src="https://banner2.cleanpng.com/20180508/uyw/kisspng-power-symbol-computer-icons-5af247e6b7df19.0515539515258275587532.jpg" alt="Logout"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Ecommerce_Admin_login/">Logout</a></li>
    </div>
    </ul>
  </div>
  
<div class="inventory-icon">
    <a href="http://localhost/Kumara%20Stores%20Inventory_system/Dashboard/">
      <img src="https://www.nicepng.com/png/full/204-2049036_download-3-cube-icon.png" alt="inventory">
    </a>
  </div>
</div>

<!--Kumara Stores Logo-->
<div class="logo">
  <img src="https://i.ibb.co/jrp6hSp/Screenshot-1183.png" alt="Logo">
</div>
</div>

<!-- The "Total Users" box -->
<div class="info-box total-users-box">
    <div class="total-users">
        <p class="total-users-text">
            <?php echo $totalUsers; ?> 
            <br>Users
        </p>
    </div>
</div>

<!-- The "Total Orders" box -->
<div class="info-box total-orders-box">
    <div class="total-orders">
    <p class="total-orders-text">
            <?php echo $totalOrders; ?> 
            <br>Orders
        </p>
    </div>
  </div>


<!-- The "Total Categories" box -->
<div class="info-box total-category-box">
    <div class="total-category">
    <p class="total-category-text">
    <?php echo $totalCategory; ?> 
            <br>Categories
    </p>
    </div>
  </div>


<!-- The "Total Products" box -->
<div class="info-box total-products-box">
    <div class="total-products">
    <p class="total-products-text">
    <?php echo $totalProducts; ?> 
      <br>Products
    </p>
    </div>
  </div>


<!-- The "Total Customers" box -->
<div class="info-box total-customers-box">
    <div class="total-customers">
    <p class="total-customers-text">
    <?php echo $totalCustomers; ?> 
      <br>Customers
    </p>
    </div>
  </div>


<!-- The "Total Items" box -->
<div class="info-box total-items-box">
    <div class="total-items">
    <p class="total-items-text">
    <?php echo $totalItems; ?> 
      <br>Items
    </p>
    </div>
  </div>


<!-- The "Total Income" box -->
<div class="info-box total-income-box">
    <div class="total-income">
    <p class="total-income-text">
            Rs. <?php echo $totalIncome; ?> 
            <br>Income
        </p>
    </div>
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
