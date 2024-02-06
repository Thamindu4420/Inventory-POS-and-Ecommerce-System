<?php
include "db_connect.php";

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$selectedProduct = $_POST['product'];

// Query to get the quantity of the selected product
$query = "SELECT quantity FROM products WHERE product_name = '$selectedProduct'";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo json_encode(['quantity' => 'Not found']);
} else {
    $row = mysqli_fetch_assoc($result);
    $quantity = $row['quantity'];
    echo json_encode(['quantity' => $quantity]);
}

mysqli_close($conn);
?>
