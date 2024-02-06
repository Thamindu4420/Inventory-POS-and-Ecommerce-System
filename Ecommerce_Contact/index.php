<?php
include "db_connect.php";

// Function to Check if the connection is successful
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user-submitted data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
  
    // Insert data into the complaints table
    $sql = "INSERT INTO complaints (name, email, contact_number, subject) VALUES ('$name', '$email', '$mobile', '$subject')";
  
    if (mysqli_query($conn, $sql)) {
      echo '<script>alert("Your complaint has been submitted successfully.");</script>';
    } else {
      echo '<script>alert("Error: ' . mysqli_error($conn) . '");</script>';
    }
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


<div class="contact-heading">
    <h1>Contact Page</h1>
    <p class="sub-heading">
        We are pleased to take any of your complaints. <br>
        As one of the best supermarkets, our main goal is to provide customers a great service.
        If there's any problem with our service, Please contact us.
    </p>
</div>


<!-- Contact Us Section -->
<div class="contact-us">
    <h2>Contact Us</h2>
    <form action="index.php" method="post">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="mobile">Mobile No:</label>
            <input type="tel" id="mobile" name="mobile" required>
        </div>
        <div class="form-group">
            <label for="subject">Subject:</label>
            <textarea id="subject" name="subject" rows="4" required></textarea>
        </div>
        <button type="submit" class="submit-button">Submit</button>
    </form>
</div>

<!-- Image Box -->
<div class="image-box">
    <img src="https://vernoncorea.files.wordpress.com/2012/09/bathiyaandsanthushmalibanambassadors.jpg" alt="Image">
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
