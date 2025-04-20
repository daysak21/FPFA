<?php
include('includes/connect.php');
include('functions/common_functions.php');
session_start();
if (isset($_POST['user_login'])) {
    $user_username = $_POST['user_username'];
    $user_password = $_POST['user_password'];
    $select_query = "SELECT * FROM `user_table` WHERE username='$user_username'";
    $select_result = mysqli_query($con, $select_query);
    $row_data = mysqli_fetch_assoc($select_result);
    $row_count = mysqli_num_rows($select_result);
    $user_ip = getIPAddress();
    //check if user have items |! -> redirect to payment | index 
    $select_cart_query = "SELECT * FROM `card_details` WHERE ip_address='$user_ip'";
    $select_cart_result = mysqli_query($con, $select_cart_query);
    $row_cart_count = mysqli_num_rows($select_cart_result);
    //user check about username & pass
    if ($row_count > 0) {
        if (password_verify($user_password, $row_data['user_password'])) {
            // echo "<script>alert('Login Successfully')</script>";
            $_SESSION['username'] = $user_username;
            if ($row_count == 1 && $row_cart_count == 0) {
                $_SESSION['username'] = $user_username;
                echo "<script>alert('Login Successfully');</script>";
                echo "<script>window.open('profile.php','_self');</script>";
            } else if ($row_count == 1 && $row_cart_count > 0) {
                $_SESSION['username'] = $user_username;
                echo "<script>alert('Login Successfully');</script>";
                echo "<script>window.open('index.php','_self');</script>";
            }
        } else {
            echo "<script>alert('Invalid Credentials')</script>";
        }
    } else {
        echo "<script>alert('Invalid Credentials')</script>";
    }
}
?>