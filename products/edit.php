<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = :product_id");
    $stmt->bindParam(':product_id', $product_id);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        echo 'Product not found.';
        die();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $name = $_POST['name'];     
    $price = $_POST['price'];
    $image = $_POST['image']; 
    $description = $_POST['description'];

    $stmt = $conn->prepare("UPDATE products SET name = :name, price = :price, image = :image, description = :description WHERE product_id = :product_id");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':product_id', $product_id);
    $stmt->execute();

    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Edit Product</title>
  
    
</head>
<body>
    <h2>Edit Product</h2>
    <form method="post" action="">
        <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">

        <label for="name">Product Name:</label>
        <input type="text" name="name" value="<?= $product['name'] ?>" required>

        <label for="price">Price:</label>
        <input type="number" name="price" step="0.01" value="<?= $product['price'] ?>" required>

        <label for="image">Image URL:</label>
        <input type="text" name="image" value="<?= $product['image'] ?>" required>

        <label for="description">Description:</label>
        <textarea name="description" rows="4" required><?= $product['description'] ?></textarea>

        <input type="submit" value="Save Changes">
    </form>
    <a href="index.php" class="add-product-link">Back to Product List</a>
</body>
</html>

