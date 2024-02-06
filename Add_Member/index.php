<?php
include "db_connect.php";

// Function to Check if the connection is successful
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$email = "";
$name = "";
$password = "";
$gender = "";
$phone = "";
$permission = "";
$userId = "";

// Function to Check if a user ID is provided in the query parameter
if (isset($_GET["id"])) {
  $userId = mysqli_real_escape_string($conn, $_GET["id"]);

  // Retrieve user data from the database
  $sql = "SELECT * FROM users WHERE user_id = '$userId'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) === 1) {
    // Fetch the user's data
    $userData = mysqli_fetch_assoc($result);

    // Populate form fields with user data
    $email = $userData["email"];
    $name = $userData["name"];
    $password = $userData["password"];
    $gender = $userData["gender"];
    $phone = $userData["phone"];
    $permission = $userData["permission"];
  } else {
    
    echo "User not found";
    
  }
}

if (isset($_POST["save"])) {
  // Check if a user ID is provided in the POST data
  if (isset($_POST["user_id"])) {
    $userId = mysqli_real_escape_string($conn, $_POST["user_id"]);
  }

  // Update or insert the user data based on the presence of user_id
  if (!empty($userId)) {
    // Perform an UPDATE query to update the user's data
    $updateSql = "UPDATE users SET email = '$email', name = '$name', gender = '$gender', password = '$password', phone = '$phone', permission = '$permission' WHERE user_id = '$userId'";

    if (mysqli_query($conn, $updateSql)) {
      // Update successful
      echo "Update successful";
    } else {
      // Update failed
      echo "Update failed: " . mysqli_error($conn);
    }
  } else {
    
    // Perform an INSERT query to add the new user to the database
    $insertSql = "INSERT INTO users (email, name, gender, password, phone, permission) VALUES ('$email', '$name', '$gender', '$password', '$phone', '$permission')";

    if (mysqli_query($conn, $insertSql)) {
      // Insert successful
      echo "Insert successful";
    } else {
      // Insert failed
      echo "Insert failed: " . mysqli_error($conn);
    }
  }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Members</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
<div class="header">
    <div class="rectangle"></div>
</div>
<div class="content">

  <!-- "Add New Order" and "Home > Orders" texts -->
  <div class="texts">
    <div class="add-new-member-text">Add New Member</div>
    <div class="breadcrumb-text">Home &gt; Members</div>
  </div>

  <div hr class="heading-line">
  </div>

  <!-- Add Member Form -->

  <form class="add-member-form"  method="POST" action="add_member.php">


  <input type="hidden" name="user_id" value="<?php echo $userId; ?>">



  <div class="permission-dropdown" value="<?php echo $permission; ?>">
        <label for="permission-select">Permission</label>
        <select id="permission-select" name="permission">
        <option value="Admin">Admin</option>
        <option value="Employee">Employee</option>
        </select>
      </div>

      <div class="name">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" placeholder="Enter Member Name" value="<?php echo $name; ?>" />
      </div>

      <div class="phone">
        <label for="phone">Phone</label>
        <input type="text" id="phone" name="phone" placeholder="Enter Phone Number" value="<?php echo $phone; ?>" />
      </div>

      <div class="email">
        <label for="email">Email</label>
        <input type="text" id="email" name="email" placeholder="Enter Email" value="<?php echo $email; ?>" />
      </div>

      <div class="password">
        <label for="password">Password</label>
        <input type="text" id="password" name="password" placeholder="Enter Password" value="<?php echo $password; ?>" />
      </div>

      <div class="gender-dropdown" value="<?php echo $gender; ?>">
        <label for="gender-select">Gender</label>
        <select id="gender-select" name="gender">
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        </select>
      </div>

      <div class="form-buttons">
      <button type="submit" class="save-button" name="save">Save</button>

      <a href="http://localhost/Kumara%20Stores%20Inventory_system/Manage_Member/">
    <button type="button" class="back-button" >Back
      </button>
  </a>
   
  </form>
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