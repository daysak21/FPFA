<?php
include('./includes/connect.php');
include('./functions/common_functions.php');
session_start();

// Vérifier si l'utilisateur est connecté
if(!isset($_SESSION['username'])) {
    header("Location: user_login.php");
    exit();
}

// Vérifier si l'ID de commande est présent
if(!isset($_GET['order_id'])) {
    header("Location: user_orders.php");
    exit();
}

$order_id = $_GET['order_id'];
$username = $_SESSION['username'];

// Récupérer les informations de la commande
$order_query = "SELECT * FROM `user_orders` WHERE order_id='$order_id'";
$order_result = mysqli_query($con, $order_query);
$order_data = mysqli_fetch_assoc($order_result);

// Vérifier si la commande existe et appartient à l'utilisateur
$user_query = "SELECT * FROM `user_table` WHERE username='$username'";
$user_result = mysqli_query($con, $user_query);
$user_data = mysqli_fetch_assoc($user_result);
$user_id = $user_data['user_id'];

if($order_data['user_id'] != $user_id) {
    header("Location: user_orders.php");
    exit();
}

// Traiter le formulaire de paiement
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $payment_method = $_POST['payment_method'];
    
    // Mettre à jour le statut de la commande
    $update_order = "UPDATE `user_orders` SET order_status='complete', payment_method='$payment_method' WHERE order_id='$order_id'";
    $update_result = mysqli_query($con, $update_order);

    if($update_result) {
        // Insérer le paiement dans la table user_payments
        $payment_query = "INSERT INTO `user_payments` (order_id, amount, payment_method, payment_date) 
                         VALUES ('$order_id', '{$order_data['amount_due']}', '$payment_method', NOW())";
        $payment_result = mysqli_query($con, $payment_query);
        
        if($payment_result) {
            // Rediriger vers la page de confirmation
            header("Location: order_confirmation.php?order_id=$order_id");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Payment</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        .payment-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 30px rgba(0,0,0,0.1);
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
        <div class="payment-container">
            <h2 class="mb-4">Confirm Your Payment</h2>
            
            <div class="order-summary">
                <h4>Order Summary</h4>
                <p><strong>Order ID:</strong> #<?php echo $order_id; ?></p>
                <p><strong>Total Amount:</strong> <?php echo $order_data['amount_due']; ?> DT</p>
                <p><strong>Number of Items:</strong> <?php echo $order_data['total_products']; ?></p>
            </div>

            <form action="confirm_payment.php?order_id=<?php echo $order_id; ?>" method="post">
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