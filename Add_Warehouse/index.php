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
$warehouse_name = "";
$status = "";
$warehouse_id = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $warehouse_name = $_POST["warehouse_name"];
  $status = $_POST["status"];
  $warehouse_id = $_POST["warehouse_id"];

  if (!empty($warehouse_id)) {
      // Update the existing warehouse in the 'warehouse' table
      $sqlUpdateWarehouse = "UPDATE warehouse SET warehouse = ?, status = ? WHERE warehouse_id = ?";
      $stmtUpdateWarehouse = mysqli_prepare($conn, $sqlUpdateWarehouse);

      if ($stmtUpdateWarehouse) {
          mysqli_stmt_bind_param($stmtUpdateWarehouse, "ssi", $warehouse_name, $status, $warehouse_id);
          mysqli_stmt_execute($stmtUpdateWarehouse);

          header('Location: http://localhost/Kumara%20Stores%20Inventory_system/Warehouse/');
          exit();
      }
  } else {
      // Save the new warehouse to the 'warehouse' table
      $sqlInsertWarehouse = "INSERT INTO warehouse (warehouse, status) VALUES (?, ?)";
      $stmtInsertWarehouse = mysqli_prepare($conn, $sqlInsertWarehouse);

      if ($stmtInsertWarehouse) {
          mysqli_stmt_bind_param($stmtInsertWarehouse, "ss", $warehouse_name, $status);
          mysqli_stmt_execute($stmtInsertWarehouse);

          header('Location: http://localhost/Kumara%20Stores%20Inventory_system/Warehouse/');
          exit();
      }
  }
}

if (isset($_GET['edit'])) {
  $warehouseId = $_GET['edit'];

  $sqlFetchWarehouse = "SELECT warehouse, status FROM warehouse WHERE warehouse_id = ?";
  $stmtFetchWarehouse = mysqli_prepare($conn, $sqlFetchWarehouse);

  if ($stmtFetchWarehouse) {
      mysqli_stmt_bind_param($stmtFetchWarehouse, "i", $warehouseId);
      mysqli_stmt_execute($stmtFetchWarehouse);

      mysqli_stmt_bind_result($stmtFetchWarehouse, $warehouseName, $status);

      if (mysqli_stmt_fetch($stmtFetchWarehouse)) {
          $warehouse_name = $warehouseName;
          $warehouse_id = $warehouseId;
      }

      mysqli_stmt_close($stmtFetchWarehouse);
  }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Warehouse</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="add-warehouse-form">

    <!-- Close icon -->
    <a href="http://localhost/Kumara%20Stores%20Inventory_system/Warehouse/">
    <div class="close-icon">&#215;</div>
  </a>
  <form action="index.php" method="post">
  <input type="hidden" name="warehouse_id" value="<?php echo $warehouse_id; ?>">
    <div class="form-heading">Add Warehouse</div>
    <div class="form-section">
      <div class="form-label">Warehouse Name</div>
      <input type="text" class="form-textbox" name="warehouse_name" placeholder="Enter warehouse name" value="<?php echo $warehouse_name; ?>">
    </div>
    <div class="form-section">
      <div class="form-label">Status</div>
      <select class="form-dropdown" name="status" id="statusDropdown">
      <option value="active" <?php if ($status == 'active') echo 'selected'; ?>>Active</option>
      <option value="inactive" <?php if ($status == 'inactive') echo 'selected'; ?>>Inactive</option>
      </select>
    </div>
    <a href="http://localhost/Kumara%20Stores%20Inventory_system/Warehouse/">
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