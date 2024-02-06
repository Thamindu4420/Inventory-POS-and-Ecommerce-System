<?php
include "db_connect.php"; // Include your database connection script

// Check if the connection is successful
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Fetch product names from the "products" table
$query = "SELECT product_name FROM products WHERE availability = 'active'";
$result = mysqli_query($conn, $query);

if (!$result) {
  die("Error fetching product names: " . mysqli_error($conn));
}

$productNames = array();
while ($row = mysqli_fetch_assoc($result)) {
  $productNames[] = $row['product_name'];
}

// Encode product names as JSON and send them as the response
echo json_encode($productNames);

// Close the database connection
mysqli_close($conn);
?>
