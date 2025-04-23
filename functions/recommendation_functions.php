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
                $product_image1 = $row['product_image_one'];
                $product_price = $row['product_price'];
                
                // Afficher le produit avec le style de recommandation
                echo "
                <div class='one-card'>
                    <div class='photo'>
                        <img src='./admin/product_images/$product_image1' class='card-img-top recommendation-img' alt='$product_title'>
                        <button>
                            <a class='text-light' href='products.php?add_to_cart=$product_id'>Add To Cart</a>
                        </button>
                        <button>
                            <a class='text-light' href='product_details.php?product_id=$product_id'>View More</a>
                        </button>
                    </div>
                    <div class='content'>
                        <span class='title fw-bold'>$product_title</span>
                        <div class='desc'>
                            <span>$product_price DT</span>
                            <span>
                                <svg width='16' height='15' viewBox='0 0 16 15' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                    <path d='M14.673 7.17173C15.7437 6.36184 15.1709 4.65517 13.8284 4.65517H11.3992C10.7853 4.65517 10.243 4.25521 10.0617 3.66868L9.33754 1.32637C8.9309 0.0110567 7.0691 0.0110564 6.66246 1.32637L5.93832 3.66868C5.75699 4.25521 5.21469 4.65517 4.60078 4.65517H2.12961C0.791419 4.65517 0.215919 6.35274 1.27822 7.16654L3.39469 8.78792C3.85885 9.1435 4.05314 9.75008 3.88196 10.3092L3.11296 12.8207C2.71416 14.1232 4.22167 15.1704 5.30301 14.342L7.14861 12.9281C7.65097 12.5432 8.34903 12.5432 8.85139 12.9281L10.6807 14.3295C11.7636 15.159 13.2725 14.1079 12.8696 12.8046L12.09 10.2827C11.9159 9.71975 12.113 9.10809 12.5829 8.75263L14.673 7.17173Z' fill='#FFAD33'/>
                                </svg>
                                <svg width='16' height='15' viewBox='0 0 16 15' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                    <path d='M14.673 7.17173C15.7437 6.36184 15.1709 4.65517 13.8284 4.65517H11.3992C10.7853 4.65517 10.243 4.25521 10.0617 3.66868L9.33754 1.32637C8.9309 0.0110567 7.0691 0.0110564 6.66246 1.32637L5.93832 3.66868C5.75699 4.25521 5.21469 4.65517 4.60078 4.65517H2.12961C0.791419 4.65517 0.215919 6.35274 1.27822 7.16654L3.39469 8.78792C3.85885 9.1435 4.05314 9.75008 3.88196 10.3092L3.11296 12.8207C2.71416 14.1232 4.22167 15.1704 5.30301 14.342L7.14861 12.9281C7.65097 12.5432 8.34903 12.5432 8.85139 12.9281L10.6807 14.3295C11.7636 15.159 13.2725 14.1079 12.8696 12.8046L12.09 10.2827C11.9159 9.71975 12.113 9.10809 12.5829 8.75263L14.673 7.17173Z' fill='#FFAD33'/>
                                </svg>
                                <svg width='16' height='15' viewBox='0 0 16 15' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                    <path d='M14.673 7.17173C15.7437 6.36184 15.1709 4.65517 13.8284 4.65517H11.3992C10.7853 4.65517 10.243 4.25521 10.0617 3.66868L9.33754 1.32637C8.9309 0.0110567 7.0691 0.0110564 6.66246 1.32637L5.93832 3.66868C5.75699 4.25521 5.21469 4.65517 4.60078 4.65517H2.12961C0.791419 4.65517 0.215919 6.35274 1.27822 7.16654L3.39469 8.78792C3.85885 9.1435 4.05314 9.75008 3.88196 10.3092L3.11296 12.8207C2.71416 14.1232 4.22167 15.1704 5.30301 14.342L7.14861 12.9281C7.65097 12.5432 8.34903 12.5432 8.85139 12.9281L10.6807 14.3295C11.7636 15.159 13.2725 14.1079 12.8696 12.8046L12.09 10.2827C11.9159 9.71975 12.113 9.10809 12.5829 8.75263L14.673 7.17173Z' fill='#FFAD33'/>
                                </svg>
                                <svg width='16' height='15' viewBox='0 0 16 15' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                    <path opacity='0.25' d='M14.673 7.17173C15.7437 6.36184 15.1709 4.65517 13.8284 4.65517H11.3992C10.7853 4.65517 10.243 4.25521 10.0617 3.66868L9.33754 1.32637C8.9309 0.0110567 7.0691 0.0110564 6.66246 1.32637L5.93832 3.66868C5.75699 4.25521 5.21469 4.65517 4.60078 4.65517H2.12961C0.791419 4.65517 0.215919 6.35274 1.27822 7.16654L3.39469 8.78792C3.85885 9.1435 4.05314 9.75008 3.88196 10.3092L3.11296 12.8207C2.71416 14.1232 4.22167 15.1704 5.30301 14.342L7.14861 12.9281C7.65097 12.5432 8.34903 12.5432 8.85139 12.9281L10.6807 14.3295C11.7636 15.159 13.2725 14.1079 12.8696 12.8046L12.09 10.2827C11.9159 9.71975 12.113 9.10809 12.5829 8.75263L14.673 7.17173Z' fill='black'/>
                                </svg>
                                <svg width='16' height='15' viewBox='0 0 16 15' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                    <path opacity='0.25' d='M14.673 7.17173C15.7437 6.36184 15.1709 4.65517 13.8284 4.65517H11.3992C10.7853 4.65517 10.243 4.25521 10.0617 3.66868L9.33754 1.32637C8.9309 0.0110567 7.0691 0.0110564 6.66246 1.32637L5.93832 3.66868C5.75699 4.25521 5.21469 4.65517 4.60078 4.65517H2.12961C0.791419 4.65517 0.215919 6.35274 1.27822 7.16654L3.39469 8.78792C3.85885 9.1435 4.05314 9.75008 3.88196 10.3092L3.11296 12.8207C2.71416 14.1232 4.22167 15.1704 5.30301 14.342L7.14861 12.9281C7.65097 12.5432 8.34903 12.5432 8.85139 12.9281L10.6807 14.3295C11.7636 15.159 13.2725 14.1079 12.8696 12.8046L12.09 10.2827C11.9159 9.71975 12.113 9.10809 12.5829 8.75263L14.673 7.17173Z' fill='black'/>
                                </svg>
                            </span>
                            <span></span>
                        </div>
                    </div>
                </div>
                ";
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
