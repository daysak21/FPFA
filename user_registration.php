<?php
include('includes/connect.php');
include('functions/common_functions.php');
session_start();

if(isset($_SESSION['username'])) {
    header("Location: profile.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <?php require "navbar.php"; ?>

    <div class="auth-container">
        <div class="auth-form-container">
            <div class="auth-header">
                <h2>User Registration</h2>
                <p>Create your account to get started</p>
            </div>

            <form action="user_registration_Controller.php" method="post" class="auth-form">
                <div class="form-group">
                    <label class="form-label">Username</label>
                    <input type="text" name="user_username" class="form-control" required placeholder="Enter your username">
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="user_email" class="form-control" required placeholder="Enter your email">
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="user_password" class="form-control" required placeholder="Enter your password">
                </div>

                <div class="form-group">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="conf_user_password" class="form-control" required placeholder="Confirm your password">
                </div>

                <div class="form-group">
                    <label class="form-label">Address</label>
                    <input type="text" name="user_address" class="form-control" required placeholder="Enter your address">
                </div>

                <div class="form-group">
                    <label class="form-label">Contact</label>
                    <input type="text" name="user_contact" class="form-control" required placeholder="Enter your contact number">
                </div>

                <button type="submit" name="user_register" class="btn-submit">Register</button>
            </form>

            <div class="auth-footer">
                <p>Already have an account? <a href="user_login.php">Login here</a></p>
                <div class="social-links">
                    <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-google"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/bootstrap.bundle.js"></script>
    <script src="assets/js/home-animations.js"></script>
    <?php include('includes/chatbot.php'); ?>
    <?php require "footer.php"; ?>
</body>

</html>
