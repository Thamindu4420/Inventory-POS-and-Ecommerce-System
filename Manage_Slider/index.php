<?php
include "db_connect.php";

// Function to Check if the connection is successful
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Function to Check if the 'id' parameter exists in the URL (for delete action)
if (isset($_GET['delete_id'])) {
  $deleteId = $_GET['delete_id'];

  // Perform the delete action here
  $sqlDelete = "DELETE FROM slider WHERE slider_id = ?";
  $stmtDelete = $conn->prepare($sqlDelete);
  $stmtDelete->bind_param("i", $deleteId);

  if ($stmtDelete->execute()) {
    // Delete successful
    header("Location: http://localhost/Kumara%20Stores%20Inventory_system/Manage_Slider/");
    exit;
  } else {
    // Error in SQL execution
    echo "Error deleting record: " . $stmtDelete->error;
  }

  $stmtDelete->close();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ecommerce Manage Slider</title>
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
    <div class="manage-slider-text">Manage Slider</div>
    <div class="breadcrumb-text">Home &gt; Manage slider</div>
  </div>
  <div>

<div hr class="heading-line">
  </div>
  <div>

<!-- Table for managing sliders -->
<table class="manage-slider" style="transform: translateY(40px);">
    <thead>
      <tr>
        <th style="width: 30%;">Slider Title</th>
        <th style="width: 50%;">Slider Image</th>
        <th class="action-header" style="width: 20%;">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Connect to database and fetch data from the slider table
      include "db_connect.php";

      // Function to Check if the connection is successful
      if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
      }

      // Query to select data from the slider table
      $sql = "SELECT * FROM slider";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . $row["slider_title"] . "</td>";
          echo "<td><img src='data:image/jpeg;base64," . base64_encode($row['slider_image']) . "' alt='Slider Image'></td>";
          echo "<td class='action-header'>";
          echo "<a href='http://localhost/Kumara%20Stores%20Inventory_system/Add_Slider/?id=" . $row["slider_id"] . "'>";
          echo "<button class='edit-button'>";
          echo "<img src='https://www.freeiconspng.com/thumbs/edit-icon-png/edit-editor-pen-pencil-write-icon--4.png' alt='Edit'>";
          echo "</button>";
          echo "</a>";
          echo "<a href='?delete_id=" . $row["slider_id"] . "' onclick='return confirm(\"Are you sure you want to delete this slider?\");'>";
          echo "<button class='delete-button'>";
          echo "<img src='https://icons.veryicon.com/png/o/transport/shopping-mall/delete-127.png' alt='Delete'>";
          echo "</button>";
          echo "</a>";
          echo "</td>";
          echo "</tr>";
        }
      } else {
        echo "<tr><td colspan='4'>No sliders found.</td></tr>";
      }

      // Close the database connection
      $conn->close();
      ?>
    </tbody>
  </table>


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