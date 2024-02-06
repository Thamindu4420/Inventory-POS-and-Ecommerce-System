<?php
include "db_connect.php";

// Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get product name and quantity from the POST request
    $productName = $_POST["product_name"];
    $quantity = $_POST["quantity"];

    // Update the product quantity in the database
    $updateQuery = "UPDATE products SET quantity = quantity - $quantity WHERE product_name = '$productName'";
    
    if (mysqli_query($conn, $updateQuery)) {
        echo "Quantity updated successfully";
    } else {
        echo "Error updating quantity: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>

