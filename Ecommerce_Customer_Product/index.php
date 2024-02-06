<?php
include "db_connect.php";

// Function to Check if the connection is successful
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}


// Function to Fetch product data from the database (you need to modify this query)
$sql = "SELECT product_id, product_name, price, image FROM products WHERE quantity >= 10 LIMIT 4";
$productResult = mysqli_query($conn, $sql);

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
      
    <form action="http://localhost/Kumara%20Stores%20Inventory_system/Ecommerce_Customer_Buynow/" method="get">
    <input type="text" id="searchInput" class="search-input" name="product_search" placeholder="Search Product">
    <button type="submit" class="search-button">Search</button>
</form>

   <!-- Logout Button -->
<a href="http://localhost/Kumara%20Stores%20Inventory_system/Ecommerce/" class="logout-button" style="text-decoration: none;">Logout</a>
</div>
    </div>
  </div>
    </div>


 <!-- Menu -->
 <div class="menu-bar">
    <ul class="menu-list">
        <li class="menu-item"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Ecommerce_Customer_Homepage/">Home</a></li>
        <li class="menu-item"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Ecommerce_Customer_Product/">Products</a></li>
        <li class="menu-item"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Ecommer_Customer_Contact/">Contact</a></li>
        <li class="menu-item"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Ecommerce_Customer_Cart/">Cart</a></li>
    </ul>
</div>



<div class="featured-products">
  <h2>Shop Page</h2>

  <div class="product-box-container">
      <?php
      // Loop through the product data and create a product box for each product
      while ($row = mysqli_fetch_assoc($productResult)) {
        $productId = $row['product_id'];
        $productName = $row['product_name'];
        $price = $row['price'];
        $image = $row['image'];
        
      ?>
        <div class="product-box">
          <div class="product-image">
          <img src="data:image/jpeg;base64,<?php echo base64_encode($image); ?>" alt="<?php echo $productName; ?>">
          </div>
          <div class="product-details">
            <h3><?php echo $productName; ?></h3>
            <p>Price: Rs.<?php echo $price; ?></p>
            <a href="http://localhost/Kumara%20Stores%20Inventory_system/Ecommerce_Customer_Buynow/?product_id=<?php echo $productId; ?>">Details</a>
          </div>
        </div>
      <?php
      }
      ?>
    </div>
  </div>




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

  // function to disable zooming
  disableZoom();

</script>


</body>
</html>
