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

    // Générer un numéro de facture unique
    $invoice_number = mt_rand(100000, 999999);

    // Insérer la commande
    $insert_order = "INSERT INTO `user_orders` (user_id, amount_due, total_products, order_date, order_status, payment_method) 
                    VALUES ($user_id, $total_price, $cart_count, '$order_date', 'pending', '$payment_method')";
    $result_order = mysqli_query($con, $insert_order);
    
    if($result_order) {
        $order_id = mysqli_insert_id($con);
        
        // Insérer le paiement
        $insert_payment = "INSERT INTO `user_payments` (order_id, invoice_number, amount, payment_method) 
                         VALUES ($order_id, $invoice_number, $total_price, '$payment_method')";
        mysqli_query($con, $insert_payment);
        
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
        header("Location: order_confirmation.php?order_id=$order_id&invoice=$invoice_number");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        @keyframes slideIn {
            from { transform: translateX(-20px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        .payment-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 30px rgba(0,0,0,0.1);
            animation: fadeIn 0.5s ease-out;
        }

        .payment-method {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .payment-method::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, rgba(40, 167, 69, 0.1), rgba(40, 167, 69, 0.05));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .payment-method:hover {
            border-color: #28a745;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.1);
        }

        .payment-method:hover::before {
            opacity: 1;
        }

        .payment-method.active {
            border-color: #28a745;
            background: rgba(40, 167, 69, 0.05);
            animation: pulse 0.5s ease;
        }

        .payment-method i {
            font-size: 1.5rem;
            margin-right: 10px;
            color: #28a745;
            transition: transform 0.3s ease;
        }

        .payment-method:hover i {
            transform: scale(1.2);
        }

        .order-summary {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            animation: slideIn 0.5s ease-out;
            border-left: 4px solid #28a745;
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
            position: relative;
            overflow: hidden;
        }

        .btn-confirm::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }

        .btn-confirm:hover {
            background: #218838;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        }

        .btn-confirm:hover::before {
            left: 100%;
        }

        .payment-details {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            display: none;
            animation: fadeIn 0.3s ease-out;
            background: rgba(248, 249, 250, 0.5);
        }

        .payment-details.active {
            display: block;
        }

        .form-group {
            margin-bottom: 15px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #495057;
            transition: color 0.3s ease;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            transition: all 0.3s ease;
            background: white;
        }

        .form-group input:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.1);
            outline: none;
        }

        .form-group input::placeholder {
            color: #adb5bd;
        }

        .payment-header {
            text-align: center;
            margin-bottom: 30px;
            animation: fadeIn 0.5s ease-out;
        }

        .payment-header h2 {
            color: #28a745;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .payment-header p {
            color: #6c757d;
        }

        .payment-method-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #495057;
            margin-bottom: 15px;
            animation: slideIn 0.5s ease-out;
        }

        .payment-icon {
            font-size: 2rem;
            color: #28a745;
            margin-bottom: 15px;
            animation: pulse 2s infinite;
        }
    </style>
</head>
<body>
    <?php require "navbar.php"; ?>

    <div class="container">
        <div class="payment-container">
            <div class="payment-header">
                <i class="fas fa-lock payment-icon"></i>
                <h2>Secure Payment</h2>
                <p>Choose your preferred payment method</p>
            </div>
            
            <div class="order-summary">
                <h4><i class="fas fa-shopping-bag"></i> Order Summary</h4>
                <p><strong>Total Items:</strong> <?php echo $cart_count; ?></p>
                <p><strong>Total Amount:</strong> <?php echo $total_price; ?> DT</p>
            </div>

            <form action="payment.php" method="post">
                <h4 class="payment-method-title"><i class="fas fa-credit-card"></i> Select Payment Method</h4>
                
                <div class="payment-method" onclick="selectPaymentMethod('card')">
                    <i class="fas fa-credit-card"></i>
                    <span>Credit/Debit Card</span>
                    <input type="radio" name="payment_method" value="card" style="display: none;">
                </div>

                <div class="payment-details" id="card-details">
                    <div class="form-group">
                        <label for="card_number"><i class="fas fa-credit-card"></i> Card Number</label>
                        <input type="text" id="card_number" name="card_number" placeholder="1234 5678 9012 3456" maxlength="19">
                    </div>
                    <div class="form-group">
                        <label for="card_holder"><i class="fas fa-user"></i> Card Holder Name</label>
                        <input type="text" id="card_holder" name="card_holder" placeholder="John Doe">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="expiry_date"><i class="fas fa-calendar-alt"></i> Expiry Date</label>
                                <input type="text" id="expiry_date" name="expiry_date" placeholder="MM/YY" maxlength="5">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cvv"><i class="fas fa-lock"></i> CVV</label>
                                <input type="text" id="cvv" name="cvv" placeholder="123" maxlength="3">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="payment-method" onclick="selectPaymentMethod('d17')">
                    <i class="fas fa-mobile-alt"></i>
                    <span>D17 Mobile Payment</span>
                    <input type="radio" name="payment_method" value="d17" style="display: none;">
                </div>

                <div class="payment-details" id="d17-details">
                    <div class="form-group">
                        <label for="phone_number"><i class="fas fa-phone"></i> Phone Number</label>
                        <input type="text" id="phone_number" name="phone_number" placeholder="+216 XX XXX XXX">
                    </div>
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
            
            // Cacher tous les détails de paiement
            document.querySelectorAll('.payment-details').forEach(el => {
                el.classList.remove('active');
            });
            
            // Sélectionner la méthode choisie
            const selectedMethod = event.currentTarget;
            selectedMethod.classList.add('active');
            selectedMethod.querySelector('input[type="radio"]').checked = true;
            
            // Afficher les détails correspondants
            document.getElementById(method + '-details').classList.add('active');
        }

        // Formatage du numéro de carte
        document.getElementById('card_number').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            let formattedValue = '';
            for(let i = 0; i < value.length; i++) {
                if(i > 0 && i % 4 === 0) {
                    formattedValue += ' ';
                }
                formattedValue += value[i];
            }
            e.target.value = formattedValue;
        });

        // Formatage de la date d'expiration
        document.getElementById('expiry_date').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if(value.length >= 2) {
                value = value.slice(0,2) + '/' + value.slice(2);
            }
            e.target.value = value;
        });
    </script>
</body>
</html> 