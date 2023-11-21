<?php
include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM products WHERE product_id = :product_id");
    $stmt->bindParam(':product_id', $product_id);
    $stmt->execute();

    header('Location: index.php'); //redirection vers index.php 
    exit();
} else {
    echo 'Invalid request.';
    die();
}
?>
