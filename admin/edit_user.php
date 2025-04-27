<?php
include('../includes/connect.php');
include('../functions/common_functions.php');
session_start();

if (!isset($_GET['user_id'])) {
    echo "<script>alert('User ID not specified')</script>";
    echo "<script>window.open('index.php?view_users','_self')</script>";
    exit();
}

$user_id = $_GET['user_id'];

$select_query = "SELECT * FROM user_table WHERE user_id='$user_id'";
$result_query = mysqli_query($con, $select_query);
$row_fetch = mysqli_fetch_assoc($result_query);

if (!$row_fetch) {
    echo "<script>alert('User not found')</script>";
    echo "<script>window.open('index.php?view_users','_self')</script>";
    exit();
}


if (isset($_POST['update_user'])) {
    $username = $_POST['username'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
    $user_address = $_POST['user_address'];
    $user_mobile = $_POST['user_mobile'];
    
    $check_email = "SELECT * FROM user_table WHERE user_email='$user_email' AND user_id!='$user_id'";
    $result_check = mysqli_query($con, $check_email);
    
    if (mysqli_num_rows($result_check) > 0) {
        echo "<script>alert('This email is already used by another user')</script>";
    } else {
        $update_query = "UPDATE user_table SET 
            username='$username',
            user_email='$user_email',
            user_password='$user_password',
            user_address='$user_address',
            user_mobile='$user_mobile'
            WHERE user_id='$user_id'";
            
        $result_update = mysqli_query($con, $update_query);
        
        if ($result_update) {
            echo "<script>alert('User updated successfully')</script>";
            echo "<script>window.open('index.php?view_users','_self')</script>";
        } else {
            echo "<script>alert('Error updating user')</script>";
        }
    }
}
?>
