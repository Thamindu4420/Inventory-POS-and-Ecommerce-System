<?php

session_start();

// Function to Check if the product_name, product_price, and quantity are set in the POST data
if (isset($_POST['product_name'], $_POST['product_price'], $_POST['quantity'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $quantity = $_POST['quantity'];

    // Create a new cart item
    $cart_item = [
        'product_name' => $product_name,
        'product_price' => $product_price,
        'quantity' => $quantity,
    ];

    // Add the cart item to the cart session array
    $_SESSION['cart'][] = $cart_item;

    // Redirect the user to the cart page
    header("Location: http://localhost/Kumara%20Stores%20Inventory_system/Ecommerce_Customer_Cart/");
    exit();
} else {
    // Handle the case where the required POST data is missing
    echo "Invalid request. Please provide product details.";
}


?>
