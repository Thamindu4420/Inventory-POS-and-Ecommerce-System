<?php
// Database connection file
include "db_connect.php";

// Function to Check if the delete button is clicked
if (isset($_GET['delete'])) {
  $elementvalueIdToDelete = $_GET['delete'];

  // Delete the record from the database
  $sqlDelete = "DELETE FROM element_value WHERE element_value_id = '$elementvalueIdToDelete'";
  $resultDelete = mysqli_query($conn, $sqlDelete);

if ($resultDelete) {
  // Query successful, update the total element value count in the session
  session_start();
  $sqlCountElement_Value = "SELECT COUNT(*) AS total_element_value FROM element_value";
  $resultCountElement_Value = mysqli_query($conn, $sqlCountElement_Value);
  $data = mysqli_fetch_assoc($resultCountElement_Value);
  $_SESSION['total_element_value'] = $data['total_element_value'];
}
}

// Fetch all elements from the 'elements' table
$sql = "SELECT * FROM element_value";
$result = mysqli_query($conn, $sql);

// Get the total number of elements
$totalElement_Value = mysqli_num_rows($result);

// Start a PHP session 
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

// Store the total elements count in the session variable
$_SESSION['total_element_value'] = $totalElement_Value;

?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Elements</title>
  <link rel="stylesheet" href="style.css">

  <script>
  function deleteElementsValue(element_valueId) {
    if (confirm('Are you sure you want to delete this Element Value?')) {
      // Redirect back to the elements page after deleting
      window.location.href = 'http://localhost/Kumara%20Stores%20Inventory_system/Add_Value/?delete=' + element_valueId;
    }
  }
</script>

</head>
<body>
<div class="header">
    <div class="rectangle"></div>
</div>
<div class="content">
  <!-- "Manage Elements" and "Home > Elements > Elements value" texts -->
  <div class="texts">
    <div class="manage-elements-text">Manage Elements</div>
    <div class="breadcrumb-text">Home &gt; <a href="http://localhost/Kumara%20Stores%20Inventory_system/Elements/">Elements</a> &gt; Elements Value</div>
  </div>

  <!-- Elements name text -->
  <div class="elements-name">
   Element name: <span id="elementName"></span>
</div>

<script>
  window.onload = function() {
    const urlParams = new URLSearchParams(window.location.search);
    const elementName = urlParams.get('elementName');

    // Display the element name in the "Elements name" text
    document.getElementById('elementName').innerText = elementName;
  };
</script>

  <div>
  <!-- Add Value Button -->
  <a href="http://localhost/Kumara%20Stores%20Inventory_system/Add_Elements_Value/">
  <button class="add-value-button">
    <span class="button-text">Add Value</span>
  </button>
  </a>
<div>
  <!-- Print Button -->
  <button class="print-button" onclick="printTable()">
    <span class="button-text">Print</span>
  </button>
</div>
  <!-- Search text box -->
  <div class="search-box">
  <input type="text" id="searchInput" placeholder="Search Element">
</div>

<script>
function searchItems() {
  // Get the search input value
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("searchInput");
  filter = input.value.toUpperCase();
  table = document.querySelector(".elements-table");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows and hide those that do not match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0]; 
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}

// Attach the searchADDVAUE function to the "input" event of the search input
document.getElementById("searchInput").addEventListener("input", searchItems);
</script>

<!-- Table -->
<table class="elements-table" style="transform: translateY(40px);">
  <thead>
    <tr>
      <th>Elements value</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>

  <?php
    // Inside the while loop for fetching data from the database
while ($row = mysqli_fetch_assoc($result)) {
  $element_valueId = $row['element_value_id'];
  $elementsValue = $row['elements_value'];
  ?>


  <tr>
  <td><?php echo $elementsValue; ?></td>
      <td>
       <!-- Edit Button -->
      <a href="http://localhost/Kumara%20Stores%20Inventory_system/Add_Elements_Value/?edit=<?php echo urlencode($elementsValue); ?>&id=<?php echo $element_valueId; ?>">
      <button class="edit-button">
      <img class="button-icon" src="https://www.freeiconspng.com/thumbs/edit-icon-png/edit-editor-pen-pencil-write-icon--4.png" alt="Edit">
    </button>
          </a>
       <!-- Delete Button -->
       <button class="delete-button" onclick="deleteElementsValue(<?php echo $element_valueId; ?>)">
          <img class="button-icon" src="https://icons.veryicon.com/png/o/transport/shopping-mall/delete-127.png" alt="Delete">
        </button>
      </td>
    </tr>
    <?php } ?>
  </tbody>
</table>
</div>  

<!-- Side Bar -->
<div class="sidebar" style="transform: translateY(98px);">
  <ul class="menu">
    <li><img src="https://icon-library.com/images/meter-icon/meter-icon-1.jpg" alt="Dashboard"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Dashboard/">Dashboard</a></li>
    <li><img src="https://www.nicepng.com/png/full/204-2049036_download-3-cube-icon.png" alt="Items"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Items/index.php">Items</a></li>
    <li><img src="https://www.nicepng.com/png/full/204-2049036_download-3-cube-icon.png" alt="Category"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Category/">Category</a></li>
    <li><img src="https://toppng.com/uploads/preview/open-warehouse-icon-font-awesome-11563302767pao8zak6mz.png" alt="Warehouse"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Warehouse/">Warehouse</a></li>
    <li><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT5afpx3wsQgzXLHss8vgGV55nP5_B6fdhK6w&usqp=CAU" alt="Elements"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Elements/">Elements</a></li>
    <li class="submenu">
      <img src="https://www.svgrepo.com/show/57782/closed-box.svg" alt="Products"><a href="#">Products</a>
      <span class="dropdown-icon">&#9660;</span>
      <ul class="sub-menu">
        <li><span class="icon"><img src="https://cdn-icons-png.flaticon.com/512/7613/7613915.png" alt="Add Products"></span><a href="http://localhost/Kumara%20Stores%20Inventory_system/Add_Product/">Add Products</a></li>
        <li><span class="icon"><img src="https://cdn-icons-png.flaticon.com/512/7613/7613915.png" alt="Manage Products"></span><a href="http://localhost/Kumara%20Stores%20Inventory_system/Manage_Product/">Manage Products</a></li>
      </ul>
    </li>
    <li class="submenu">
      <img src="https://cdn3.iconfinder.com/data/icons/pyconic-icons-3-1/512/dollar-512.png" alt="Orders"><a href="#">Orders</a>
      <span class="dropdown-icon">&#9660;</span>
      <ul class="sub-menu">
        <li><span class="icon"><img src="https://cdn-icons-png.flaticon.com/512/7613/7613915.png" alt="Add Orders"></span><a href="http://localhost/Kumara%20Stores%20Inventory_system/Add_Order/">Add Order</a></li>
        <li><span class="icon"><img src="https://cdn-icons-png.flaticon.com/512/7613/7613915.png" alt="Manage Orders"></span><a href="http://localhost/Kumara%20Stores%20Inventory_system/Manage_Order/">Manage Orders</a></li>
      </ul>
    </li>
    <li class="submenu">
      <img src="https://cdn-icons-png.flaticon.com/512/2118/2118701.png" alt="Members"><a href="#">Members</a>
      <span class="dropdown-icon">&#9660;</span>
      <ul class="sub-menu">
        <li><span class="icon"><img src="https://cdn-icons-png.flaticon.com/512/7613/7613915.png" alt="Add Members"></span><a href="http://localhost/Kumara%20Stores%20Inventory_system/Add_Member/">Add Members</a></li>
        <li><span class="icon"><img src="https://cdn-icons-png.flaticon.com/512/7613/7613915.png" alt="Manage Members"></span><a href="http://localhost/Kumara%20Stores%20Inventory_system/Manage_Member/">Manage Members</a></li>
      </ul>
    </li>
    <li class="submenu">
      <img src="https://www.freeiconspng.com/thumbs/recycle-icon-png/black-recycle-icon-png-2.png" alt="Suppliers"><a href="#">Suppliers</a>
      <span class="dropdown-icon">&#9660;</span>
      <ul class="sub-menu">
        <li><span class="icon"><img src="https://cdn-icons-png.flaticon.com/512/7613/7613915.png" alt="Add Supplier"></span><a href="http://localhost/Kumara%20Stores%20Inventory_system/Add_Supplier/">Add Supplier</a></li>
        <li><span class="icon"><img src="https://cdn-icons-png.flaticon.com/512/7613/7613915.png" alt="Manage Suppliers"></span><a href="http://localhost/Kumara%20Stores%20Inventory_system/Manage_Supplier/">Manage Suppliers</a></li>
      </ul>
    </li>
    <li><img src="https://www.iconpacks.net/icons/1/free-building-icon-1062-thumb.png" alt="Invoice"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Invoice/">Invoice</a></li>
    <div>
    <li><img src="https://banner2.cleanpng.com/20180508/uyw/kisspng-power-symbol-computer-icons-5af247e6b7df19.0515539515258275587532.jpg" alt="Logout"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Login/">Logout</a></li>
  </div>
  </ul>
</div>
<!--Kumara Stores Logo-->
<div class="logo">
      <img src="https://i.ibb.co/jrp6hSp/Screenshot-1183.png" alt="Logo">
    </div>
    </div> 
    <script src="script.js"></script>

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