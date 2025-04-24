<?php
include('includes/connect.php');
include('functions/common_functions.php');
session_start();

if (isset($_POST['user_login'])) {
    $user_username = $_POST['user_username'];
    $user_password = $_POST['user_password'];

    // Prepare statement to prevent SQL injection
    $stmt = $con->prepare("SELECT * FROM user_table WHERE username = ?");
    $stmt->bind_param("s", $user_username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch user data
    if ($result->num_rows === 1) {
        $row_data = $result->fetch_assoc();

        // Verify password
        if (password_verify($user_password, $row_data['user_password'])) {
            $_SESSION['username'] = $user_username;

            // Check for items in cart
            $user_ip = getIPAddress();
            $stmt_cart = $con->prepare("SELECT COUNT(*) FROM card_details WHERE ip_address = ?");
            $stmt_cart->bind_param("s", $user_ip);
            $stmt_cart->execute();
            $stmt_cart->bind_result($row_cart_count);
            $stmt_cart->fetch();

            echo "<script>alert('Login Successfully');</script>";

            if ($row_cart_count > 0) {
                echo "<script>window.open('index.php','_self');</script>";
            } else {
                echo "<script>window.open('profile.php','_self');</script>";
            }

            $stmt_cart->close();
        } else {
            echo "<script>alert('Invalid Credentials');</script>";
        }
    } else {
        echo "<script>alert('Invalid Credentials');</script>";
    }

    $stmt->close();
}
?>
