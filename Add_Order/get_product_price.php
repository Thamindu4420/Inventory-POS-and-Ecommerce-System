<?php
include "db_connect.php";

if (isset($_POST['product'])) {
    $selectedProduct = $_POST['product'];

    // Fetch the price from the database
    $query = "SELECT price FROM products WHERE product_name = '$selectedProduct'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $price = $row['price'];

        // Return the price as JSON
        echo json_encode(['price' => $price]);
    } else {
        echo json_encode(['price' => 'Not found']);
    }
} else {
    echo json_encode(['price' => 'Invalid request']);
}

mysqli_close($conn);
?>





