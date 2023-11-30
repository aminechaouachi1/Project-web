<?php

include 'components/connect.php';

function create_unique_id(){
   $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
   $charactersLength = strlen($characters);
   $randomString = '';
   for ($i = 0; $i < 20; $i++) {
       $randomString .= $characters[mt_rand(0, $charactersLength - 1)];
   }
   return $randomString;
}

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   setcookie('user_id', create_unique_id(), time() + 60*60*24*30);
}

// Fetch types from the database
$types_query = $conn->query("SELECT * FROM `types`");
$types = $types_query->fetchAll(PDO::FETCH_ASSOC);

if(isset($_POST['add'])){

   $id = create_unique_id();
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $type_id = $_POST['type_id']; // Newly added

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $ext = pathinfo($image, PATHINFO_EXTENSION);
   $rename = create_unique_id().'.'.$ext;
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_size = $_FILES['image']['size'];
   $image_folder = 'uploaded_files/'.$rename;

   if($image_size > 2000000){
      $warning_msg[] = 'Image size is too large!';
   }else{
      $add_product = $conn->prepare("INSERT INTO `products`(id, name, price, image, type_id) VALUES(?,?,?,?,?)");
      $add_product->execute([$id, $name, $price, $rename, $type_id]);
      move_uploaded_file($image_tmp_name, $image_folder);
      $success_msg[] = 'Product added!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Products</title>
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
<?php include 'components/header.php'; ?>

</section>

<section class="products">
   <h1 class="heading">Product List</h1>

   <div class="container">
   <table class="table table-striped table-dark">
         <thead>
            <tr>
               <th>ID</th>
               <th>Name</th>
               <th>Price</th>
               <th>Type</th>
               <th>Image</th>
               <th>Action</th>
            </tr>
         </thead>
         <tbody>
            <?php
               $select_products = $conn->query("SELECT * FROM `products`");
               $products = $select_products->fetchAll(PDO::FETCH_ASSOC);
               foreach ($products as $product):
                  $type_query = $conn->prepare("SELECT * FROM `types` WHERE id = ?");
                  $type_query->execute([$product['type_id']]);
                  $type = $type_query->fetch(PDO::FETCH_ASSOC);
            ?>
            <tr>
               <td><?= $product['id']; ?></td>
               <td><?= $product['name']; ?></td>
               <td><?= $product['price']; ?></td>
               <td><?= $type['name']; ?></td>
               <td>
               <img src="uploaded_files/<?= $product['image']; ?>" alt="<?= $product['name']; ?>" class="product-image" style="width: 200px; height: 150px;">
               </td>
               <td>
                  <a href="editProduct.php?id=<?= $product['id']; ?>" class="btn btn-primary">Edit</a>
                  <a href="deleteProduct.php?id=<?= $product['id']; ?>" class="btn btn-danger">Delete</a>
               </td>
            </tr>
            <?php endforeach; ?>
         </tbody>
      </table>
   </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="js/script.js"></script>
<?php include 'components/alert.php'; ?>

</body>
</html>
