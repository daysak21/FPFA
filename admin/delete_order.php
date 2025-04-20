<?php
if(isset($_GET['delete_order'])){
    $delete_id = $_GET['delete_order'];
    $delete_query = "DELETE FROM `user_orders` WHERE order_id = $delete_id";
    $delete_result = mysqli_query($con, $delete_query);
    if($delete_result){
        echo "<script>window.alert('Order deleted successfully');</script>";
        echo "<script>window.location.href='index.php?list_orders';</script>";
    }
}
if(!isset($_GET['delete_order'])) {
    header("Location: index.php?list_orders");
    exit();
}
?>