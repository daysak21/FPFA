<?php
include('../includes/connect.php');
include('../functions/common_functions.php');
session_start();

// Vérifier si l'admin est déjà connecté
if(isset($_SESSION['admin_username'])){
    echo "<script>window.open('index.php','_self');</script>";
}

// Traitement de la connexion
if(isset($_POST['admin_login'])){
    $admin_username = $_POST['username'];
    $admin_password = $_POST['password'];
    
    $select_query = "SELECT * FROM `admin_table` WHERE admin_name='$admin_username'";
    $result = mysqli_query($con, $select_query);
    $row_count = mysqli_num_rows($result);
    $row_data = mysqli_fetch_assoc($result);
    
    if($row_count > 0 && password_verify($admin_password, $row_data['admin_password'])){
        $_SESSION['admin_username'] = $admin_username;
        echo "<script>alert('Login successful')</script>";
        echo "<script>window.open('index.php','_self')</script>";
    } else {
        echo "<script>alert('Invalid credentials')</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce Admin Login</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="../assets/css/bootstrap.css" />
    <link rel="stylesheet" href="../assets/css/main.css" />
</head>

<body>

    <div class="landing admin-register">
        <div class="">
            <h2 class="text-center mb-1">Admin Login</h2>
            <h4 class="text-center mb-3 fw-light">Login to your account</h4>
            <div class="row m-0 align-items-center">
                <div class="col-md-6 p-0 d-none d-md-block">
                    <img src="../assets/images/bgregister.png" class="admin-register" alt="Login photo">
                </div>
                <div class="col-md-6 py-4 px-5 d-flex flex-column gap-4">
                    <div>
                        <form action="" method="post" class="d-flex flex-column gap-4">
                            <div class="form-outline">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Enter your username" required>
                            </div>
                            <div class="form-outline">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your Password" required>
                            </div>
                            <div class="form-outline">
                                <a href="" class="text-2 text-decoration-underline">Forgot your passowrd?</a>
                            </div>
                            <div class="form-outline">
                                <input type="submit" value="Login" class="btn btn-primary mb-3" name="admin_login">
                                <p class="small">
                                Want to register  as admin ? <a href="../contactus.php" class="text-decoration-underline text-success fw-bold"> Contact us !</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
  

    <script src="../assets/js/bootstrap.bundle.js"></script>
</body>

</html>