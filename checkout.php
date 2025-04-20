<?php
include('./includes/connect.php');
include('./functions/common_functions.php');
session_start();

// Vérifier si l'utilisateur est connecté
if(!isset($_SESSION['username'])) {
    header("Location: user_login.php");
    exit();
}

// Vérifier si le panier n'est pas vide
$getIpAddress = getIPAddress();
$cart_query = "SELECT * FROM `card_details` WHERE ip_address='$getIpAddress'";
$cart_result = mysqli_query($con, $cart_query);
$cart_count = mysqli_num_rows($cart_result);

if($cart_count == 0) {
    header("Location: cart.php");
    exit();
}

// Calculer le total
$total_price = 0;
mysqli_data_seek($cart_result, 0);
while($row = mysqli_fetch_array($cart_result)) {
    $product_id = $row['product_id'];
    $product_quantity = $row['quantity'];
    $product_query = "SELECT * FROM `products` WHERE product_id=$product_id";
    $product_result = mysqli_query($con, $product_query);
    $product_data = mysqli_fetch_array($product_result);
    $total_price += $product_data['product_price'] * $product_quantity;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $payment_method = $_POST['payment_method'];
    $username = $_SESSION['username'];
    $order_date = date('Y-m-d H:i:s');
    
    // Récupérer l'ID de l'utilisateur
    $user_query = "SELECT * FROM `user_table` WHERE username='$username'";
    $user_result = mysqli_query($con, $user_query);
    $user_data = mysqli_fetch_assoc($user_result);
    $user_id = $user_data['user_id'];

    // Insérer la commande
    $insert_order = "INSERT INTO `user_orders` (user_id, amount_due, total_products, order_date, order_status, payment_method) 
                    VALUES ($user_id, $total_price, $cart_count, '$order_date', 'pending', '$payment_method')";
    $result_order = mysqli_query($con, $insert_order);
    
    if($result_order) {
        $order_id = mysqli_insert_id($con);
        
        // Insérer les détails de la commande
        mysqli_data_seek($cart_result, 0);
        while($cart_data = mysqli_fetch_assoc($cart_result)) {
            $product_id = $cart_data['product_id'];
            $quantity = $cart_data['quantity'];
            
            $product_query = "SELECT * FROM `products` WHERE product_id=$product_id";
            $product_result = mysqli_query($con, $product_query);
            $product_data = mysqli_fetch_assoc($product_result);
            $product_price = $product_data['product_price'];
            
            $insert_order_details = "INSERT INTO `orders_pending` (order_id, user_id, product_id, quantity, price) 
                                   VALUES ($order_id, $user_id, $product_id, $quantity, $product_price)";
            mysqli_query($con, $insert_order_details);
            
            // Mettre à jour le stock
            $new_stock = $product_data['product_quantity'] - $quantity;
            $update_stock = "UPDATE `products` SET product_quantity=$new_stock WHERE product_id=$product_id";
            mysqli_query($con, $update_stock);
        }
        
        // Vider le panier
        $delete_cart = "DELETE FROM `card_details` WHERE ip_address='$getIpAddress'";
        mysqli_query($con, $delete_cart);
        
        // Rediriger vers la confirmation
        header("Location: order_confirmation.php?order_id=$order_id");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        .checkout-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 30px rgba(0,0,0,0.1);
        }
        .payment-form {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            border: 1px solid rgba(0,0,0,0.05);
        }
        .payment-method {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .payment-method:hover {
            border-color: #28a745;
            background: rgba(40, 167, 69, 0.05);
        }
        .payment-method.active {
            border-color: #28a745;
            background: rgba(40, 167, 69, 0.05);
        }
        .payment-method i {
            font-size: 1.5rem;
            margin-right: 10px;
            color: #28a745;
        }
        .order-summary {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
        }
        .btn-confirm {
            padding: 12px 30px;
            font-weight: 600;
            letter-spacing: 0.5px;
            background: #28a745;
            border: none;
            border-radius: 8px;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-confirm:hover {
            background: #218838;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        }
    </style>
</head>
<body>
    <?php require "navbar.php"; ?>

    <div class="container">
        <div class="checkout-container">
            <h2 class="mb-4">Payment Information</h2>
            
            <div class="order-summary">
                <h4>Order Summary</h4>
                <p><strong>Total Items:</strong> <?php echo $cart_count; ?></p>
                <p><strong>Total Amount:</strong> <?php echo $total_price; ?> DT</p>
            </div>

            <form action="checkout.php" method="post" class="payment-form">
                <h4 class="mb-3">Select Payment Method</h4>
                
                <div class="payment-method" onclick="selectPaymentMethod('card')">
                    <i class="fas fa-credit-card"></i>
                    <span>Credit/Debit Card</span>
                    <input type="radio" name="payment_method" value="card" style="display: none;">
                </div>

                <div class="payment-method" onclick="selectPaymentMethod('d17')">
                    <i class="fas fa-mobile-alt"></i>
                    <span>D17 Mobile Payment</span>
                    <input type="radio" name="payment_method" value="d17" style="display: none;">
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-confirm">
                        <i class="fas fa-check-circle"></i>
                        Confirm Payment
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php require "footer.php"; ?>
    <script src="assets/js/bootstrap.bundle.js"></script>
    <script>
        function selectPaymentMethod(method) {
            // Désélectionner toutes les méthodes
            document.querySelectorAll('.payment-method').forEach(el => {
                el.classList.remove('active');
                el.querySelector('input[type="radio"]').checked = false;
            });
            
            // Sélectionner la méthode choisie
            const selectedMethod = event.currentTarget;
            selectedMethod.classList.add('active');
            selectedMethod.querySelector('input[type="radio"]').checked = true;
        }
    </script>
</body>
</html>