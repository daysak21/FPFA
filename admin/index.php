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
    <title>Admin Dashboard - FPFAA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="styleadmin.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 sidebar">
                <div class="position-sticky pt-3">
                    <div class="admin-profile text-center mb-4">
                        <img src="1.jpg" alt="Admin Photo" class="rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover;">
                        <h4 class="text-white"><?php echo $admin_name; ?></h4>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link <?php echo !isset($_GET) || empty($_GET) ? 'active' : ''; ?>" href="index.php">
                                <i class="fas fa-fw fa-tachometer-alt"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo isset($_GET['list_users']) ? 'active' : ''; ?>" href="index.php?list_users">
                                <i class="fas fa-fw fa-users"></i>
                                <span>List Users</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo isset($_GET['view_products']) ? 'active' : ''; ?>" href="index.php?view_products">
                                <i class="fas fa-fw fa-boxes"></i>
                                <span>View Products</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo isset($_GET['view_categories']) ? 'active' : ''; ?>" href="index.php?view_categories">
                                <i class="fas fa-fw fa-list"></i>
                                <span>View Categories</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo isset($_GET['view_brands']) ? 'active' : ''; ?>" href="index.php?view_brands">
                                <i class="fas fa-fw fa-barcode"></i>
                                <span>View Brands</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo isset($_GET['list_orders']) ? 'active' : ''; ?>" href="index.php?list_orders">
                                <i class="fas fa-fw fa-shopping-cart"></i>
                                <span>All Orders</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo isset($_GET['list_payments']) ? 'active' : ''; ?>" href="index.php?list_payments">
                                <i class="fas fa-fw fa-credit-card"></i>
                                <span>All Payments</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-9 col-lg-10 main-content">
                <?php if(!isset($_GET) || empty($_GET)): ?>
                    <div class="welcome-section">
                        <h2>Welcome, <?php echo $admin_name; ?>!</h2>
                        <p class="mb-0">Here's what's happening with your store today.</p>
                    </div>

                    <div class="row">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card dashboard-card card-primary h-100">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="card-title">TOTAL PRODUCTS</div>
                                            <div class="card-value">
                                                <?php 
                                                    $count_products = "SELECT * FROM `products`";
                                                    $result_count = mysqli_query($con, $count_products);
                                                    $row_count = mysqli_num_rows($result_count);
                                                    echo $row_count;
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-boxes card-icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card dashboard-card card-success h-100">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="card-title">TOTAL CATEGORIES</div>
                                            <div class="card-value">
                                                <?php 
                                                    $count_categories = "SELECT * FROM `categories`";
                                                    $result_categories = mysqli_query($con, $count_categories);
                                                    $row_categories = mysqli_num_rows($result_categories);
                                                    echo $row_categories;
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-tags card-icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card dashboard-card card-warning h-100">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="card-title">TOTAL BRANDS</div>
                                            <div class="card-value">
                                                <?php 
                                                    $count_brands = "SELECT * FROM `brands`";
                                                    $result_brands = mysqli_query($con, $count_brands);
                                                    $row_brands = mysqli_num_rows($result_brands);
                                                    echo $row_brands;
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-copyright card-icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card dashboard-card card-danger h-100">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="card-title">TOTAL ORDERS</div>
                                            <div class="card-value">
                                                <?php 
                                                    $count_orders = "SELECT * FROM `user_orders`";
                                                    $result_orders = mysqli_query($con, $count_orders);
                                                    $row_orders = mysqli_num_rows($result_orders);
                                                    echo $row_orders;
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-shopping-cart card-icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="chart-container">
                                <h4>Sales Overview</h4>
                                <canvas id="salesChart"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="chart-container">
                                <h4>Product Categories</h4>
                                <canvas id="categoryChart"></canvas>
                            </div>
                        </div>
                    </div>

                    
                <?php else: ?>
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
                            $brand_id = $_GET['delete_brand'];
                            $delete_query = "DELETE FROM `brands` WHERE brand_id=$brand_id";
                            $result = mysqli_query($con, $delete_query);
                            if($result) {
                                echo "<script>alert('Brand has been deleted successfully')</script>";
                                echo "<script>window.open('index.php?view_brands', '_self')</script>";
                            }
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
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.js"></script>
    <script>
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Sales',
                    data: [12000, 19000, 15000, 25000, 22000, 30000],
                    borderColor: '#6c5ce7',
                    tension: 0.4,
                    fill: true,
                    backgroundColor: 'rgba(108, 92, 231, 0.1)'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: ['Laptops', 'Camera', '	Smartwatches', 'HeadPhones', 'Phones'],
                datasets: [{
                    data: [30, 25, 15, 20, 10],
                    backgroundColor: [
                        '#6c5ce7',
                        '#fd79a8',
                        '#00cec9',
                        '#fdcb6e',
                        '#a29bfe'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });
    </script>
</body>

</html>