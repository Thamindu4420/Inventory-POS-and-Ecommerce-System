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
$item_name = "";
$status = "";
$item_id = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the form data
  $item_name = $_POST["item_name"];
  $status = $_POST["status"];
  $item_id = $_POST["item_id"];

  if (!empty($item_id)) {
      // Update the existing item in the 'items' table
      $sqlUpdateItem = "UPDATE items SET item = ?, status = ? WHERE item_id = ?";
      $stmtUpdateItem = mysqli_prepare($conn, $sqlUpdateItem);

      if ($stmtUpdateItem) {
          mysqli_stmt_bind_param($stmtUpdateItem, "ssi", $item_name, $status, $item_id);
          mysqli_stmt_execute($stmtUpdateItem);

          header('Location: http://localhost/Kumara%20Stores%20Inventory_system/Items/index.php');
          exit();
      }
  } else {
      // Save the new item to the 'items' table
      $sqlInsertItem = "INSERT INTO items (item, status) VALUES (?, ?)";
      $stmtInsertItem = mysqli_prepare($conn, $sqlInsertItem);

      if ($stmtInsertItem) {
          mysqli_stmt_bind_param($stmtInsertItem, "ss", $item_name, $status);
          mysqli_stmt_execute($stmtInsertItem);

          header('Location: http://localhost/Kumara%20Stores%20Inventory_system/Items/index.php');
          exit();
      }
  }
}

// Check if editing an item
if (isset($_GET['edit'])) {
    $itemId = $_GET['edit'];

    $sqlFetchItem = "SELECT item, status FROM items WHERE item_id = ?";
    $stmtFetchItem = mysqli_prepare($conn, $sqlFetchItem);

    if ($stmtFetchItem) {
        mysqli_stmt_bind_param($stmtFetchItem, "i", $itemId);
        mysqli_stmt_execute($stmtFetchItem);

        mysqli_stmt_bind_result($stmtFetchItem, $itemName, $status);

        if (mysqli_stmt_fetch($stmtFetchItem)) {
            $item_name = $itemName;
            $item_id = $itemId;
        }

        mysqli_stmt_close($stmtFetchItem);
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Items</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="add-items-form">

    <!-- Close icon -->
    <a href="http://localhost/Kumara%20Stores%20Inventory_system/Items/index.php">
    <div class="close-icon">&#215;</div>
  </a>
  <form action="index.php" method="post">
  <input type="hidden" name="item_id" value="<?php echo $item_id; ?>">
    <div class="form-heading">Add Item</div>
    <div class="form-section">
      <div class="form-label">Item Name</div>
      <input type="text" class="form-textbox" name="item_name" placeholder="Enter item name" value="<?php echo $item_name; ?>">
    </div>
    <div class="form-section">
    <div class="form-label">Status</div>
        <select class="form-dropdown" name="status" id="statusDropdown">
          <option value="active" <?php echo ($status == 'active') ? 'selected' : ''; ?>>Active</option>
          <option value="inactive" <?php echo ($status == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
  </select>
</div>
    <a href="http://localhost/Kumara%20Stores%20Inventory_system/Items/index.php">
    <div class="form-buttons">
      <button type="button" class="close-button">Close
      </button>
</a>
      <button type="submit" class="save-button">Save Changes</button>
      </form>
    </div>
    </div>
</body>
</html>