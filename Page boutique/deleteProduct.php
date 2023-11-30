<?php

include 'components/connect.php';

if(isset($_GET['id'])){
   $id = $_GET['id'];
   $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
   $delete_product->execute([$id]);
   header('location: indexProduct.php');
}else{
   header('location: indexProduct.php');
}

?>
