<?php
include "db_connect.php";

// Function to Check if the connection is successful
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

 // Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Check if an image file is uploaded
  if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
      // Get the image data
      $image = file_get_contents($_FILES["image"]["tmp_name"]);
  }
}

// Initialize variables to store form data
$product_id = "";
$product_name = "";
$price = "";
$quantity = "";
$description = "";
$element_value = "";
$category = "";
$warehouse = "";
$availability = "";

// Check if a 'product_id' query parameter is present
if (isset($_GET['edit'])) {
    $product_id = $_GET['edit'];

    // Fetch the product data from the database based on the product_id
    $sqlFetchProduct = "SELECT * FROM products WHERE product_id = ?";
    $stmtFetchProduct = mysqli_prepare($conn, $sqlFetchProduct);

    if ($stmtFetchProduct) {
        mysqli_stmt_bind_param($stmtFetchProduct, "i", $product_id);
        mysqli_stmt_execute($stmtFetchProduct);

        $result = mysqli_stmt_get_result($stmtFetchProduct);

        if ($row = mysqli_fetch_assoc($result)) {
            // Populate the form fields with the fetched data
            $product_name = $row['product_name'];
            $price = $row['price'];
            $quantity = $row['quantity'];
            $description = $row['description'];
            $element_value = $row['element_value'];
            $category = $row['category'];
            $warehouse = $row['warehouse'];
            $availability = $row['availability'];
        }

        mysqli_stmt_close($stmtFetchProduct);
    }
}

// Form processing logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $_POST["product_name"];
    $price = $_POST["price"];
    $quantity = $_POST["quantity"];
    $description = $_POST["description"];
    $element_value = $_POST["element"];
    $category = $_POST["category"];
    $warehouse = $_POST["warehouse"];
    $availability = $_POST["availability"];

    if (!empty($product_id)) {
        // Update the existing product in the database
        $sqlUpdateProduct = "UPDATE products SET image = ?, product_name = ?, price = ?, quantity = ?, description = ?, element_value = ?, category = ?, warehouse = ?, availability = ? WHERE product_id = ?";
        $stmtUpdateProduct = mysqli_prepare($conn, $sqlUpdateProduct);

        if ($stmtUpdateProduct) {
            mysqli_stmt_bind_param($stmtUpdateProduct, "sssdsssssi", $image, $product_name, $price, $quantity, $description, $element_value, $category, $warehouse, $availability, $product_id);
            mysqli_stmt_execute($stmtUpdateProduct);

            // Redirect the user back to the Manage Products page
            header('Location: http://localhost/Kumara%20Stores%20Inventory_system/Manage_Product/');
            exit();
        }
    } else {
        // Insert a new product into the database
        $sqlInsertProduct = "INSERT INTO products (image, product_name, price, quantity, description, element_value, category, warehouse, availability) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtInsertProduct = mysqli_prepare($conn, $sqlInsertProduct);

        if ($stmtInsertProduct) {
            mysqli_stmt_bind_param($stmtInsertProduct, "sssdsssss", $image,  $product_name, $price, $quantity, $description, $element_value, $category, $warehouse, $availability);
            mysqli_stmt_execute($stmtInsertProduct);

            // Redirect the user back to the Manage Products page
            header('Location: http://localhost/Kumara%20Stores%20Inventory_system/Manage_Product/');
            exit();
        }
    }
    

    // Redirect the user back to the Manage Products page with query parameters
$redirectUrl = 'http://localhost/Kumara%20Stores%20Inventory_system/Manage_Product/';

// Append query parameters for product details, e.g., '?imageData=' . urlencode($imageData)
$redirectUrl .= '?imageData=' . urlencode(base64_encode($imageData));

header('Location: ' . $redirectUrl);
exit();
}


// Fetch elements from the element_value table
$sqlFetchElements = "SELECT elements_value FROM element_value";
$resultElements = mysqli_query($conn, $sqlFetchElements);

if (!$resultElements) {
    die("Error fetching elements: " . mysqli_error($conn));
}

$elements = array();
while ($row = mysqli_fetch_assoc($resultElements)) {
    $elements[] = $row['elements_value'];
}

// Fetch categories from the category table
$sqlFetchCategories = "SELECT category FROM category";
$resultCategories = mysqli_query($conn, $sqlFetchCategories);

if (!$resultCategories) {
    die("Error fetching categories: " . mysqli_error($conn));
}

$categories = array();
while ($row = mysqli_fetch_assoc($resultCategories)) {
    $categories[] = $row['category'];
}

// Fetch warehouses from the warehouse table
$sqlFetchWarehouses = "SELECT warehouse FROM warehouse";
$resultWarehouses = mysqli_query($conn, $sqlFetchWarehouses);

if (!$resultWarehouses) {
    die("Error fetching warehouses: " . mysqli_error($conn));
}

$warehouses = array();
while ($row = mysqli_fetch_assoc($resultWarehouses)) {
    $warehouses[] = $row['warehouse'];
}

$elementsJSON = json_encode($elements);
$categoriesJSON = json_encode($categories);
$warehousesJSON = json_encode($warehouses);


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
<div class="header">
    <div class="rectangle"></div>
</div>
<div class="content">

  <!-- "Add New Product" and "Home > Products" texts -->
  <div class="texts">
    <div class="add-new-product-text">Add New Product</div>
    <div class="breadcrumb-text">Home &gt; Product</div>
  </div>

  <div hr class="heading-line">
  </div>

  <div class="add-product-form">
  <form action="index.php<?php if (!empty($product_id)) echo '?edit=' . $product_id; ?>" method="post" enctype="multipart/form-data">
  <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
  <div class="image-section">
  <label for="image-upload" class="image-label">Image</label>
  <div class="image-preview">
    <input type="file" id="image-upload" accept="image/*" name="image" onchange="displayImage(this)" style="display: none;">
    <label for="image-upload" class="image-circle">
      <img id="image-preview" src=" " alt="Image Preview">
    </label>
  </div>

  <div class="product-name-section">
    <label for="product-name" class="product-name-label">Product Name</label>
    <input type="text" id="product-name" name="product_name" class="product-name-input" placeholder="Enter product name" value="<?php echo $product_name; ?>">
  </div>

  <div class="price-section">
    <label for="price" class="price-label">Price</label>
    <input type="text" id="price" name="price" class="price-input" placeholder="Enter price" value="<?php echo $price; ?>" >
  </div>

  <div class="quantity-section">
    <label for="quantity" class="quantity-label">Quantity</label>
    <input type="text" id="quantity" name="quantity" class="quantity-input" placeholder="Enter Quantity" value="<?php echo $quantity; ?>" >
  </div>

  <div class="description-section">
    <label for="description" class="description-label">Description</label>
    <input type="text" id="description" name="description" class="description-input" placeholder="Enter description" value="<?php echo $description; ?>" >
  </div>

  <!-- Element Dropdown -->
<div class="form-section">
  <div class="element-label">Element</div>
  <select class="element-dropdown" name="element" id="element-dropdown">
    
  </select>
</div>

<!-- Category Dropdown -->
<div class="form-section">
  <div class="category-label">Category</div>
  <select class="category-dropdown" name="category" id="category-dropdown">
    
  </select>
</div>


<!-- Warehouse Dropdown -->
<div class="form-section">
  <div class="warehouse-label">Warehouse</div>
  <select class="warehouse-dropdown" name="warehouse" id="warehouse-dropdown">
    
  </select>
</div>


<div class="form-section">
  <div class="availability-label">Availability</div>
  <select class="availability-dropdown" name="availability" id="statusDropdown">
    <option value="active"> Active</option>
    <option value="inactive">Inactive</option>
  </select>
</div>


<div class="button-container">
  <button type="submit" class="save-button"><?php echo (!empty($product_id)) ? 'Save Changes' : 'Save'; ?></button>
  <a href="http://localhost/Kumara%20Stores%20Inventory_system/Manage_Product/">
  <button type="button" class="back-button">Back</button>
  </a>
</div>
</form>
</div>


<!-- JavaScript to populate the dropdowns -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    var elements = <?php echo $elementsJSON; ?>;
    var categories = <?php echo $categoriesJSON; ?>;
    var warehouses = <?php echo $warehousesJSON; ?>;
    
    // Function to populate a dropdown
    function populateDropdown(data, dropdownId) {
      var dropdown = document.getElementById(dropdownId);

      data.forEach(function (item) {
        var option = document.createElement("option");
        option.value = item;
        option.text = item; 
        dropdown.appendChild(option);
      });
    }
      
    // Call the function to populate the dropdowns
    populateDropdown(elements, "element-dropdown");
    populateDropdown(categories, "category-dropdown");
    populateDropdown(warehouses, "warehouse-dropdown");
    });
  

</script>



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
        <li><span class="icon"><img src="https://cdn-icons-png.flaticon.com/512/7613/7613915.png" alt="Add Products"></span><a href="#">Add Products</a></li>
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

<!--Messagebox-->
<div id="toast-message" class="hidden">
    
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

    // Call the function to disable zooming
    disableZoom();
  </script>

<script>
    function showToast(message) {
        const toastMessage = document.getElementById('toast-message');

        // Set the message text
        toastMessage.textContent = message;

        // Show the toast message
        toastMessage.classList.remove('hidden');

        // Automatically hide the toast message after a few seconds
        setTimeout(function () {
            toastMessage.classList.add('hidden');
        }, 3000); // 3000 milliseconds (3 seconds)
    }
</script>


</body>
</html>