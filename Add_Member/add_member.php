<?php
//database connection script
include "db_connect.php";

// Function to Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $permission = $_POST["permission"];
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $gender = $_POST["gender"];

    // Validate the data 
    if (empty($name) || empty($email) || empty($password)) {
        
        echo "Please fill in all required fields.";
    } else {
        // Prepare and execute the SQL INSERT statement
        $sql = "INSERT INTO users (permission, name, phone, email, password, gender)
                VALUES ('$permission', '$name', '$phone', '$email', '$password', '$gender')";

        if (mysqli_query($conn, $sql)) {
            // Redirect to a success page or display a success message
            header("Location: index.php"); 
            exit();
        } else {
            // Handle the SQL error
            echo "Error: " . mysqli_error($conn);
        }
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
