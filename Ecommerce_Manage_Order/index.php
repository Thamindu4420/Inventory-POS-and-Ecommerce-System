<?php
include "db_connect.php";

// Function to Check if the connection is successful
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}


// Function to Fetch data from the customer_orders table and group by name and sub_total
$sql = "SELECT name, contact_number, email, sub_total, payment_method FROM customer_orders GROUP BY name, sub_total";
$result = mysqli_query($conn, $sql);

if (!$result) {
  die("Error: " . $sql . "<br>" . mysqli_error($conn));
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ecommerce Manage Order</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="header">
    <div class="rectangle"></div>
    <div class="admin-panel-text">E-Commerce Admin Panel</div>
  </div>
    </div>

<!-- "Manage Order" and "Home > Manage Order" texts -->

    <div class="texts">
    <div class="manage-order-text">Manage Order</div>
    <div class="breadcrumb-text">Home &gt; Manage Order</div>
  </div>
  <div>

<div hr class="heading-line">
  </div>
  <div>

  <!-- Search text box -->
  <div class="search-box">
  <input type="text" id="searchInput" placeholder="Search Customer Order">
</div>

<script>
function searchCustomerorders() {
  // Get the search input value
  var input, filter, table, tr, td, i, j, txtValue;
  input = document.getElementById("searchInput");
  filter = input.value.toUpperCase();
  table = document.querySelector(".customer-orders");
  tr = table.getElementsByTagName("tr");

  // Start the loop from the second row (index 1) to avoid searching in headings
  for (i = 1; i < tr.length; i++) {
    var rowVisible = false; 

    // Loop through all columns in each row
    for (j = 0; j < tr[i].cells.length - 1; j++) {
      td = tr[i].getElementsByTagName("td")[j];
      if (td) {
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          
          tr[i].style.display = "";
          rowVisible = true;
          break; 
        }
      }
    }

    // If no column in the row matches the search, hide the row
    if (!rowVisible) {
      tr[i].style.display = "none";
    }
  }
}

// Attach the searchSupplier function to the "input" event of the search input
document.getElementById("searchInput").addEventListener("input", searchCustomerorders);
</script>




 <!-- Table for Customer Orders -->
 <table class="customer-orders" style="transform: translateY(40px);">
    <thead>
      <tr>
        <th style="width: 20%;">Customer Name</th>
        <th style="width: 10%;">Customer Number</th>
        <th style="width: 20%;">Email</th>
        <th style="width: 20%;">Total Amount</th>
        <th style="width: 20%;">Payment Method</th>
        <th class="action-header" style="width: 10%;">Action</th>
      </tr>
    </thead>
    <tbody>
    <?php
// Loop through the fetched data and populate the table rows
while ($row = mysqli_fetch_assoc($result)) {
  echo "<tr>";
  echo "<td>" . $row['name'] . "</td>";
  echo "<td>" . $row['contact_number'] . "</td>";
  echo "<td>" . $row['email'] . "</td>";
  echo "<td>Rs. " . $row['sub_total'] . "</td>";
  echo "<td>" . $row['payment_method'] . "</td>";
  echo '<td class="action-column"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Ecommerce_Order_Details/index.php?name=' . urlencode($row['name']) . '&sub_total=' . urlencode($row['sub_total']) . '" class="view-button">View</a></td>';
  echo "</tr>";
}
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



<?php
// Close the database connection
mysqli_close($conn);
?>