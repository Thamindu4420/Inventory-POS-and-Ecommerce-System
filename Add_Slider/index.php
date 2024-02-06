<?php
include "db_connect.php";

// Function to Check if the connection is successful
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$editMode = false;
$sliderTitle = "";
$sliderImageData = "";

// Function to Check if the 'id' parameter exists in the URL
if (isset($_GET['id'])) {
  
  $editMode = true;

  // Retrieve the slider data associated with the provided 'id'
  $sliderId = $_GET['id'];
  $sql = "SELECT * FROM slider WHERE slider_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $sliderId);

  if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $sliderTitle = $row["slider_title"];
      $sliderImageData = $row["slider_image"];
    } else {
      
    }
  } else {
    // Error in SQL execution
    echo "Error: " . $stmt->error;
  }

  $stmt->close();
}

// Check if the form is submitted
if (isset($_POST['save'])) {
  // Retrieve data from the form
  $sliderTitle = $_POST['sliderTitle'];

  // Handle the image upload
  $sliderImageData = file_get_contents($_FILES["sliderImage"]["tmp_name"]);

  if ($editMode) {
    // User is in edit mode, update the existing slider
    $sql = "UPDATE slider SET slider_title = ?, slider_image = ? WHERE slider_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $sliderTitle, $sliderImageData, $sliderId);
  } else {
    // User is in add mode, insert a new slider
    $sql = "INSERT INTO slider (slider_title, slider_image) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $sliderTitle, $sliderImageData);
  }

  if ($stmt->execute()) {
    
  } else {
    
    echo "Error: " . $stmt->error;
  }

  $stmt->close();
}

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ecommerce Add Slider</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="header">
    <div class="rectangle"></div>
    <div class="admin-panel-text">E-Commerce Admin Panel</div>
  </div>
    </div>

<!-- "Add Slider" and "Home > Add Slider" texts -->

    <div class="texts">
    <div class="add-slider-text">Add Slider</div>
    <div class="breadcrumb-text">Home &gt; Add slider</div>
  </div>
  <div>

<div hr class="heading-line">
  </div>
<div>


 <!-- Form for adding a slider -->
 <form class="add-slider-form" method="POST" enctype="multipart/form-data">

            <div class= "sliderTitle">
            <label for="sliderTitle">Slider Title:</label>
            <input type="text" id="sliderTitle" name="sliderTitle" required value="<?php echo htmlspecialchars($sliderTitle); ?>">
            </div>

            <!-- Display the pre-uploaded image -->
            <div class="sliderImage">
            <label for="sliderImage">Slider Image:</label>
            <?php if ($sliderImageData): ?>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($sliderImageData); ?>" alt="Uploaded Image" style="max-width: 200px;">
            <?php else: ?>
            <p>No image uploaded</p>
            <?php endif; ?>
           </div>

            <!-- File input field for a new image -->
            <div class="sliderImage">
            <label for="newSliderImage">Upload a new image:</label>
            <input type="file" id="newSliderImage" name="sliderImage" accept="image/*">
           </div>

            <div class="form-buttons">
            <button type="submit" class="save-button" name="save">Save</button>

            <a href="http://localhost/Kumara%20Stores%20Inventory_system/Manage_Slider/">
            <button type="button" class="back-button" >Back
            </button>
          </a>

        </form>
    </div>



    <script>
        // Function to display a preview of the selected image
        function previewImage() {
            var input = document.getElementById('sliderImage');
            var preview = document.getElementById('previewImage');
            
            input.addEventListener('change', function () {
                var file = input.files[0];
                var reader = new FileReader();

                reader.onload = function () {
                    preview.src = reader.result;
                    preview.style.display = 'block';
                }

                if (file) {
                    reader.readAsDataURL(file);
                }
            });
        }

        // Call the function to enable image preview
        previewImage();
    </script>







<!-- Sidebar -->

<div class="sidebar" style="transform: translateY(110px);">
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