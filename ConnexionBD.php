<?php
$host = 'localhost'; // Assuming your MySQL server is on the same machine
$dbname = 'projet';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // You can set additional PDO attributes or perform other setup if needed
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}

?>