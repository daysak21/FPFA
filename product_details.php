<?php
include("includes/connect.php");
include("functions/common_functions.php");
include("functions/recommendation_functions.php"); // Inclusion des fonctions de recommandation
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce Products</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="stylesheet" href="assets/css/product_details.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>

<body>
   <?php require "navbar.php" ;?>


    <!-- Start Product details  -->
    <div class="prod-details">
        <div class="container">
            <div class="sub-container pt-4 pb-4">

                <?php
                viewDetails();
                ?>
            </div>
        </div>
    </div>
    <!-- End Product details  -->

    <!-- Start Recommended Products  -->
    <div class="products">
        <div class="container">
            <div class="categ-header">
                <div class="sub-title">
                    <span class="shape"></span>
                    <span class="title">Produits Recommandés</span>
                </div>
                <h2>Vous pourriez aussi aimer</h2>
            </div>
            <div class="row mb-3">
                <?php
                if(isset($_GET['product_id'])) {
                    $product_id = $_GET['product_id'];
                    
                    // Utiliser notre fonction de recommandation
                    $found_recommendations = getRecommendedProducts($product_id, 4);
                    
                    // Si aucune recommandation n'est trouvée, utiliser la méthode existante
                    
                } 
                
                cart();
                ?>
            </div>
            <div class="view d-flex justify-content-center align-items-center">
                <button onclick="location.href='./products.php'">View More Products</button>
            </div>
        </div>
    </div>
    <!-- End Recommended Products  -->
    
    <script src="assets/js/bootstrap.bundle.js"></script>
    <script src="assets/js/script.js"></script>
    <?php require "footer.php" ;?>
</body>

</html>
