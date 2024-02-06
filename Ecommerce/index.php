<?php
include "db_connect.php";

// Function to Check if the connection is successful
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Set the character set to UTF-8
mysqli_set_charset($conn, "utf8");

// Query to get slider images
$sql = "SELECT slider_image FROM slider";
$result = mysqli_query($conn, $sql);

// Fetch all image URLs
$images = [];
while ($row = mysqli_fetch_assoc($result)) {
    $images[] = $row['slider_image'];
}


// Function For the featured products
$sql = "SELECT product_id, product_name, price, image FROM products WHERE quantity >= 10 LIMIT 4";
$productResult = mysqli_query($conn, $sql);

// Function For the new products
$sql = "SELECT product_id, product_name, price, image FROM products WHERE quantity >= 10 ORDER BY product_id DESC LIMIT 4";
$newProductResult = mysqli_query($conn, $sql);


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

<div class="slider-container">
    <?php
    // Assuming $images is an array of image data retrieved from your database
    foreach ($images as $imageData):
        // Convert the binary data to a base64-encoded image
        $imageBase64 = base64_encode($imageData);
    ?>
        <div class="slider-image">
            <!-- Use the data URI scheme to display the image -->
            <img src="data:image/jpeg;base64,<?php echo $imageBase64; ?>" alt="Slider Image">
        </div>
    <?php endforeach; ?>
</div>



<script>
    // Function to change the current image in the slider
    function changeImage() {
        const sliderImages = document.querySelectorAll('.slider-image');
        let currentIndex = 0;

        setInterval(() => {
            sliderImages[currentIndex].style.display = 'none';
            currentIndex = (currentIndex + 1) % sliderImages.length;
            sliderImages[currentIndex].style.display = 'block';
        }, 5000); // Change image every 5 seconds
    }

    // Call the function when the page loads
    window.onload = changeImage;
</script>



<div class="featured-products">
  <h2>Featured Products</h2>

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
            <a href="http://localhost/Kumara%20Stores%20Inventory_system/Buy_Now/?product_id=<?php echo $productId; ?>">Details</a>
          </div>
        </div>
      <?php
      }
      ?>
    </div>
  </div>


<!-- New Products -->
<div class="new-products">
  <h2>New Products</h2>

  <div class="product-box-container">
    <?php
    // Loop through the new product data and create a product box for each product
    while ($row = mysqli_fetch_assoc($newProductResult)) {
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
          <a href="http://localhost/Kumara%20Stores%20Inventory_system/Buy_Now/?product_id=<?php echo $productId; ?>">Details</a>
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