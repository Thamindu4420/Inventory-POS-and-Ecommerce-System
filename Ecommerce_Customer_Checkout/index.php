<?php
include "db_connect.php";
include "send_email.php";


// Function to Check if the connection is successful
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}


session_start();

// Function to Check if the "Confirm and Proceed to Payment" button was clicked
if (isset($_POST['checkout-button'])) {
  // Retrieve order data from the session
  if (isset($_SESSION['order_data'])) {
      $orderData = $_SESSION['order_data'];
  } else {
      // Handle the case where order data is not available
      die("Order data not found.");
  }

   
  // Retrieve checkout form data
  $name = $_POST['name'];
  $email = $_POST['email'];
  $address = $_POST['address'];
  $city = $_POST['city'];
  $postalCode = $_POST['postal_code'];
  $contactNumber = $_POST['contact_number'];
  $paymentMethod = $_POST['payment_method'];

   // Calculate the total sum of the cart
   $totalSum = 0;
   foreach ($orderData as $product) {
     $totalSum += $product['total_price'];
   }
 
  foreach ($orderData as $product) {
      $productName = $product['product_name'];
      $price = $product['price'];
      $quantity = $product['quantity'];
      $totalPrice = $product['total_price'];
      
    

      // Insert data into the customer_orders table
      $sql = "INSERT INTO customer_orders (product_name, price, quantity, total_price, sub_total, name, email, address, city, postal_code, contact_number, payment_method) VALUES ('$productName', '$price', '$quantity', '$totalPrice', '$totalSum', '$name', '$email', '$address', '$city', '$postalCode', '$contactNumber', '$paymentMethod')";

      if (mysqli_query($conn, $sql)) {
          
      
      } else {
          // Handle the case where data insertion failed
          die("Error: " . $sql . "<br>" . mysqli_error($conn));
      }
}

// Call the sendEmail function and pass the necessary data
if (sendEmail($email, $name)) {
  // Email sent successfully
  echo 'Email sent successfully.';
} else {
  // Email sending failed
  echo 'Email sending failed.';
}


   // Calculate the total sum of the cart
   $totalSum = 0;
   foreach ($orderData as $product) {
       $totalSum += $product['total_price'];
   }

   // Store the totalSum in the session
   $_SESSION['totalSum'] = $totalSum;


  // Close the database connection
  mysqli_close($conn);

  // Check the selected payment method and redirect accordingly
  if ($paymentMethod === "credit_card") {
    header("Location: http://localhost/Kumara%20Stores%20Inventory_system/Ecommerce_Payment_Option/");
  } else {
    header("Location: http://localhost/Kumara%20Stores%20Inventory_system/Ecommerce_Customer_Checkout/");
  }
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


<!-- Checkout Form -->
<div class="checkout-form">
    <h2 class="shipping-address-heading">Your Shipping Address</h2>
    <form id="checkout-form" action="" method="post">
        <div class="form-row">
            <input type="text" id="name" name="name" placeholder="Name" required>
            <input type="email" id="email" name="email" placeholder="Email" required>
        </div>
        <div class="form-row">
            <input type="text" id="address" name="address" placeholder="Address" required>
            <input type="text" id="city" name="city" placeholder="City" required>
        </div>
        <div class="form-row">
            <input type="text" id="postal-code" name="postal_code" placeholder="Postal Code" required>
            <input type="tel" id="contact-number" name="contact_number" placeholder="Contact Number" required>
        </div>
        <br>
        <br>
        <div class="form-row2">
            <label for="payment-method" style="font-weight:bold; font-size:22px; font-family: 'Segoe UI', sans-serif">Payment Options:</label>
            <br>
            <br>
            <div class="payment-method-options">
                <input type="radio" id="cash-on-delivery" name="payment_method" value="cash on delivery" required>
                <label for="cash-on-delivery" style="font-size:18px; margin-right: 3%">Cash On Delivery</label>

                <input type="radio" id="credit-card" name="payment_method" value="credit_card" required>
                <label for="credit-card" style="font-size:18px;">Debit/Credit Card</label>
            </div>
        </div>

        <button type="submit" name="checkout-button" class="checkout-button">Confirm and Proceed to Payment</button>
    </form>
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
