<?php
include "db_connect.php";


// Function to Check if the connection is successful
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}



mysqli_set_charset($conn, "utf8");



// Query to get slider images
$sql = "SELECT slider_image FROM slider";
$result = mysqli_query($conn, $sql);

// Function to Fetch all image URLs
$images = [];
while ($row = mysqli_fetch_assoc($result)) {
    $images[] = $row['slider_image'];
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
    
</div>
    </div>
  


<!--Slider-->

    <div class="slider-container">
    <?php
    
    foreach ($images as $imageData):
        // Convert the binary data to a base64-encoded image
        $imageBase64 = base64_encode($imageData);
    ?>
        <div class="slider-image">
            
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





<div class="payment-option">
    <h2 class="payment-heading">Online Payment Option</h2>
    <div class="payment-content">
        <div class="payment-button">
            <button class="pay-here-button" onclick="paymentGateWay();">Pay Here</button>
        </div>
        <img src="https://cbr.lk/wp-content/uploads/2020/12/Dhaiya-Rice-poster.jpg" alt="Product Image" class="product-image">
        <div class="payment-texts">
            <p class="thank-you-text">Thank You for Shopping with Kumara Stores.</p>
            <p class="welcome-text">If you need more products to be purchased from Kumara Stores Online Platform, You are always Welcomed.</p>
        </div>
    </div>
</div>

<script src="script.js"></script>
<script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>




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