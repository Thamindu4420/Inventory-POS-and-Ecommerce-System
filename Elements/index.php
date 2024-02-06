<?php
// Include the database connection file
include "db_connect.php";

// Function to Check if the delete button is clicked
if (isset($_GET['delete'])) {
  $elementIdToDelete = $_GET['delete'];

  // Delete the record from the database
  $sqlDelete = "DELETE FROM elements WHERE element_id = '$elementIdToDelete'";
  $resultDelete = mysqli_query($conn, $sqlDelete);

  if ($resultDelete) {
    // Query successful, update the total element count in the session
    session_start();
    $sqlCountElements = "SELECT COUNT(*) AS total_elements FROM elements";
    $resultCountElements = mysqli_query($conn, $sqlCountElements);
    $data = mysqli_fetch_assoc($resultCountElements);
    $_SESSION['total_elements'] = $data['total_elements'];
  }
}

// Fetch all elements from the 'elements' table
$sql = "SELECT * FROM elements";
$result = mysqli_query($conn, $sql);

// Function to get the button class based on the status
function getButtonClass($status) {
  return ($status === 'Active') ? 'active' : 'inactive';
}

// Get the total number of elements
$totalElements = mysqli_num_rows($result);

// Start a PHP session (if not already started)
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

// Store the total elements count in the session variable
$_SESSION['total_elements'] = $totalElements;
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Elements</title>
  <link rel="stylesheet" href="style.css">

  <script>
  function deleteElement(elementId) {
    if (confirm('Are you sure you want to delete this element?')) {
      // Redirect back to the elements page after deleting
      window.location.href = 'http://localhost/Kumara%20Stores%20Inventory_system/Elements/?delete=' + elementId;
    }
  }
</script>

</head>
<body>
<div class="header">
    <div class="rectangle"></div>
</div>
<div class="content">
  <!-- "Manage Elements" and "Home > Elements" texts -->
  <div class="texts">
    <div class="manage-elements-text">Manage Elements</div>
    <div class="breadcrumb-text">Home &gt; Elements</div>
  </div>
  <div>
  <!-- Add Elements Button -->
  <a href="http://localhost/Kumara%20Stores%20Inventory_system/Add_Elements/">
  <button class="add-elements-button">
    <span class="button-text">Add Elements</span>
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

  // Attach the searchItems function to the "input" event of the search input
  document.getElementById("searchInput").addEventListener("input", searchItems);
</script>


<!-- Table -->
<table class="elements-table" style="transform: translateY(40px);">
  <thead>
    <tr>
      <th style="width: 33%;">Element</th>
      <th class="status-column" style="width: 33%;">Status</th>
      <th style="width: 33%;">Action</th>
    </tr>
  </thead>
  <tbody>

  <?php
    // Inside the while loop for fetching data from the database
while ($row = mysqli_fetch_assoc($result)) {
  $elementId = $row['element_id'];
  $elementName = $row['element'];
  $status = $row['status'];

  // Determine the button class based on the status value
  $buttonClass = ($status === 'active') ? 'active' : 'inactive';
  $buttonText = ucfirst($status); 

  ?>

  <tr>
      <td><?php echo $elementName; ?></td>
      <td class="status-column">
      <input type="button" class="status-button <?php echo ($status === 'active') ? 'active' : 'inactive'; ?>" value="<?php echo ucfirst($status); ?>" disabled>
      </div>
      </td>
      <td>
        <!-- Add value Button -->
        <a href="http://localhost/Kumara%20Stores%20Inventory_system/Add_Value/?elementName=<?php echo urlencode($elementName) ?>">
      <button class="add-value-button" style="background-color: light green;">
    <span class="button-text" style="font-family: 'Segoe UI', sans-serif; font-size: 15px; font-weight: normal; color: white;">+ Add Value</span>
  </button>
        </a>
       <!-- Edit Button -->
      <a href="http://localhost/Kumara%20Stores%20Inventory_system/Add_Elements/?element_id=<?php echo $elementId; ?>&edit=true">
      <button class="edit-button">
      <img class="button-icon" src="https://www.freeiconspng.com/thumbs/edit-icon-png/edit-editor-pen-pencil-write-icon--4.png" alt="Edit">
    </button>
          </a>
       <!-- Delete Button -->
       <button class="delete-button" onclick="deleteElement(<?php echo $elementId; ?>)">
          <img class="button-icon" src="https://icons.veryicon.com/png/o/transport/shopping-mall/delete-127.png" alt="Delete">
        </button>
      </td>
    </tr>
    <?php } ?>
  </tbody>
</table>

<script>
  function toggleStatus(button) {
    if (button.classList.contains('active')) {
      button.classList.remove('active');
      button.classList.add('inactive');
      button.innerText = 'Inactive';
    } else {
      button.classList.remove('inactive');
      button.classList.add('active');
      button.innerText = 'Active';
    }
  }
</script>
</div>  

<!-- Side Bar -->
<div class="sidebar" style="transform: translateY(98px);">
  <ul class="menu">
    <li><img src="https://icon-library.com/images/meter-icon/meter-icon-1.jpg" alt="Dashboard"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Dashboard/">Dashboard</a></li>
    <li><img src="https://www.nicepng.com/png/full/204-2049036_download-3-cube-icon.png" alt="Items"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Items/index.php">Items</a></li>
    <li><img src="https://www.nicepng.com/png/full/204-2049036_download-3-cube-icon.png" alt="Category"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Category/">Category</a></li>
    <li><img src="https://toppng.com/uploads/preview/open-warehouse-icon-font-awesome-11563302767pao8zak6mz.png" alt="Warehouse"><a href="http://localhost/Kumara%20Stores%20Inventory_system/Warehouse/">Warehouse</a></li>
    <li><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT5afpx3wsQgzXLHss8vgGV55nP5_B6fdhK6w&usqp=CAU" alt="Elements"><a href="">Elements</a></li>
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