<?php
include('../includes/connect.php');
include('../functions/common_functions.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="styleadmin.css" rel="stylesheet">
</head>

<body class="login-page">
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <img src="../assets/images/bgregister.png" alt="Admin Logo">
                <h2>Admin Dashboard</h2>
                <p>Log in to access the admin panel</p>
            </div>
            <form action="admin_login_CON.php" method="post" class="login-form">
                <div class="form-group">
                    <input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                </div>
                <button type="submit" name="admin_login" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i>Log In
                </button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
