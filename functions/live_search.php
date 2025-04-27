<?php
// Get the search query
$query = isset($_GET['q']) ? trim($_GET['q']) : '';

if (empty($query)) {
    echo '';
    exit;
}

// Connect to database
$host = 'localhost';
$user = 'root';  // XAMPP default
$password = '';  // XAMPP default
$database = 'fpfaa';  // Your database name

try {
    $conn = new mysqli($host, $user, $password, $database);
    
    if ($conn->connect_error) {
        throw new Exception("Connexion échouée : " . $conn->connect_error);
    }
    
    // Préparer la requête SQL avec LIKE
    $search_term = "%{$query}%";
    $sql = "SELECT product_id, product_title, product_price, product_image_one 
            FROM products 
            WHERE product_title LIKE ? OR product_keywords LIKE ?
            LIMIT 8";
    
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception("Erreur dans la requête SQL : " . $conn->error);
    }

    $stmt->bind_param("ss", $search_term, $search_term);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        echo '<p class="dropdown-item">Aucun résultat trouvé</p>';
    } else {
        while ($product = $result->fetch_assoc()) {
            $product_id = htmlspecialchars($product['product_id']);
            $title = htmlspecialchars($product['product_title']);
            $price = number_format($product['product_price'], 2);
            $image = htmlspecialchars($product['product_image_one']);
            
            echo <<<HTML
            <a href="product_details.php?product_id={$product_id}" class="dropdown-item d-flex align-items-center gap-2">
                <img src="./admin/product_images/{$image}" alt="{$title}" width="40" height="40" class="img-thumbnail">
                <div>
                    <div>{$title}</div>
                    
                </div>
            </a>
            HTML;
        }
    }
    
    $stmt->close();
    $conn->close();
    
} catch (Exception $e) {
    echo '<p class="dropdown-item text-danger">Erreur : ' . htmlspecialchars($e->getMessage()) . '</p>';
}
?>
