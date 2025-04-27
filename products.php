<?php
include("includes/connect.php");
include("functions/common_functions.php");
include("functions/recommendation_functions.php"); // Inclure nos fonctions de recommandation
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
    <style>
        .sidebar {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 30px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .sidebar-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #495057;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e9ecef;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-title i {
            color: #28a745;
        }

        .category-list, .brand-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .category-item, .brand-item {
            margin-bottom: 10px;
        }

        .category-link, .brand-link {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: #495057;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .category-link:hover, .brand-link:hover {
            background: #e9ecef;
            color: #28a745;
            transform: translateX(5px);
        }

        .category-link i, .brand-link i {
            margin-right: 10px;
            color: #28a745;
            font-size: 1.1rem;
        }

        .category-count, .brand-count {
            margin-left: auto;
            background: #28a745;
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.8rem;
        }

        .category-link:hover .category-count,
        .brand-link:hover .brand-count {
            background: #218838;
        }

        .active-filter {
            background: #28a745 !important;
            color: white !important;
        }

        .active-filter i {
            color: white !important;
        }

        .active-filter .category-count,
        .active-filter .brand-count {
            background: white;
            color: #28a745;
        }

        @media (max-width: 768px) {
            .sidebar {
                margin-bottom: 20px;
            }
        }
    </style>
</head>

<body>
   <?php require "navbar.php" ;?>
   <div class="container py-4">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                <!-- Categories -->
                <div class="sidebar">
                    <h3 class="sidebar-title">
                        <i class="fas fa-th-list"></i>
                        Categories
                    </h3>
                    <ul class="category-list">
                        <?php
                        $select_categories = "SELECT * FROM `categories`";
                        $result_categories = mysqli_query($con, $select_categories);
                        while($row_data = mysqli_fetch_assoc($result_categories)) {
                            $category_id = $row_data['category_id'];
                            $category_title = $row_data['category_title'];
                            
                            // Count products in category
                            $count_query = "SELECT COUNT(*) as count FROM `products` WHERE category_id = $category_id";
                            $count_result = mysqli_query($con, $count_query);
                            $count_row = mysqli_fetch_assoc($count_result);
                            $product_count = $count_row['count'];
                            
                            // Check if category is currently selected
                            $active_class = (isset($_GET['category']) && $_GET['category'] == $category_id) ? 'active-filter' : '';
                            
                            echo "<li class='category-item'>
                                    <a href='products.php?category=$category_id' class='category-link $active_class'>
                                        <i class='fas fa-angle-right'></i>
                                        $category_title
                                        <span class='category-count'>$product_count</span>
                                    </a>
                                  </li>";
                        }
                        ?>
                    </ul>
                </div>

                <!-- Brands -->
                <div class="sidebar">
                    <h3 class="sidebar-title">
                        <i class="fas fa-tags"></i>
                        Brands
                    </h3>
                    <ul class="brand-list">
                        <?php
                        $select_brands = "SELECT * FROM `brands`";
                        $result_brands = mysqli_query($con, $select_brands);
                        while($row_data = mysqli_fetch_assoc($result_brands)) {
                            $brand_id = $row_data['brand_id'];
                            $brand_title = $row_data['brand_title'];
                            
                            // Count products in brand
                            $count_query = "SELECT COUNT(*) as count FROM `products` WHERE brand_id = $brand_id";
                            $count_result = mysqli_query($con, $count_query);
                            $count_row = mysqli_fetch_assoc($count_result);
                            $product_count = $count_row['count'];
                            
                            // Check if brand is currently selected
                            $active_class = (isset($_GET['brand']) && $_GET['brand'] == $brand_id) ? 'active-filter' : '';
                            
                            echo "<li class='brand-item'>
                                    <a href='products.php?brand=$brand_id' class='brand-link $active_class'>
                                        <i class='fas fa-tag'></i>
                                        $brand_title
                                        <span class='brand-count'>$product_count</span>
                                    </a>
                                  </li>";
                        }
                        ?>
                    </ul>
                </div>
            </div>

            <!-- Products -->
            <div class="col-md-9">
                <div class="row">
                    <?php
                    if(!isset($_GET['category']) && !isset($_GET['brand'])) {
                        getProduct(9); // Affiche tous les produits
                    } else if(isset($_GET['category'])) {
                        filterCategoryProduct(); // Affiche les produits par catégorie
                    } else if(isset($_GET['brand'])) {
                        filterBrandProduct(); // Affiche les produits par marque
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>


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

    <!-- Start Products  -->
    <div class="products">
        <div class="container">
            <div class="categ-header">
                <div class="sub-title">
                    <span class="title">Produits Recommandés</span>
                </div>
                <h2>Vous pourriez aussi aimer</h2>
            </div>
            <div class="row mb-3">
                <?php
                if(isset($_GET['product_id'])) {
                    $product_id = $_GET['product_id'];
                    
                    // Utiliser notre fonction de recommandation
                    $found_recommendations = getRecommendedProducts($product_id, 3);
                    
                    // Si aucune recommandation n'est trouvée, utiliser la méthode existante
                    if($found_recommendations == 0) {
                        getProduct();
                    }
                } else {
                    // Fallback sur la méthode existante
                    getProduct(8);
                }
                
                cart();
                ?>
            </div>
            <div class="view d-flex justify-content-center align-items-center">
                <button onclick="location.href='./products.php'">View More Products</button>
            </div>
        </div>
    </div>
    <!-- End Products  -->

    <script src="assets//js/bootstrap.bundle.js"></script>
    <script src="assets//js/script.js"></script>
    <?php require "footer.php" ;?>
</body>

</html>