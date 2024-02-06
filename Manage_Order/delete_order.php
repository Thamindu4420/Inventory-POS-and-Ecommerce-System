<?php
include "db_connect.php";

// Function to Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to Check if the order_id parameter is set in the POST request
if (isset($_POST['order_id'])) {
    $orderId = $_POST['order_id'];

    // Construct and execute the DELETE query
    $sql = "DELETE FROM orders WHERE order_id = '$orderId'";
    if (mysqli_query($conn, $sql)) {
        // Deletion was successful
        echo "success";
    } else {
        // Deletion failed
        echo "error";
    }
} else {
    // If order_id parameter is not set, return an error
    echo "error";
}

// Close the database connection
mysqli_close($conn);
?>
