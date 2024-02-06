<?php
include "db_connect.php";

// Function to Check if the connection is successful
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}



session_start();

// Function to calculate total price for a product
function calculateTotalPrice($price, $quantity) {
    return $price * $quantity;
}

// Function to remove a product from the cart
function removeFromCart($productId) {
    if (isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
    }
}

// Function to Check if  remove button was clicked
if (isset($_POST['remove_product'])) {
    $productIdToRemove = $_POST['remove_product'];
    // Remove the product from the cart
    removeFromCart($productIdToRemove);
    // Redirect back to the cart page
    header("Location: http://localhost/Kumara%20Stores%20Inventory_system/Ecommerce_Customer_Cart/");
    exit();
}



// Check if the "Refresh" button was clicked
if (isset($_POST['refresh_cart'])) {
  // Clear the cart by unsetting the session variable
  unset($_SESSION['cart']);
  // Redirect back to the cart page
  header("Location: http://localhost/Kumara%20Stores%20Inventory_system/Ecommerce_Customer_Cart/");
  exit();
}





// Check if the "Checkout" button was clicked
if (isset($_POST['checkout'])) {
  // Create an array to store the cart data
  $orderData = array();

  // Check if the cart session exists
  if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
      foreach ($_SESSION['cart'] as $index => $product) {
          // Calculate total price for this product
          $totalPrice = calculateTotalPrice($product['product_price'], $product['quantity']);

        // Add the total price of this product to the total sum
        $totalSum += $totalPrice;

          // Add product data to the orderData array
          $orderData[] = array(
              'product_name' => $product['product_name'],
              'price' => $product['product_price'],
              'quantity' => $product['quantity'],
              'total_price' => $totalPrice,
              'total_sum' => $totalSum
          );
      }
  }

  // Store the order data in a session variable
  $_SESSION['order_data'] = $orderData;

  // Redirect to the checkout page
  header("Location: http://localhost/Kumara%20Stores%20Inventory_system/Ecommerce_Customer_Checkout/");
  exit();
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


<!-- Cart Heading -->
<h1 class="cart-heading">Your Cart</h1>



<!-- Refresh Button -->
<form method="post" class="refresh-button-form">
    <button type="submit" name="refresh_cart" class="refresh-button">
        Refresh
    </button>
</form>





<!-- Cart Form -->
<?php

// Initialize a variable to store the total sum
$totalSum = 0;

// Function to Check if the cart session exists
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    echo '<form class="cart-form" method="post" action="">'; 
    echo '<table class="cart-table">';
    echo '<thead><tr><th>Product Name</th><th>Price</th><th>Quantity</th><th>Total Price</th><th>Action</th></tr></thead>';
    echo '<tbody>';

    foreach ($_SESSION['cart'] as $index => $product) {
        echo '<tr>';
        echo '<td>' . $product['product_name'] . '</td>';
        echo '<td>Rs. ' . $product['product_price'] . '</td>';
        echo '<td>' . $product['quantity'] . '</td>';
        // Calculate total price for this product
        $totalPrice = calculateTotalPrice($product['product_price'], $product['quantity']);
        echo '<td>Rs. ' . $totalPrice . '</td>';
        echo '<td>';
        // Add a remove button for each item
        echo '<button type="submit" name="remove_product" value="' . $index . '" class="remove-button">';
        echo '<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/8f/Flat_cross_icon.svg/640px-Flat_cross_icon.svg.png" alt="Remove">';
        echo '</button>';
        echo '</td>';
        echo '</tr>';

        // Add the total price of this product to the total sum
        $totalSum += $totalPrice;
    }

    echo '</tbody></table>';
    echo '</form>';
} else {
    echo '<p>Your cart is empty.</p>';
}



// Display the total sum in the "sub-total-value"
echo '<p class="sub-total">Sub-Total: <span class="sub-total-value">Rs. ' . $totalSum . '</span></p>';


?>



    <!-- Buttons -->
    <div class="cart-buttons">
    <form method="post" action="http://localhost/Kumara%20Stores%20Inventory_system/Ecommerce_Customer_Product/" style="display:inline;">
        <button class="continue-shopping">
            <img src="https://cdn-icons-png.flaticon.com/512/1124/1124199.png" alt="Continue Shopping"> Continue shopping
        </button>
    </form>
    <form method="post" class="checkout-button-form" style="display:inline;">
    <button type="submit" name="checkout" class="checkout-button">
        Checkout
    </button>

</form>



<!--Footer-->
<div class="footer" style="margin-bottom:-6%;">
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