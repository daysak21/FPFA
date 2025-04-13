<?php
include('../includes/connect.php');
include('../functions/common_functions.php');
session_start();

// Vérifier si l'admin est connecté
if(!isset($_SESSION['admin_username'])){
    echo "<script>window.open('./admin_login.php','_self');</script>";
    exit();
}

if(isset($_GET['edit_user'])){
    $user_id = $_GET['edit_user'];
    
    // Récupérer les données de l'utilisateur
    $select_query = "SELECT * FROM `user_table` WHERE user_id = $user_id";
    $result = mysqli_query($con, $select_query);
    $user_data = mysqli_fetch_assoc($result);
    
    // Si le formulaire est soumis
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = mysqli_real_escape_string($con, $_POST['username']);
        $user_email = mysqli_real_escape_string($con, $_POST['user_email']);
        $user_mobile = mysqli_real_escape_string($con, $_POST['user_mobile']);
        
        // Mettre à jour les données
        $update_query = "UPDATE `user_table` SET 
                        username = '$username',
                        user_email = '$user_email',
                        user_mobile = '$user_mobile'
                        WHERE user_id = $user_id";
        $update_result = mysqli_query($con, $update_query);
        
        if($update_result){
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Succès',
                    text: 'Utilisateur mis à jour avec succès',
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
                    text: 'Échec de la mise à jour',
                });
            </script>";
        }
    }
    ?>
    
    <div class="container mt-4">
        <h2 class="text-center mb-4">Modifier l'utilisateur</h2>
        <form action="" method="post" class="w-50 m-auto">
            <div class="form-outline mb-4">
                <label for="username" class="form-label">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" class="form-control" 
                       value="<?php echo $user_data['username']; ?>" required>
            </div>
            <div class="form-outline mb-4">
                <label for="user_email" class="form-label">Email</label>
                <input type="email" id="user_email" name="user_email" class="form-control" 
                       value="<?php echo $user_data['user_email']; ?>" required>
            </div>
            <div class="form-outline mb-4">
                <label for="user_mobile" class="form-label">Téléphone</label>
                <input type="text" id="user_mobile" name="user_mobile" class="form-control" 
                       value="<?php echo $user_data['user_mobile']; ?>" required>
            </div>
            <div class="text-center">
                <input type="submit" value="Mettre à jour" class="btn btn-primary px-3 mb-3">
                <a href="index.php?list_users" class="btn btn-secondary px-3 mb-3">Annuler</a>
            </div>
        </form>
    </div>
    <?php
}
?>