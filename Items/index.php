<?php
// Include the database connection file
include "db_connect.php";

// Function to check if the delete button is clicked
if (isset($_GET['delete'])) {
  $itemIdToDelete = $_GET['delete'];

  // Delete the record from the database
  $sqlDelete = "DELETE FROM items WHERE item_id = '$itemIdToDelete'";
  $resultDelete = mysqli_query($conn, $sqlDelete);

  if ($resultDelete) {
    // Query successful, update the total item count in the session
    session_start();
    $sqlCountItems = "SELECT COUNT(*) AS total_items FROM items";
    $resultCountItems = mysqli_query($conn, $sqlCountItems);
    $data = mysqli_fetch_assoc($resultCountItems);
    $_SESSION['total_items'] = $data['total_items'];
  }
}

// Fetch all items from the 'items' table
$sql = "SELECT * FROM items";
$result = mysqli_query($conn, $sql);

// Function to get the button class based on the status
function getButtonClass($status) {
  return ($status === 'Active') ? 'active' : 'inactive';
}

// Get the total number of items
$totalItems = mysqli_num_rows($result);

// Start a PHP session (if not already started)
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

// Store the total items count in the session variable
$_SESSION['total_items'] = $totalItems;
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Items</title>
  <link rel="stylesheet" href="style.css">

  <script>
  function deleteItem(itemId) {
    if (confirm('Are you sure you want to delete this item?')) {
      // Redirect back to the items page after deleting
      window.location.href = 'http://localhost/Kumara%20Stores%20Inventory_system/Items/index.php?delete=' + itemId;
    }
  }
</script>

</head>
<body>
  <div class="header">
    <div class="rectangle"></div>
</div>
<div class="content">
  <!-- "Manage Items" and "Home > Items" texts -->
  <div class="texts">
    <div class="manage-items-text">Manage Items</div>
    <div class="breadcrumb-text">Home &gt; Items</div>
  </div>


  <div>
  <!-- Add Items Button -->
  <a href="http://localhost/Kumara%20Stores%20Inventory_system/Add_Items/">
  <button class="add-items-button">
    <span class="button-text">Add Items</span>
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
  <input type="text" id="searchInput" placeholder="Search Item">
</div>

<script>
  function searchItems() {
    // Get the search input value
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.querySelector(".item-table");
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

  
  document.getElementById("searchInput").addEventListener("input", searchItems);
</script>

<!-- Table -->
<table class="item-table" style="transform: translateY(40px);">
  <thead>
    <tr>
      <th style="width: 33%;">Item</th>
      <th class="status-column" style="width: 33%;">Status</th>
      <th style="width: 33%;">Action</th>
    </tr>
  </thead>
  <tbody>
  <?php
    // Inside the while loop for fetching data from the database
while ($row = mysqli_fetch_assoc($result)) {
  $itemId = $row['item_id'];
  $itemName = $row['item'];
  $status = $row['status'];

  // Determine the button class based on the status value
  $buttonClass = ($status === 'active') ? 'active' : 'inactive';
  $buttonText = ucfirst($status); 

  ?>


    <tr>
      <td><?php echo $itemName; ?></td>
      <td class="status-column">
      <input type="button" class="status-button <?php echo ($status === 'active') ? 'active' : 'inactive'; ?>" value="<?php echo ucfirst($status); ?>" disabled>
        </div>
      </td>
      <td>
      <a href="http://localhost/Kumara%20Stores%20Inventory_system/Add_Items/?edit=<?php echo $itemId; ?>">
        <button class="edit-button">
          <img class="button-icon" src="https://www.freeiconspng.com/thumbs/edit-icon-png/edit-editor-pen-pencil-write-icon--4.png" alt="Edit">
          </button>
        </a>

        <button class="delete-button" onclick="deleteItem(<?php echo $itemId; ?>)">
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
    <li><img src="https://www.nicepng.com/png/full/204-2049036_download-3-cube-icon.png" alt="Items"><a href="">Items</a></li>
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