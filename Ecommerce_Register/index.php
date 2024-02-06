<?php
include "db_connect.php";
include "send_email.php";

// Function to Check if the connection is successful
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}


// Function to Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get user input from the form
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $address = $_POST['address'];
  $city = $_POST['city'];
  $country = $_POST['country'];
  $contact_number = $_POST['contact_number'];

  // SQL query to insert data into the 'customers' table
  $sql = "INSERT INTO customers (name, email, password, address, city, country, contact) VALUES ('$name', '$email', '$password', '$address', '$city', '$country', '$contact_number')";

  if (mysqli_query($conn, $sql)) {
    sendEmail($email, $name);
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
}


// Close the database connection
mysqli_close($conn);

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


<div class="registration-form">
    <h2>Create a New Account</h2>
    <form action="index.php" method="post">
      <div class="form-row">
        <input type="text" id="name" name="name" placeholder="Name" required>
        <input type="email" id="email" name="email" placeholder="Email" required>
      </div>
      <div class="form-row">
        <input type="password" id="password" name="password" placeholder="Password" required>
        <input type="text" id="address" name="address" placeholder="Address" required>
      </div>
      <div class="form-row">
        <input type="text" id="city" name="city" placeholder="City" required>
        <input type="text" id="country" name="country" placeholder="Country" required>
      </div>
      <div class="form-row">
        <input type="tel" id="contact-number" name="contact_number" placeholder="Contact Number" required>
      </div>
      <button type="submit" class="create-account-button">Create Account</button>
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
