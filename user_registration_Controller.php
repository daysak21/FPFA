<?php
include('includes/connect.php');
include('functions/common_functions.php');
session_start();

if (isset($_POST['user_register'])) {
    $user_username = $_POST['user_username'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
    $hash_password = password_hash($user_password, PASSWORD_DEFAULT);
    $conf_user_password = $_POST['conf_user_password'];
    $user_address = $_POST['user_address'];
    $user_contact = $_POST['user_contact'];
    $user_ip = getIPAddress();
    
    // Select query
    $select_query = "SELECT * FROM `user_table` WHERE username='$user_username' OR user_email='$user_email'";
    $select_result = mysqli_query($con, $select_query);
    $rows_count = mysqli_num_rows($select_result);
    
    if ($rows_count > 0) {
        echo "<script>alert('Username or Email already exists')</script>";
        echo "<script>window.open('user_registration.php','_self')</script>";
    } else if ($user_password != $conf_user_password) {
        echo "<script>alert('Passwords do not match')</script>";
        echo "<script>window.open('user_registration.php','_self')</script>";
    } else {
        // Insert query
        $insert_query = "INSERT INTO `user_table` (username,user_email,user_password,user_ip,user_address,user_mobile) 
                        VALUES ('$user_username','$user_email','$hash_password','$user_ip','$user_address','$user_contact')";
        $sql_execute = mysqli_query($con, $insert_query);
        
        if ($sql_execute) {
            // Selecting cart items
            $select_cart_items = "SELECT * FROM `card_details` WHERE ip_address='$user_ip'";
            $result_cart = mysqli_query($con, $select_cart_items);
            $rows_count = mysqli_num_rows($result_cart);
            
            if ($rows_count > 0) {
                $_SESSION['username'] = $user_username;
                echo "<script>alert('Registration Successful. You have items in your cart')</script>";
                echo "<script>window.open('checkout.php','_self')</script>";
            } else {
                echo "<script>alert('Registration Successful')</script>";
                echo "<script>window.open('index.php','_self')</script>";
            }
        } else {
            die(mysqli_error($con));
        }
    }
}
else {
    // Redirect if accessed directly without form submission
    header("Location: user_registration.php");
    exit();
}
?>
