<?php

include 'components/connect.php';

if(isset($_GET['order_id'])){
    $order_id = $_GET['order_id'];

    // Check if the order belongs to the current user
    $check_order = $conn->prepare("SELECT * FROM `orders` WHERE id = ?");
    $check_order->execute([$order_id]);

    if($check_order->rowCount() > 0){
        // Order belongs to the user, delete it
        $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
        $delete_order->execute([$order_id]);

        if($delete_order){
            // Order deleted successfully
            header('Location: indexOrder.php'); // Redirect to the order list page
            exit();
        } else {
            // Failed to delete order
            echo 'Failed to delete the order.';
        }
    } else {
        // Order does not belong to the user
        echo 'Invalid order or you do not have permission to delete it.';
    }
} else {
    // Invalid order ID
    echo 'Invalid order ID.';
}

?>
