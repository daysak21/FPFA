<?php
include('../includes/connect.php');
include('../functions/common_functions.php');
session_start();
if(isset($_SESSION['admin_username'])){
    $admin_name = $_SESSION['admin_username'];
    $get_admin_data = "SELECT * FROM `admin_table` WHERE admin_name = '$admin_name'";
    $get_admin_result = mysqli_query($con,$get_admin_data);
    $row_fetch_admin_data = mysqli_fetch_array($get_admin_result);
    $admin_name = $row_fetch_admin_data['admin_name'];
    $admin_image = $row_fetch_admin_data['admin_image'];
}else{
    echo "<script>window.open('./admin_login.php','_self');</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css" />
    <link rel="stylesheet" href="../assets/css/main.css" />
    <style>
        /* Modern Dashboard Styles */
        .app {
            display: grid;
            grid-template-rows: auto 1fr;
            min-height: 100vh;
            background: #f5f7fa;
        }
        
        .app-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            z-index: 10;
        }
        
        .app-header-logo {
            display: flex;
            align-items: center;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .logo-icon {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .logo-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }
        
        .app-header-navigation {
            flex: 1;
            margin: 0 2rem;
        }
        
        .tabs {
            display: flex;
            gap: 1.5rem;
        }
        
        .tabs a {
            padding: 1.25rem 0;
            color: #64748b;
            text-decoration: none;
            font-weight: 500;
            position: relative;
        }
        
        .tabs a.active {
            color: #27ae60;
        }
        
        .tabs a.active:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: #27ae60;
            border-radius: 3px 3px 0 0;
        }
        
        .app-header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: none;
            border: none;
            cursor: pointer;
        }
        
        .user-profile img {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .app-body {
            display: grid;
            grid-template-columns: 240px 1fr;
            flex: 1;
        }
        
        .app-body-navigation {
            background: white;
            border-right: 1px solid #e2e8f0;
            padding: 1.5rem 0;
            display: flex;
            flex-direction: column;
        }
        
        .navigation {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            flex: 1;
        }
        
        .navigation a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.5rem;
            color: #64748b;
            text-decoration: none;
            transition: all 0.2s;
        }
        
        .navigation a:hover {
            background: #f1f5f9;
            color: #27ae60;
        }
        
        .footer {
            padding: 1.5rem;
            font-size: 0.875rem;
            color: #64748b;
        }
        
        .app-body-main-content {
            padding: 2rem;
            background: #f8fafc;
        }
        
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .card {
            background: white;
            border-radius: 0.5rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        
        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }
        
        .card-title {
            font-size: 0.875rem;
            color: #64748b;
            margin: 0;
        }
        
        .card-value {
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0;
            color: #1e293b;
        }
        
        /* Your existing styles */
        .control {
            background: white;
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }
        
        .buttons .btn-outline-primary {
            border-color: #e2e8f0;
            color: #64748b;
        }
        
        .buttons .btn-outline-primary:hover {
            background: #27ae60;
            border-color: #27ae60;
            color: white;
        }
        
        .admin-image img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #e2e8f0;
        }
    </style>
</head>

<body class="app">
    <header class="app-header">
        <div class="app-header-logo">
            <div class="logo">
                <span class="logo-icon">
                    <img src="../assets/images/logo.svg" alt="Logo" />
                </span>
                <h1 class="logo-title">
                    <span>Ecommerce</span>
                    <span>Admin</span>
                </h1>
            </div>
        </div>
        <div class="app-header-navigation">
            <div class="tabs">
                <a href="#" class="active">Dashboard</a>
                <a href="index.php?view_products">Products</a>
                <a href="index.php?view_categories">Categories</a>
                <a href="index.php?view_brands">Brands</a>
                <a href="index.php?list_orders">Orders</a>
                <a href="index.php?list_users">Users</a>
            </div>
        </div>
        <div class="app-header-actions">
            <button class="user-profile">
                <span><?php echo $admin_name; ?></span>
                <span>
                    <img src="./admin_images/<?php echo $admin_image; ?>" alt="Admin" />
                </span>
            </button>
            <div class="app-header-actions-buttons">
                <a href="./admin_logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </header>
    
    <div class="app-body">
        <div class="app-body-navigation">
            <nav class="navigation">
                <a href="./insert_product.php">
                    <i class="ph-plus-circle"></i>
                    <span>Add Product</span>
                </a>
                <a href="index.php?insert_category">
                    <i class="ph-plus-circle"></i>
                    <span>Add Category</span>
                </a>
                <a href="index.php?insert_brand">
                    <i class="ph-plus-circle"></i>
                    <span>Add Brand</span>
                </a>
                <a href="index.php?list_orders">
                    <i class="ph-list"></i>
                    <span>View Orders</span>
                </a>
                <a href="index.php?list_payments">
                    <i class="ph-credit-card"></i>
                    <span>View Payments</span>
                </a>
                <a href="index.php?list_users">
                    <i class="ph-users"></i>
                    <span>View Users</span>
                </a>
            </nav>
            <footer class="footer">
                <h1>Ecommerce <small>©</small></h1>
                <div>
                    Admin Dashboard<br />
                    All Rights Reserved
                </div>
            </footer>
        </div>
        
        <div class="app-body-main-content">
            <div class="dashboard-cards">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Total Products</h3>
                        <i class="ph-package"></i>
                    </div>
                    <h4 class="card-value">
                        <?php 
                        $count_products = "SELECT * FROM `products`";
                        $result_count = mysqli_query($con, $count_products);
                        $num_products = mysqli_num_rows($result_count);
                        echo $num_products;
                        ?>
                    </h4>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Total Categories</h3>
                        <i class="ph-list"></i>
                    </div>
                    <h4 class="card-value">
                        <?php 
                        $count_categories = "SELECT * FROM `categories`";
                        $result_categories = mysqli_query($con, $count_categories);
                        $num_categories = mysqli_num_rows($result_categories);
                        echo $num_categories;
                        ?>
                    </h4>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Total Orders</h3>
                        <i class="ph-shopping-cart"></i>
                    </div>
                    <h4 class="card-value">
                        <?php 
                        $count_orders = "SELECT * FROM `user_orders`";
                        $result_orders = mysqli_query($con, $count_orders);
                        $num_orders = mysqli_num_rows($result_orders);
                        echo $num_orders;
                        ?>
                    </h4>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Total Users</h3>
                        <i class="ph-users"></i>
                    </div>
                    <h4 class="card-value">
                        <?php 
                        $count_users = "SELECT * FROM `user_table`";
                        $result_users = mysqli_query($con, $count_users);
                        $num_users = mysqli_num_rows($result_users);
                        echo $num_users;
                        ?>
                    </h4>
                </div>
            </div>
            
            <div class="control">
                <div class="row align-items-center">
                    <div class="col-md-2">
                        <div class="admin-image">
                            <img src="./admin_images/<?php echo $admin_image;?>" class="img-thumbnail" alt="Admin Photo">
                            <p class="text-center mt-2"><?php echo $admin_name;?></p>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="buttons">
                            <button class="btn btn-outline-primary">
                                <a href="./insert_product.php" class="nav-link">Insert Products</a>
                            </button>
                            <button class="btn btn-outline-primary">
                                <a href="index.php?view_products" class="nav-link">View Products</a>
                            </button>
                            <button class="btn btn-outline-primary">
                                <a href="index.php?insert_category" class="nav-link">Insert Categories</a>
                            </button>
                            <button class="btn btn-outline-primary">
                                <a href="index.php?view_categories" class="nav-link">View Categories</a>
                            </button>
                            <button class="btn btn-outline-primary">
                                <a href="index.php?insert_brand" class="nav-link">Insert Brands</a>
                            </button>
                            <button class="btn btn-outline-primary">
                                <a href="index.php?view_brands" class="nav-link">View Brands</a>
                            </button>
                            <button class="btn btn-outline-primary">
                                <a href="index.php?list_orders" class="nav-link">All Orders</a>
                            </button>
                            <button class="btn btn-outline-primary">
                                <a href="index.php?list_payments" class="nav-link">All Payments</a>
                            </button>
                            <button class="btn btn-outline-primary">
                                <a href="index.php?list_users" class="nav-link">List Users</a>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="change-page">
                <?php
                if(isset($_GET['insert_category'])){
                    include('./insert_categories.php');
                }
                if(isset($_GET['insert_brand'])){
                    include('./insert_brands.php');
                }
                if(isset($_GET['view_products'])){
                    include('./view_products.php');
                }
                if(isset($_GET['edit_product'])){
                    include('./edit_product.php');
                }
                if(isset($_GET['delete_product'])){
                    include('./delete_product.php');
                }
                if(isset($_GET['view_categories'])){
                    include('./view_categories.php');
                }
                if(isset($_GET['edit_category'])){
                    include('./edit_category.php');
                }
                if(isset($_GET['delete_category'])){
                    include('./delete_category.php');
                }
                if(isset($_GET['view_brands'])){
                    include('./view_brands.php');
                }
                if(isset($_GET['edit_brand'])){
                    include('./edit_brand.php');
                }
                if(isset($_GET['delete_brand'])){
                    include('./delete_brand.php');
                }
                if(isset($_GET['list_orders'])){
                    include('./list_orders.php');
                }
                if(isset($_GET['delete_order'])){
                    include('./delete_order.php');
                }
                if(isset($_GET['list_payments'])){
                    include('./list_payments.php');
                }
                if(isset($_GET['delete_payment'])){
                    include('./delete_payment.php');
                }
                if(isset($_GET['list_users'])){
                    include('./list_users.php');
                }
                ?>
            </div>
        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.js"></script>
</body>
</html>