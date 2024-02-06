<?php


session_start();

// Retrieve the totalSum from the session
if (isset($_SESSION['totalSum'])) {
    $totalSum = $_SESSION['totalSum'];
} else {
    
    die("Total sum not found.");
}

$amount = $totalSum;
$merchant_id = 1224258;
$order_id = uniqid();
$merchant_secret = "Mjc0NDgxNjg2MjkxNDYzNDY0MzM5MTkzNzM2MDg3OTkwOTk4Mzc=";
$currency = "LKR";

$hash = strtoupper(
    md5(
        $merchant_id . 
        $order_id . 
        number_format($amount, 2, '.', '') . 
        $currency .  
        strtoupper(md5($merchant_secret)) 
    ) 
);

$array = [];

$array["items"] = "Order Payment";
$array["first_name"] = "Thamindu";
$array["last_name"] = "Perera";
$array["email"] = "thaminduperera14@gmail.com";
$array["phone"] = "0719061811";
$array["address"] = "no 34, Deniyaya Road,Rakwana";
$array["city"] = "Rathnapura";

$array["amount"] = $amount;
$array["merchant_id"] = $merchant_id;
$array["order_id"] = $order_id;
$array["amount"] = $amount;
$array["currency"] = $currency;
$array["hash"] = $hash;


$jsonObj = json_encode($array);


echo $jsonObj;


?>