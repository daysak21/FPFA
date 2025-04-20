<?php
include('../includes/connect.php');
include('../functions/common_functions.php');
session_start();

if (isset($_POST['admin_login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $select_query = "SELECT * FROM `admin_table` WHERE admin_name='$username'";
    $select_result = mysqli_query($con, $select_query);
    $row_data = mysqli_fetch_assoc($select_result);
    $row_count = mysqli_num_rows($select_result);
    //user check about username & pass
    if ($row_count > 0) {
        if (password_verify($password, $row_data['admin_password'])) {
            $_SESSION['admin_username'] = $username;
            echo "<script>alert('Login Successfully');</script>";
            echo "<script>window.open('./index.php','_self');</script>";
        } else {
            echo "<script>alert('Invalid Credentials')</script>";
        }
    } else {
        echo "<script>alert('Username does not exist')</script>";
    }
}
?>