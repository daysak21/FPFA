<?php
// Fonction pour obtenir les produits recommandés pour un produit spécifique
function getRecommendedProducts($product_id, $limit = 4) {
    global $con;
    
    // Récupérer les IDs des produits recommandés depuis la base de données
    $select_recommendations = "SELECT recommended_products FROM product_recommendations WHERE product_id = $product_id";
    $result_recommendations = mysqli_query($con, $select_recommendations);
    
    if (mysqli_num_rows($result_recommendations) > 0) {
        $row = mysqli_fetch_assoc($result_recommendations);
        $recommended_ids = json_decode($row['recommended_products'], true);
        
        // Limiter le nombre de recommandations
        $recommended_ids = array_slice($recommended_ids, 0, $limit);
        
        if (!empty($recommended_ids)) {
            // Convertir le tableau d'IDs en chaîne pour la requête SQL
            $ids_string = implode(',', $recommended_ids);
            
            // Récupérer les détails des produits recommandés
            $select_products = "SELECT * FROM `products` WHERE product_id IN ($ids_string)";
            $result_products = mysqli_query($con, $select_products);
            
            $count = 0;
            while ($row = mysqli_fetch_assoc($result_products)) {
                $product_id = $row['product_id'];
                $product_title = $row['product_title'];
                $product_image1 = $row['product_image1'];
                $product_price = $row['product_price'];
                
                // Afficher le produit avec le style de recommandation
                echo "<div class='col-md-4 mb-2'>
                        <div class='recommendation-card'>
                            <img src='./admin/product_images/$product_image1' class='card-img-top recommendation-img' alt='$product_title'>
                            <div class='recommendation-body'>
                                <h5 class='recommendation-title'>$product_title</h5>
                                <p class='recommendation-price'>$product_price €</p>
                                <a href='product_details.php?product_id=$product_id' class='btn recommendation-btn'>Voir détails</a>
                                <a href='index.php?add_to_cart=$product_id' class='btn btn-primary recommendation-btn mt-2'>Ajouter au panier</a>
                            </div>
                        </div>
                    </div>";
                $count++;
            }
            
            return $count;
        }
    }
    
    return getSimilarProducts($product_id, $limit);
}

function getSimilarProducts($product_id, $limit = 4) {
    global $con;
    $select_current = "SELECT category_id, brand_id FROM `products` WHERE product_id = $product_id";
    $result_current = mysqli_query($con, $select_current);
    $row_current = mysqli_fetch_assoc($result_current);
    
    if (!$row_current) {
        return 0;
    }
    
    $category_id = $row_current['category_id'];
    $brand_id = $row_current['brand_id'];
 
    $select_query = "SELECT * FROM `products` WHERE product_id != $product_id 
                    AND (category_id = $category_id OR brand_id = $brand_id)
                    AND status = 'true'
                    ORDER BY RAND() LIMIT $limit";
    
    $result_query = mysqli_query($con, $select_query);
    
    $count = 0;
    while ($row = mysqli_fetch_assoc($result_query)) {
        $product_id = $row['product_id'];
        $product_title = $row['product_title'];
        $product_image1 = $row['product_image1'];
        $product_price = $row['product_price'];

        echo "<div class='col-md-4 mb-2'>
                <div class='recommendation-card'>
                    <img src='./admin/product_images/$product_image1' class='card-img-top recommendation-img' alt='$product_title'>
                    <div class='recommendation-body'>
                        <h5 class='recommendation-title'>$product_title</h5>
                        <p class='recommendation-price'>$product_price €</p>
                        <a href='product_details.php?product_id=$product_id' class='btn recommendation-btn'>Voir détails</a>
                        <a href='index.php?add_to_cart=$product_id' class='btn btn-primary recommendation-btn mt-2'>Ajouter au panier</a>
                    </div>
                </div>
            </div>";
        $count++;
    }
    
    return $count;
}

function trackRecommendationClick($product_id, $recommended_product_id) {
    global $con;
    

    if(isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $insert_query = "INSERT INTO recommendation_clicks (user_id, product_id, recommended_product_id, click_time) 
                        VALUES ($user_id, $product_id, $recommended_product_id, NOW())";
        mysqli_query($con, $insert_query);
    }
}
?>