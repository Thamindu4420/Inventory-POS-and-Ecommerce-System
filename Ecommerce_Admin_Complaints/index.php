<?php
include "db_connect.php";

// Function to Check if the connection is successful
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ecommerce Admin Complaints</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <div class="header">
    <div class="rectangle"></div>
    <div class="admin-panel-text">E-Commerce Admin Panel</div>
  </div>
    </div>

<!-- "Complaints" and "Home > COmplaints" texts -->

    <div class="texts">
    <div class="complaints-text">Complaints</div>
    <div class="breadcrumb-text">Home &gt; complaints</div>
  </div>
  <div>

<div hr class="heading-line">
  </div>
<div>

<!-- Table -->
<table class="complaint-table" style="transform: translateY(40px);">
  <thead>
    <tr>
      <th style="width: 20%;">Name</th>
      <th style="width: 20%;">Email</th>
      <th style="width: 15%;">Contact Number</th>
      <th style="width: 35%;">Subject</th>
      <th style="width: 10%;">Action</th>
    </tr>
  </thead>
  <tbody>

  <?php
  // Query to select data from the complaints table
$sql = "SELECT * FROM complaints";
$result = $conn->query($sql);

// Check if there are rows in the result
if ($result->num_rows > 0) {
  

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["contact_number"] . "</td>";
        echo "<td>" . $row["subject"] . "</td>";
        echo "<td class='action-column'>
        <button class='delete-button' data-complaintid='" . $row["complaint_id"] . "'>
        <img class='button-icon' src='https://icons.veryicon.com/png/o/transport/shopping-mall/delete-127.png' alt='Delete'>
        </button>
        </td>";
        echo "</tr>";
    }

    echo "</tbody></table>";
} else {
    echo "No complaints found.";
}

// Close the database connection
$conn->close();
   ?>
            
  </tbody>
</table>


<script>
$(document).ready(function () {
    $('.delete-button').click(function () {
        var complaintId = $(this).data('complaintid'); // Get the complaint ID

        // Display a confirmation dialog
        var confirmDelete = confirm('Are you sure you want to delete this complaint?');

        if (confirmDelete) {
            // Send an AJAX request to delete the complaint
            $.ajax({
                type: 'POST',
                url: 'delete_complaint.php', 
                data: { complaint_id: complaintId },
                success: function (response) {
                    // If deletion was successful, remove the row from the HTML table
                    if (response === 'success') {
                        $(this).closest('tr').remove();
                    } else {
                        alert('Deletion failed. Please try again.');
                    }
                }
            });
        }
    });
});
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