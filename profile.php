<?php
include('./includes/connect.php');
include('./functions/common_functions.php');
session_start();

if(!isset($_SESSION['username'])) {
    header("Location: user_login.php");
    exit();
}

$username = $_SESSION['username'];
$user_query = "SELECT * FROM `user_table` WHERE username='$username'";
$user_result = mysqli_query($con, $user_query);
$user_data = mysqli_fetch_assoc($user_result);

// Récupérer les commandes de l'utilisateur
$orders_query = "SELECT * FROM `user_orders` WHERE user_id=" . $user_data['user_id'] . " ORDER BY order_date DESC LIMIT 10";
$orders_result = mysqli_query($con, $orders_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideIn {
            from { transform: translateX(-20px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        .profile-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 30px;
            animation: fadeIn 0.5s ease-out;
        }

        .profile-header {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 30px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            animation: slideIn 0.5s ease-out;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 30px;
            border: 4px solid #28a745;
            overflow: hidden;
        }

        .profile-avatar i {
            font-size: 3rem;
            color: #28a745;
        }

        .profile-info {
            flex-grow: 1;
        }

        .profile-name {
            font-size: 1.8rem;
            font-weight: 700;
            color: #495057;
            margin-bottom: 5px;
        }

        .profile-email {
            color: #6c757d;
            margin-bottom: 10px;
        }

        .profile-stats {
            display: flex;
            gap: 20px;
            margin-top: 15px;
        }

        .stat-item {
            text-align: center;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            min-width: 120px;
            transition: all 0.3s ease;
        }

        .stat-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #28a745;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .profile-content {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 30px;
        }

        .profile-sidebar {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 30px rgba(0,0,0,0.1);
            animation: slideIn 0.5s ease-out;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-item {
            margin-bottom: 10px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: #495057;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .sidebar-link:hover, .sidebar-link.active {
            background: #f8f9fa;
            color: #28a745;
        }

        .sidebar-link i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .profile-main {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 30px rgba(0,0,0,0.1);
            animation: fadeIn 0.5s ease-out;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #495057;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f8f9fa;
        }

        .order-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .order-card:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .order-number {
            font-weight: 600;
            color: #495057;
        }

        .order-date {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .order-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .order-amount {
            font-weight: 700;
            color: #28a745;
        }

        .order-status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .status-complete {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }

        .status-pending {
            background: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }

        .btn-edit-profile {
            padding: 8px 20px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-edit-profile:hover {
            background: #218838;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        }

        @media (max-width: 768px) {
            .profile-content {
                grid-template-columns: 1fr;
            }

            .profile-header {
                flex-direction: column;
                text-align: center;
            }

            .profile-avatar {
                margin: 0 auto 20px;
            }

            .profile-stats {
                justify-content: center;
                flex-wrap: wrap;
            }
        }
    </style>
</head>
<body>
    <?php require "navbar.php"; ?>

    <div class="container">
        <div class="profile-container">
            <div class="profile-header">
                <div class="profile-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="profile-info">
                    <h1 class="profile-name"><?php echo $user_data['username']; ?></h1>
                    <p class="profile-email"><?php echo $user_data['user_email']; ?></p>
                    <a href="edit_account.php" class="btn-edit-profile">
                        <i class="fas fa-edit"></i>
                        Edit Profile
                    </a>
                </div>
                <div class="profile-stats">
                    <div class="stat-item">
                        <div class="stat-value"><?php echo mysqli_num_rows($orders_result); ?></div>
                        <div class="stat-label">Orders</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">0</div>
                        <div class="stat-label">Reviews</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">0</div>
                        <div class="stat-label">Wishlist</div>
                    </div>
                </div>
            </div>

            <div class="profile-content">
                <div class="profile-sidebar">
                    <ul class="sidebar-menu">
                        <li class="sidebar-item">
                            <a href="profile.php" class="sidebar-link active">
                                <i class="fas fa-user"></i>
                                Profile
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="user_orders.php" class="sidebar-link">
                                <i class="fas fa-shopping-bag"></i>
                                Orders
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="delete_account.php" class="sidebar-link">
                                <i class="fas fa-user-times"></i>
                                Delete Account
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="logout.php" class="sidebar-link">
                                <i class="fas fa-sign-out-alt"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="profile-main">
                    <h2 class="section-title">Recent Orders</h2>
                    <?php
                    if(mysqli_num_rows($orders_result) > 0) {
                        while($order = mysqli_fetch_assoc($orders_result)) {
                            ?>
                            <div class="order-card">
                                <div class="order-header">
                                    <span class="order-number">Order #<?php echo $order['order_id']; ?></span>
                                    <span class="order-date"><?php echo date('d/m/Y', strtotime($order['order_date'])); ?></span>
                                </div>
                                <div class="order-details">
                                    <span class="order-amount"><?php echo $order['amount_due']; ?> DT</span>
                                    <span class="order-status <?php echo $order['order_status'] == 'complete' ? 'status-complete' : 'status-pending'; ?>">
                                        <?php echo ucfirst($order['order_status']); ?>
                                    </span>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo '<p>No orders found.</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php require "footer.php"; ?>
    <script src="assets/js/bootstrap.bundle.js"></script>
</body>
</html>
