<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = $_POST["email"];
    $password = $_POST["password"];

    $host = "localhost:3306";
    $database = "kumara_stores_inventory"; 
    $username = "root"; 
    $password_db = ""; 

    // Connect to the database
    $conn = new mysqli($host, $username, $password_db, $database);


    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to check if user exists in the database
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    // If a row is found, it means the login is successful
    if ($result->num_rows > 0) {
        // Redirect to the dashboard page
        echo '<script>window.location.href = "http://localhost/Kumara%20Stores%20Inventory_system/Ecommerce_Admin_Dashboard/";</script>';
        exit();
    } else {
        // Handle invalid login
        echo '<script>alert("Invalid login credentials. Please try again.");</script>';
        echo '<script>window.location.href = "http://localhost/Kumara%20Stores%20Inventory_system/Ecommerce_Admin_login/";</script>';
    }

    // Close the database connection
    $conn->close();
}
?>
