<?php
include('../includes/connect.php');
    if(isset($_GET['delete_user'])){
        $delete_id = mysqli_real_escape_string($con, $_GET['delete_user']);
        
        // First check if user exists
        $check_query = "SELECT * FROM `user_table` WHERE user_id = '$delete_id'";
        $check_result = mysqli_query($con, $check_query);
        
        if(mysqli_num_rows($check_result) > 0) {
            $delete_query = "DELETE FROM `user_table` WHERE user_id = '$delete_id'";
            $delete_result = mysqli_query($con, $delete_query);
            
            if($delete_result){
                echo "<script>alert('User deleted successfully');</script>";
                echo "<script>window.open('index.php?list_users','_self');</script>";
            } else {
                echo "<script>alert('Error deleting user: " . mysqli_error($con) . "');</script>";
                echo "<script>window.open('index.php?list_users','_self');</script>";
            }
        } else {
            echo "<script>alert('User not found');</script>";
            echo "<script>window.open('index.php?list_users','_self');</script>";
        }
    }
?>