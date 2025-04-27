<?php
include('../includes/connect.php');
include('../functions/common_functions.php');
session_start();

if (isset($_POST['admin_login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $con->prepare("SELECT * FROM admin_table WHERE admin_name = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row_data = $result->fetch_assoc();

        if (password_verify($password, $row_data['admin_password'])) {
            $_SESSION['admin_username'] = $username;
            echo "<script>alert('Login Successfully');</script>";
            echo "<script>window.open('./index.php','_self');</script>";
        } else {
            echo "<script>alert('Invalid Credentials');</script>";
        }
    } else {
        echo "<script>alert('Username does not exist');</script>";
    }

    $stmt->close();
}
?>
