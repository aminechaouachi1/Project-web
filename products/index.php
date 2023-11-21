<?php
include 'connection.php';

$stmt = $conn->prepare("SELECT * FROM products");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Product List</title>
    
    
</head>
<body>
    <h2>Product List</h2>
    <table>
        <tr>
            <th>Product ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Image</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= $product['product_id'] ?></td>
                <td><?= $product['name'] ?></td>
                <td><?= $product['price'] ?></td>
                <td class="image"><?= $product['image'] ?></td>
                <td class="description"><?= $product['description'] ?></td>
                <td>
                    <a href="edit.php?id=<?= $product['product_id'] ?>">Edit</a>
                    <a href="delete.php?id=<?= $product['product_id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="add.php" class="add-product-link">Add Product</a>
    <a href="http://localhost/projetpi/View/Page%20boutique/Boutique.php"class="add-product-link" >Back to Store</a>
</body>
</html>

