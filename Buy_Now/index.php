<?php
include "db_connect.php";

// Function to Check if the connection is successful
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['product_search'])) {
  $searchQuery = $_GET['product_search'];

  // Query to get product details based on the search query
  $sql = "SELECT product_name, price, image, category, description, quantity FROM products WHERE product_name = '$searchQuery'";
  $searchResult = mysqli_query($conn, $sql);

  // Function to Check if a product was found
  if (mysqli_num_rows($searchResult) > 0) {
      // Function to Fetch the product details
      $row = mysqli_fetch_assoc($searchResult);
      $productName = $row['product_name'];
      $price = $row['price'];
      $image = $row['image'];
      $category = $row['category'];
      $description = $row['description'];
      $quantity = $row['quantity'];

      // Function to Check the quantity and display an alert if it's less than 10
      if ($quantity < 10) {
          echo "<script>alert('Product Not Available.'); window.location.href = 'http://localhost/Kumara%20Stores%20Inventory_system/Ecommerce/';</script>";
      }
  } else {
      // Handle the case where no product was found
      echo "Product not found.";
  }
}





// Function to Check if the product_id is provided in the URL
if (isset($_GET['product_id'])) {
    // Get the product_id from the URL
    $productId = $_GET['product_id'];
  
    // Query to get product details based on the product_id
    $sql = "SELECT product_name, price, image, category, description FROM products WHERE product_id = $productId";
    $productResult = mysqli_query($conn, $sql);
  
    // Check if a product was found
    if (mysqli_num_rows($productResult) > 0) {
      // Fetch the product details
      $row = mysqli_fetch_assoc($productResult);
      $productName = $row['product_name'];
      $price = $row['price'];
      $image = $row['image'];
      $category = $row['category'];
      $description = $row['description'];
    } else {
      // Handle the case where no product was found
      
    }
  } else {
    // Handle the case where product_id is not provided in the URL
    
  }

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kumara Stores Online Shopping</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="header">
    <div class="rectangle">
    <div class="search-login-container">
      
    <form action="http://localhost/Kumara%20Stores%20Inventory_system/Buy_Now/" method="get">
    <input type="text" id="searchInput" class="search-input" name="product_search" placeholder="Search Product">
    <button type="submit" class="search-button">Search</button>
</form>

    <!-- Login Button -->
<a href="http://localhost/Kumara%20Stores%20Inventory_system/Ecommerce_Login/" class="login-button" style="text-decoration: none;">Login</a>
</div>
    </div>
  </div>
    </div>


 <!-- Menu -->
    <div class="menu-bar">
    <ul class="menu-list">
        <li class="menu-item"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Ecommerce/">Home</a></li>
        <li class="menu-item"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Ecommerce_Product/">Products</a></li>
        <li class="menu-item"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Ecommerce_Contact/">Contact</a></li>
        <li class="menu-item"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Ecommerce_Login/">Login</a></li>
        <li class="menu-item"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Ecommerce_Register/">Register</a></li>
    </ul>
</div>


<!-- Image Box -->
<div class="product-box">
  <img src="data:image/jpeg;base64,<?php echo base64_encode($image); ?>" alt="<?php echo $productName; ?>" class="product-image">
  <div class="product-details">
    <h2 class="product-name"><?php echo $productName; ?></h2>
    <div class="labels">
      <p><span class="label-title">Price :</span> <span class="label-value">Rs. <span class="price-value"><?php echo $price; ?></span></span></p>
      <p><span class="label-title">Category :</span> <span class="label-value category-value"><?php echo $category; ?></span></p>
      <p><span class="label-title">Description :</span> <span class="label-value description-value"><?php echo $description; ?></span></p>
    </div>
    <div class="buy-now">
      <input type="text" class="quantity" placeholder="Quantity">
      <button class="buy-button" onclick="redirectToLogin()">Add To Cart</button>
    </div>
  </div>
</div>



<script>
  function redirectToLogin() {
    window.location.href = 'http://localhost/Kumara%20Stores%20Inventory_system/Ecommerce_Login/';
  }
</script>




<!--Footer-->
<div class="footer">
<h1 class="footer-heading">Kumara Stores - Rakwana</h1>
  <h2 class="footer-address">No 25/B, Deniyaya Road, Rakwana</h2>
  <!-- Contact and Follow Us Sections -->
<div class="contact-section">
  <div class="contact">
    <h3>Contact</h3>
    <p>045 22 46333</p>
    <p>071 1212122</p>
  </div>
  <div class="follow-us">
    <h3>Follow Us</h3>
    <a href="https://www.facebook.com"><img src="https://static.vecteezy.com/system/resources/previews/020/964/386/non_2x/facebook-circle-icon-for-web-design-free-png.png" alt="Facebook"></a>
    <a href="https://mail.google.com"><img src="https://static.vecteezy.com/system/resources/previews/022/484/516/original/google-mail-gmail-icon-logo-symbol-free-png.png" alt="Gmail"></a>
  </div>
</div>
</div>



<!--Kumara Stores Logo-->
<div class="logo">
  <img src="https://i.ibb.co/jrp6hSp/Screenshot-1183.png" alt="Logo">
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

  // Function to disable zooming
  disableZoom();

</script>


</body>
</html>