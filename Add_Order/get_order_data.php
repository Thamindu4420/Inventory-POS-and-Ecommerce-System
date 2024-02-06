<?php

include "db_connect.php";

// Function to Check if the connection is successful
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Initialize variables for form fields
$client = $_POST["clientName"];
$contact = $_POST["clientPhone"];
$netAmount = $_POST["netAmount"];
$paymentStatus = $_POST["paymentStatus"];

// Function to Check if the "edit" parameter is present in the URL
if (isset($_GET["edit"])) {
  $editOrderId = $_GET["edit"];
  
  // Perform an update operation
  $sql = "UPDATE orders SET client='$client', contact='$contact', net_amount='$netAmount', payment_status='$paymentStatus' WHERE order_id = $editOrderId";
  
  if (mysqli_query($conn, $sql)) {
    echo "Order updated successfully.";
  } else {
    echo "Error updating order: " . mysqli_error($conn);
  }
} else {
  
}

// Close the database connection
mysqli_close($conn);
?>
