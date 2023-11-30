<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   setcookie('user_id', create_unique_id(), time() + 60*60*24*30);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/header.php'; ?>

<section class="orders">
    <h1 class="heading">My Orders</h1>

    <div class="container">
    <table class="table table-striped table-dark">
  <thead>
                <tr> 
                   
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            <?php
                $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ? ORDER BY date DESC");
                $select_orders->execute([$user_id]);
                if($select_orders->rowCount() > 0){
                    while($fetch_order = $select_orders->fetch(PDO::FETCH_ASSOC)){
                        $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                        $select_product->execute([$fetch_order['product_id']]);
                        if($select_product->rowCount() > 0){
                            while($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)){
            ?>
                <tr <?php if($fetch_order['status'] == 'canceled'){echo 'style="border:.2rem solid red";';}; ?>>
                   
                    <td><?= $fetch_product['name']; ?></td>
                    <td><?= $fetch_order['price']; ?></td>
                    <td><?= $fetch_order['qty']; ?></td>
                    <td style="color:<?php if($fetch_order['status'] == 'delivered'){echo 'green';}elseif($fetch_order['status'] == 'canceled'){echo 'red';}else{echo 'orange';}; ?>">
                        <?= $fetch_order['status']; ?>
                    </td>
                    <td>
                        <a href="delete_order.php?order_id=<?= $fetch_order['id']; ?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            <?php
                            }
                        }
                    }
                } else {
                    echo '<tr><td colspan="6">No orders found!</td></tr>';
                }
            ?>

            </tbody>
        </table>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="js/script.js"></script>
<?php include 'components/alert.php'; ?>

</body>
</html>
