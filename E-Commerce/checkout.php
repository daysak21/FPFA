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
while($row = mysqli_fetch_array($cart_result)) {
    $product_id = $row['product_id'];
    $product_quantity = $row['quantity'];
    $product_query = "SELECT * FROM `products` WHERE product_id=$product_id";
    $product_result = mysqli_query($con, $product_query);
    $product_data = mysqli_fetch_array($product_result);
    $total_price += $product_data['product_price'] * $product_quantity;
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
</head>
<body>
    <?php require "navbar.php"; ?>

    <div class="container py-5">
        <div class="row">
            <div class="col-md-8">
                <h2>Payment Information</h2>
                <form action="process_payment.php" method="post">
                    <div class="mb-3">
                        <label for="card_number" class="form-label">Card Number</label>
                        <input type="text" class="form-control" id="card_number" name="card_number" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="expiry_date" class="form-label">Expiry Date</label>
                            <input type="text" class="form-control" id="expiry_date" name="expiry_date" placeholder="MM/YY" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="cvv" class="form-label">CVV</label>
                            <input type="text" class="form-control" id="cvv" name="cvv" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="name_on_card" class="form-label">Name on Card</label>
                        <input type="text" class="form-control" id="name_on_card" name="name_on_card" required>
                    </div>
                    <input type="hidden" name="total_amount" value="<?php echo $total_price; ?>">
                    <button type="submit" class="btn btn-success btn-lg">Pay Now (<?php echo $total_price; ?> €)</button>
                </form>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Order Summary</h5>
                        <p>Total: <?php echo $total_price; ?> €</p>
                        <p>Items: <?php echo $cart_count; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require "footer.php"; ?>
    <script src="assets/js/bootstrap.bundle.js"></script>
</body>
</html>