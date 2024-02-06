<?php
include "db_connect.php";

// Function to Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['complaint_id'])) {
    $complaintId = $_POST['complaint_id'];

    // SQL query to delete the complaint by complaint_id
    $sql = "DELETE FROM complaints WHERE complaint_id = $complaintId";

    if (mysqli_query($conn, $sql)) {
        echo 'success'; 
    } else {
        echo 'error';
    }
}

// Close the database connection
$conn->close();
?>
