<?php

include "db_connect.php";

// Function to Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    
    // Retrieve data from the form
    $clientName = $_POST["clientName"];
    $clientPhone = $_POST["clientPhone"]; 
    $grossAmount = $_POST["grossAmount"];
    $discount = $_POST["discount"];
    $netAmount = $_POST["netAmount"];
    $paymentStatus = $_POST["paymentStatus"];

    // Insert order data into the 'orders' table
    $sql = "INSERT INTO orders (client, contact, gross_amount, discount, net_amount, payment_status) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Bind the parameters
        mysqli_stmt_bind_param($stmt, "ssssss", $clientName, $clientPhone, $grossAmount, $discount, $netAmount, $paymentStatus);

        // Execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Get the last inserted order ID
            $orderID = mysqli_insert_id($conn);
        

            echo "Order created successfully!";
        } else {
            // Handle error if the order creation fails
            echo "Error: " . mysqli_error($conn);
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // Handle error if the statement preparation fails
        echo "Error: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // Redirect back to the form page if the form is not submitted
    header("Location: index.php");
    exit();
}

?>

