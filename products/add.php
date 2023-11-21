<?php
include 'connection.php'; //database connexion 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image']; 
    $description = $_POST['description']; 

    $stmt = $conn->prepare("INSERT INTO products (name, price, image, description) VALUES (:name, :price, :image, :description)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':description', $description);
    $stmt->execute();

    header('Location: index.php'); //redirection vers index.php
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" type="text/css" href="style.css">

    
</head>
<body>
    <h2>Add Product</h2>
    <form method="post" action="">
        <label for="name">Product Name:</label>
        <input type="text" name="name" required>

        <label for="price">Price:</label>
        <input type="number" name="price" step="0.01" required>

        <label for="image">Image URL:</label>
        <input type="text" name="image" required>

        <label for="description">Description:</label>
        <textarea name="description" rows="4" required></textarea>


        <input type="submit" value="Add Product">
    </form>
    <a href="index.php">Back to Product List</a>
</body>
</html>

