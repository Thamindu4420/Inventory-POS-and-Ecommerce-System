<?php
// Include the database connection file
$host = "localhost:3306";
$username = "root";
$password = "";
$database = "kumara_stores_inventory";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize variables to store form data
$category_name = "";
$status = "";
$category_id = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the form data
  $category_name = $_POST["category_name"];
  $status = $_POST["status"];
  $category_id = $_POST["category_id"];

  if (!empty($category_id)) {
      // Update the existing category in the 'category' table
      $sqlUpdateCategory = "UPDATE category SET category = ?, status = ? WHERE category_id = ?";
      $stmtUpdateCategory = mysqli_prepare($conn, $sqlUpdateCategory);

      if ($stmtUpdateCategory) {
          mysqli_stmt_bind_param($stmtUpdateCategory, "ssi", $category_name, $status, $category_id);
          mysqli_stmt_execute($stmtUpdateCategory);

          header('Location: http://localhost/Kumara%20Stores%20Inventory_system/Category/');
          exit();
      }
  } else {
      // Save the new category to the 'category' table
      $sqlInsertCategory = "INSERT INTO category (category, status) VALUES (?, ?)";
      $stmtInsertCategory = mysqli_prepare($conn, $sqlInsertCategory);

      if ($stmtInsertCategory) {
          mysqli_stmt_bind_param($stmtInsertCategory, "ss", $category_name, $status);
          mysqli_stmt_execute($stmtInsertCategory);

          header('Location: http://localhost/Kumara%20Stores%20Inventory_system/Category/');
          exit();
      }
  }
}

if (isset($_GET['edit'])) {
  $categoryId = $_GET['edit'];

  $sqlFetchCategory = "SELECT category, status FROM category WHERE category_id = ?";
  $stmtFetchCategory = mysqli_prepare($conn, $sqlFetchCategory);

  if ($stmtFetchCategory) {
      mysqli_stmt_bind_param($stmtFetchCategory, "i", $categoryId);
      mysqli_stmt_execute($stmtFetchCategory);

      mysqli_stmt_bind_result($stmtFetchCategory, $categoryName, $status);

      if (mysqli_stmt_fetch($stmtFetchCategory)) {
          $category_name = $categoryName;
          $category_id = $categoryId;
      }

      mysqli_stmt_close($stmtFetchCategory);
  }
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Category</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="add-category-form">

    <!-- Close icon -->
    <a href="http://localhost/Kumara%20Stores%20Inventory_system/Category/">
    <div class="close-icon">&#215;</div>
  </a>
  <form action="index.php" method="post">
    <input type="hidden" name="category_id" value="<?php echo $category_id; ?>">
    <div class="form-heading">Add Category</div>
    <div class="form-section">
      <div class="form-label">Category Name</div>
      <input type="text" class="form-textbox" name="category_name" placeholder="Enter category name" value="<?php echo $category_name; ?>">
    </div>
    <div class="form-section">
    <div class="form-label">Status</div>
      <select class="form-dropdown" name="status" id="statusDropdown">
      <option value="active" <?php if ($status == 'active') echo 'selected'; ?>>Active</option>
      <option value="inactive" <?php if ($status == 'inactive') echo 'selected'; ?>>Inactive</option>
      </select>
    </div>
    <a href="http://localhost/Kumara%20Stores%20Inventory_system/Category/">
    <div class="form-buttons">
      <button type="button" class="close-button" >Close
      </button>
</a>
      <button type="submit" class="save-button" >Save Changes</button>
    </form>
    </div>
  </div>
</body>
</html>