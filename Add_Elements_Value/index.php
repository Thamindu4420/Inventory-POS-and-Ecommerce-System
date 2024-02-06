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
$elements_value = "";
$element_value_id = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

// Get the form data
$elements_value = $_POST["elements_value"];
$element_value_id = $_POST["element_value_id"];

if (empty($element_value_id)) {
  // New element value, insert it
  $sqlInsertElements_Value = "INSERT INTO element_value (elements_value) VALUES (?)";
  $stmtInsertElements_Value = mysqli_prepare($conn, $sqlInsertElements_Value);

  if ($stmtInsertElements_Value) {
    mysqli_stmt_bind_param($stmtInsertElements_Value, "s", $elements_value);
    mysqli_stmt_execute($stmtInsertElements_Value);
    header('Location: http://localhost/Kumara%20Stores%20Inventory_system/Add_Value/');
    exit();
  } else {
    echo "Error: " . mysqli_error($conn);
  }
} else {
  // Existing element value, update it
  $sqlUpdateElements_Value = "UPDATE element_value SET elements_value = ? WHERE element_value_id = ?";
  $stmtUpdateElements_Value = mysqli_prepare($conn, $sqlUpdateElements_Value);

  if ($stmtUpdateElements_Value) {
    mysqli_stmt_bind_param($stmtUpdateElements_Value, "si", $elements_value, $element_value_id);
    mysqli_stmt_execute($stmtUpdateElements_Value);
    header('Location: http://localhost/Kumara%20Stores%20Inventory_system/Add_Value/');
    exit();
  } else {
    echo "Error: " . mysqli_error($conn);
  }
}
}


// Function to Check if the "edit" query parameter is set
if (isset($_GET['edit'])) {
  
  $element_value_id = $_GET['id'];
  $elements_value = urldecode($_GET['edit']);
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Elements Value</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="add-elements-value-form">

    <!-- Close icon -->
    <a href="http://localhost/Kumara%20Stores%20Inventory_system/Add_Value/">
    <div class="close-icon">&#215;</div>
  </a>
  <input type="hidden" name="element_value_id" value="<?php echo $element_value_id; ?>">
    <div class="form-heading">Add Elements Value</div>
    <form action="index.php" method="post">
    <div class="form-section">
      <div class="form-label">Elements Value</div>
      <input type="text" class="form-textbox" name="elements_value" placeholder="Enter element value" value="<?php echo $elements_value; ?>">
    </div>
    <a href="http://localhost/Kumara%20Stores%20Inventory_system/Add_Value/">
    <div class="form-buttons">
    <button type="button" class="close-button">Close
      </button>
</a>
    <button type="submit" class="save-button">Save Changes</button>
    <input type="hidden" name="element_value_id" value="<?php echo $element_value_id; ?>">
    </form>
    </div>
  </div>
</body>
</html>