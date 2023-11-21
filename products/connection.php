<?php
$host = 'localhost'; 
$dbname = 'project_pi'; //nom de db
$username = 'root';
$password = ''; //no password

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}

?>
