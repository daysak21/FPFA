<?php
include('./includes/connect.php');
include('./functions/common_functions.php');
session_start();

if(!isset($_GET['order_id']) || !isset($_GET['invoice'])) {
    header("Location: index.php");
    exit();
}

$order_id = $_GET['order_id'];
$invoice_number = $_GET['invoice'];

// Récupérer les détails de la commande
$order_query = "SELECT * FROM `user_orders` WHERE order_id=$order_id";
$order_result = mysqli_query($con, $order_query);
$order_data = mysqli_fetch_assoc($order_result);

// Récupérer les détails du paiement
$payment_query = "SELECT * FROM `user_payments` WHERE order_id=$order_id";
$payment_result = mysqli_query($con, $payment_query);
$payment_data = mysqli_fetch_assoc($payment_result);

// Récupérer les produits de la commande
$products_query = "SELECT * FROM `orders_pending` WHERE order_id=$order_id";
$products_result = mysqli_query($con, $products_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        @keyframes confetti {
            0% { transform: translateY(0) rotate(0deg); opacity: 1; }
            100% { transform: translateY(100vh) rotate(360deg); opacity: 0; }
        }

        @keyframes checkmark {
            0% { transform: scale(0); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .confirmation-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 30px rgba(0,0,0,0.1);
            animation: fadeIn 0.5s ease-out;
            text-align: center;
        }

        .success-icon {
            font-size: 4rem;
            color: #28a745;
            margin-bottom: 20px;
            animation: checkmark 0.5s ease-out;
        }

        .confirmation-header {
            margin-bottom: 30px;
        }

        .confirmation-header h1 {
            color: #28a745;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .confirmation-header p {
            color: #6c757d;
            font-size: 1.1rem;
        }

        .order-details {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            text-align: left;
            border-left: 4px solid #28a745;
        }

        .order-details h3 {
            color: #495057;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e9ecef;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: #6c757d;
            font-weight: 500;
        }

        .detail-value {
            color: #495057;
            font-weight: 600;
        }

        .products-list {
            margin-top: 20px;
        }

        .product-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 10px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .product-item img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 15px;
        }

        .product-info {
            flex-grow: 1;
        }

        .product-name {
            font-weight: 600;
            color: #495057;
            margin-bottom: 5px;
        }

        .product-details {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .btn-continue {
            padding: 12px 30px;
            font-weight: 600;
            letter-spacing: 0.5px;
            background: #28a745;
            border: none;
            border-radius: 8px;
            color: white;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }

        .btn-continue:hover {
            background: #218838;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
            color: white;
        }

        .confetti {
            position: fixed;
            width: 10px;
            height: 10px;
            background: #28a745;
            opacity: 0;
            animation: confetti 3s ease-out forwards;
        }
    </style>
</head>
<body>
    <?php require "navbar.php"; ?>

    <div class="container">
        <div class="confirmation-container">
            <i class="fas fa-check-circle success-icon"></i>
            
            <div class="confirmation-header">
                <h1>Thank You for Your Order!</h1>
                <p>Your payment has been successfully processed</p>
            </div>

            <div class="order-details">
                <h3><i class="fas fa-receipt"></i> Order Details</h3>
                
                <div class="detail-row">
                    <span class="detail-label">Order Number:</span>
                    <span class="detail-value">#<?php echo $order_id; ?></span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Invoice Number:</span>
                    <span class="detail-value">#<?php echo $invoice_number; ?></span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Payment Method:</span>
                    <span class="detail-value">
                        <?php 
                        if($payment_data['payment_method'] == 'card') {
                            echo '<i class="fas fa-credit-card"></i> Credit/Debit Card';
                        } else {
                            echo '<i class="fas fa-mobile-alt"></i> D17 Mobile Payment';
                        }
                        ?>
                    </span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Total Amount:</span>
                    <span class="detail-value"><?php echo $order_data['amount_due']; ?> DT</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Order Date:</span>
                    <span class="detail-value"><?php echo date('d/m/Y H:i', strtotime($order_data['order_date'])); ?></span>
                </div>

                <div class="products-list">
                    <h4 class="mt-4 mb-3">Ordered Products:</h4>
                    <?php
                    while($product = mysqli_fetch_assoc($products_result)) {
                        $product_query = "SELECT * FROM `products` WHERE product_id=" . $product['product_id'];
                        $product_result = mysqli_query($con, $product_query);
                        $product_data = mysqli_fetch_assoc($product_result);
                        ?>
                        <div class="product-item">
                            <img src="./admin/product_images/<?php echo $product_data['product_image_one']; ?>" 
                                 alt="<?php echo $product_data['product_title']; ?>">
                            <div class="product-info">
                                <div class="product-name"><?php echo $product_data['product_title']; ?></div>
                                <div class="product-details">
                                    Quantity: <?php echo $product['quantity']; ?> | 
                                    Price: <?php echo $product['price']; ?> DT
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>

            <a href="index.php" class="btn btn-continue">
                <i class="fas fa-shopping-bag"></i>
                Continue Shopping
            </a>
        </div>
    </div>

    <?php require "footer.php"; ?>
    <script src="assets/js/bootstrap.bundle.js"></script>
    <script>
        // Créer des confettis
        function createConfetti() {
            const colors = ['#28a745', '#218838', '#1e7e34'];
            for(let i = 0; i < 50; i++) {
                const confetti = document.createElement('div');
                confetti.className = 'confetti';
                confetti.style.left = Math.random() * 100 + 'vw';
                confetti.style.animationDelay = Math.random() * 2 + 's';
                confetti.style.background = colors[Math.floor(Math.random() * colors.length)];
                confetti.style.transform = `rotate(${Math.random() * 360}deg)`;
                document.body.appendChild(confetti);
                
                // Supprimer le confetti après l'animation
                setTimeout(() => {
                    confetti.remove();
                }, 3000);
            }
        }

        // Lancer les confettis au chargement de la page
        window.onload = createConfetti;
    </script>
</body>
</html> 