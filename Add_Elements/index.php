<?php
// Database connection file
$host = "localhost:3306";
$username = "root";
$password = "";
$database = "kumara_stores_inventory";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize variables to store form data
$element_name = "";
$status = "";
$element_id = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $element_name = $_POST["element_name"];
  $status = $_POST["status"];
  $element_id = $_POST["element_id"];

  if (!empty($element_id)) {
      // Update the existing element in the 'elements' table
      $sqlUpdateElement = "UPDATE elements SET element = ?, status = ? WHERE element_id = ?";
      $stmtUpdateElement = mysqli_prepare($conn, $sqlUpdateElement);

      if ($stmtUpdateElement) {
          mysqli_stmt_bind_param($stmtUpdateElement, "ssi", $element_name, $status, $element_id);
          mysqli_stmt_execute($stmtUpdateElement);

          header('Location: http://localhost/Kumara%20Stores%20Inventory_system/Elements/');
          exit();
      }
  } else {
      // Save the new element to the 'elements' table
      $sqlInsertElement = "INSERT INTO elements (element, status) VALUES (?, ?)";
      $stmtInsertElement = mysqli_prepare($conn, $sqlInsertElement);

      if ($stmtInsertElement) {
          mysqli_stmt_bind_param($stmtInsertElement, "ss", $element_name, $status);
          mysqli_stmt_execute($stmtInsertElement);

          header('Location: http://localhost/Kumara%20Stores%20Inventory_system/Elements/');
          exit();
      }
  }
}

if (isset($_GET['element_id'])) {
  $elementId = $_GET['element_id'];

  $sqlFetchElement = "SELECT element, status FROM elements WHERE element_id = ?";
  $stmtFetchElement = mysqli_prepare($conn, $sqlFetchElement);

  if ($stmtFetchElement) {
      mysqli_stmt_bind_param($stmtFetchElement, "i", $elementId);
      mysqli_stmt_execute($stmtFetchElement);

      mysqli_stmt_bind_result($stmtFetchElement, $elementName, $status);

      if (mysqli_stmt_fetch($stmtFetchElement)) {
          $element_name = $elementName;
          $element_id = $elementId;
      }

      mysqli_stmt_close($stmtFetchElement);
  }
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Elements</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="add-elements-form">

    <!-- Close icon -->
    <a href="http://localhost/Kumara%20Stores%20Inventory_system/Elements/">
    <div class="close-icon">&#215;</div>
  </a>
  <form action="index.php" method="post">
  <input type="hidden" name="element_id" value="<?php echo $element_id; ?>">
    <div class="form-heading">Add Elements</div>
    <div class="form-section">
      <div class="form-label">Element Name</div>
      <input type="text" class="form-textbox" name="element_name" placeholder="Enter element name" value="<?php echo $element_name; ?>">
    </div>
    <div class="form-section">
      <div class="form-label">Status</div>
      <select class="form-dropdown" name="status" id="statusDropdown">
      <option value="active" <?php if ($status == 'active') echo 'selected'; ?>>Active</option>
      <option value="inactive" <?php if ($status == 'inactive') echo 'selected'; ?>>Inactive</option>
      </select>
    </div>
    <a href="http://localhost/Kumara%20Stores%20Inventory_system/Elements/">
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