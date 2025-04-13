<?php
include('../includes/connect.php');
include('../functions/common_functions.php');
session_start();

// Vérifier si l'admin est connecté
if(!isset($_SESSION['admin_username'])){
    echo "<script>window.open('./admin_login.php','_self');</script>";
    exit();
}

// Si le formulaire est soumis
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $user_email = mysqli_real_escape_string($con, $_POST['user_email']);
    $user_password = mysqli_real_escape_string($con, $_POST['user_password']);
    $user_mobile = mysqli_real_escape_string($con, $_POST['user_mobile']);
    
    // Vérifier si l'email existe déjà
    $check_query = "SELECT * FROM `user_table` WHERE user_email = '$user_email'";
    $check_result = mysqli_query($con, $check_query);
    
    if(mysqli_num_rows($check_result) > 0){
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: 'Cet email est déjà utilisé',
            });
        </script>";
    } else {
        // Hasher le mot de passe
        $hash_password = password_hash($user_password, PASSWORD_DEFAULT);
        
        // Insérer le nouvel utilisateur
        $insert_query = "INSERT INTO `user_table` (username, user_email, user_password, user_mobile, user_ip) 
                        VALUES ('$username', '$user_email', '$hash_password', '$user_mobile', '')";
        $insert_result = mysqli_query($con, $insert_query);
        
        if($insert_result){
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Succès',
                    text: 'Utilisateur ajouté avec succès',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.open('index.php?list_users','_self');
                });
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: 'Échec de l\'ajout de l\'utilisateur',
                });
            </script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New User</title>

    <!-- Link to your custom CSS -->
    <link rel="stylesheet" href="styleadmin.css">

    <!-- Optional: Bootstrap CDN for better form design -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="add-user-form-container mt-5">
        <h2 class="text-center mb-4">Add a New User</h2>
        <form action="" method="post" class="w-50 m-auto">
            <div class="form-outline mb-4">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>

            <div class="form-outline mb-4">
                <label for="user_email" class="form-label">Email</label>
                <input type="email" id="user_email" name="user_email" class="form-control" required>
            </div>

            <div class="form-outline mb-4">
                <label for="user_password" class="form-label">Password</label>
                <input type="password" id="user_password" name="user_password" class="form-control" required>
            </div>

            <div class="form-outline mb-4">
                <label for="user_mobile" class="form-label">Phone Number</label>
                <input type="text" id="user_mobile" name="user_mobile" class="form-control" required>
            </div>

            <div class="text-center">
                <input type="submit" value="Add User" class="btn btn-primary px-4 me-2 mb-2">
                <a href="index.php?list_users" class="btn btn-secondary px-4 mb-2">Cancel</a>
            </div>
        </form>
    </div>

</body>
</html>
