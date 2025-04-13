<?php
include('../includes/connect.php');
include('../functions/common_functions.php');
session_start();

// Vérifier si l'admin est connecté
if(!isset($_SESSION['admin_username'])){
    echo "<script>window.open('./admin_login.php','_self');</script>";
    exit();
}

if(isset($_GET['delete_user'])){
    $delete_id = $_GET['delete_user'];
    
    // Vérifier d'abord si l'utilisateur existe
    $check_query = "SELECT * FROM `user_table` WHERE user_id = $delete_id";
    $check_result = mysqli_query($con, $check_query);
    $user_exists = mysqli_num_rows($check_result) > 0;
    
    if($user_exists){
        // Supprimer les commandes associées à l'utilisateur d'abord
        $delete_orders = "DELETE FROM `user_orders` WHERE user_id = $delete_id";
        mysqli_query($con, $delete_orders);
        
        // Supprimer les paiements associés
        $delete_payments = "DELETE FROM `user_payments` WHERE user_id = $delete_id";
        mysqli_query($con, $delete_payments);
        
        // Enfin supprimer l'utilisateur
        $delete_query = "DELETE FROM `user_table` WHERE user_id = $delete_id";
        $delete_result = mysqli_query($con, $delete_query);
        
        if($delete_result){
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Succès',
                    text: 'Utilisateur supprimé avec succès',
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
                    text: 'Échec de la suppression de l\'utilisateur',
                });
            </script>";
        }
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: 'Utilisateur non trouvé',
            }).then(() => {
                window.open('index.php?list_users','_self');
            });
        </script>";
    }
}
?>