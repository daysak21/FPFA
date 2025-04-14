<?php
include('./includes/connect.php');
include('./functions/common_functions.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>

<body>
    <?php require "navbar.php"; ?>

    <div class="cart-container">
        <div class="container py-5">
            <div class="cart-header">
                <div class="header-content">
                    <i class="fas fa-shopping-basket"></i>
                    <h2>My Shopping Cart</h2>
                </div>
                <div class="cart-progress"></div>
            </div>
            
            <?php
            $getIpAddress = getIPAddress();
            $total_price = 0;
            $cart_query = "SELECT * FROM `card_details` WHERE ip_address='$getIpAddress'";
            $cart_result = mysqli_query($con, $cart_query);
            $result_count = mysqli_num_rows($cart_result);
            if ($result_count > 0) {
                ?>
                <div class="cart-layout">
                    <div class="cart-main">
                        <div class="cute-table-container">
                            <table class="cute-table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                while ($row = mysqli_fetch_array($cart_result)) {
                                    $product_id = $row['product_id'];
                                    $product_quantity = $row['quantity'];
                                    $select_product_query = "SELECT * FROM `products` WHERE product_id=$product_id";
                                    $select_product_result = mysqli_query($con, $select_product_query);
                                    while ($row_product = mysqli_fetch_array($select_product_result)) {
                                        $product_price = array($row_product['product_price']);
                                        $price_table = $row_product['product_price'];
                                        $product_title = $row_product['product_title'];
                                        $product_image_one = $row_product['product_image_one'];
                                        $product_values = array_sum($product_price);
                                        $total_price += $product_values * $product_quantity;
                                        ?>
                                        <tr class="cart-row">
                                            <td class="product-info">
                                                <img src="./admin/product_images/<?php echo $product_image_one; ?>" alt="<?php echo $product_title; ?>">
                                                <div class="product-details">
                                                    <h4><?php echo $product_title; ?></h4>
                                                    <span class="product-id">ID: #<?php echo $product_id; ?></span>
                                                </div>
                                            </td>
                                            <td class="price-column">
                                                <div class="price-tag">
                                                    <span class="currency">DT</span>
                                                    <span class="amount"><?php echo $price_table; ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="quantity-form">
                                                    <div class="quantity-wrapper">
                                                        <button type="button" class="qty-btn minus">-</button>
                                                        <input type="number" name="qty_<?php echo $product_id; ?>" value="<?php echo $product_quantity; ?>" min="1" class="quantity-input">
                                                        <button type="button" class="qty-btn plus">+</button>
                                                    </div>
                                                    <input type="hidden" name="item_id" value="<?php echo $product_id; ?>">
                                                    <button type="submit" name="update_cart" class="update-btn">
                                                        <i class="fas fa-sync-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="total-column">
                                                <div class="total-price">
                                                    <span class="amount"><?php echo $price_table * $product_quantity; ?></span>
                                                    <span class="currency">DT</span>

                                                </div>
                                            </td>
                                            <td>
                                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="action-form">
                                                    <button type="submit" name="remove_item" value="<?php echo $product_id; ?>" class="remove-btn">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="cart-side">
                        <div class="cart-summary">
                            <div class="summary-card">
                                <div class="summary-header">
                                    <i class="fas fa-receipt"></i>
                                    <h3>Order Summary</h3>
                                </div>
                                <div class="summary-content">
                                    <div class="summary-row">
                                        <span>Subtotal</span>
                                        <span class="amount"><?php echo $total_price; ?> DT</span>
                                    </div>
                                    <div class="summary-row">
                                        <span>Shipping</span>
                                        <span class="text-success">Free</span>
                                    </div>
                                    <div class="summary-divider"></div>
                                    <div class="summary-row total">
                                        <span>Total</span>
                                        <span class="total-amount"><?php echo $total_price; ?> DT</span>
                                    </div>
                                </div>
                                <div class="summary-footer">
                                    <a href="index.php" class="btn-continue">
                                        <i class="fas fa-arrow-left"></i>
                                        Continue Shopping
                                    </a>
                                    <form action="checkout.php" method="post" class="d-inline">
                                        <input type="hidden" name="total_amount" value="<?php echo $total_price; ?>">
                                        <button type="submit" name="proceed_to_checkout" class="btn-checkout">
                                            <i class="fas fa-lock"></i>
                                            Checkout Securely
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                ?>
                <div class="empty-cart">
                    <div class="empty-cart-content">
                        <div class="empty-cart-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <h3>Your cart is empty</h3>
                        <p>Looks like you haven't added anything to your cart yet.</p>
                        <a href="index.php" class="btn-start-shopping">
                            <i class="fas fa-store"></i>
                            Start Shopping
                        </a>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>

    <?php
    // Handle cart updates and removals
    if (isset($_POST['update_cart'])) {
        $product_id = $_POST['item_id'];
        $quantity = $_POST["qty_$product_id"];
        if (!empty($quantity)) {
            $update_cart_query = "UPDATE `card_details` SET quantity = $quantity WHERE ip_address='$getIpAddress' AND product_id=$product_id";
            mysqli_query($con, $update_cart_query);
            echo "<script>window.location.href='cart.php';</script>";
        }
    }

    if (isset($_POST['remove_item'])) {
        $product_id = $_POST['remove_item'];
        $delete_query = "DELETE FROM `card_details` WHERE ip_address='$getIpAddress' AND product_id=$product_id";
        mysqli_query($con, $delete_query);
        echo "<script>window.location.href='cart.php';</script>";
    }
    ?>

    <script>
    // Add quantity increment/decrement functionality
    document.addEventListener('DOMContentLoaded', function() {
        const qtyBtns = document.querySelectorAll('.qty-btn');
        qtyBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const input = this.parentElement.querySelector('.quantity-input');
                const currentValue = parseInt(input.value);
                if (this.classList.contains('plus')) {
                    input.value = currentValue + 1;
                } else if (this.classList.contains('minus') && currentValue > 1) {
                    input.value = currentValue - 1;
                }
            });
        });
    });
    </script>

    <script src="./assets/js/bootstrap.bundle.js"></script>
    <?php require "footer.php"; ?>
</body>
</html>
