<?php
$currency = 'TND'; //Currency Character or code

$db_username = 'root';
$db_password = '';
$db_name = 'chrif';
$db_host = 'localhost';

$shipping_cost = 1.50; //shipping cost
$taxes = array( //List your Taxes percent here.
    'VAT' => 12,
    'Service Tax' => 5
);

try {
    // Create a PDO instance
    $pdo = new PDO("mysql:host={$db_host};dbname={$db_name}", $db_username, $db_password);

    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Error : ' . $e->getMessage());
}
?>
