<?php

include('../includes/connect.php');


if(isset($_POST['update_order_status'])){
    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];
    
  
    $update_query = "UPDATE `user_orders` SET order_status='$new_status' WHERE order_id = $order_id";
    $update_result = mysqli_query($con, $update_query);
    
    if($update_result){
        echo "<script>window.alert('Order status updated successfully');</script>";
        echo "<script>window.location.href='index.php?list_orders';</script>";
    } else {
        echo "<script>window.alert('Error updating order status');</script>";
        echo "<script>window.location.href='index.php?list_orders';</script>";
    }
}


if(!isset($_POST['update_order_status'])) {
    header("Location: index.php?list_orders");
    exit();
}
?>