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

if(isset($_POST['edit'])){

   $id = $_POST['id'];
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
      $edit_product = $conn->prepare("UPDATE `products` SET name=?, price=?, image=?, type_id=? WHERE id=?");
      $edit_product->execute([$name, $price, $rename, $type_id, $id]);
      move_uploaded_file($image_tmp_name, $image_folder);
      $success_msg[] = 'Product updated!';
   }
}

if(isset($_GET['id'])){
   $id = $_GET['id'];
   $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
   $select_product->execute([$id]);
   $fetch_product = $select_product->fetch(PDO::FETCH_ASSOC);
}else{
   header('location: indexProduct.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Edit Product</title>
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
<?php include 'components/header.php'; ?>

<section class="product-form">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>Edit Product</h3>
      <input type="hidden" name="id" value="<?= $fetch_product['id']; ?>">
      <p>Product Name <span>*</span></p>
      <input type="text" name="name" placeholder="Enter product name" required maxlength="50" class="box" value="<?= $fetch_product['name']; ?>">
      <p>Product Price <span>*</span></p>
      <input type="number" name="price" placeholder="Enter product price" required min="0" max="9999999999" maxlength="10" class="box" value="<?= $fetch_product['price']; ?>">
      <p>Product Type <span>*</span></p>
      <select name="type_id" class="box" required>
         <?php foreach ($types as $type): ?>
            <option value="<?= $type['id']; ?>" <?= $type['id'] == $fetch_product['type_id'] ? 'selected' : ''; ?>>
               <?= $type['name']; ?>
            </option>
         <?php endforeach; ?>
      </select>
      <p>Product Image <span>*</span></p>
      <input type="file" name="image" accept="image/*" class="box">
      <input type="submit" class="btn" name="edit" value="Edit Product">
   </form>

</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="js/script.js"></script>
<?php include 'components/alert.php'; ?>

</body>
</html>
