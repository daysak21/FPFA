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
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.css" />
    <link rel="stylesheet" href="styleadmin.css" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark admin-navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Admin Dashboard</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContentad">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContentad">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <span class="me-2 d-none d-lg-inline text-white"><?php echo $admin_name; ?></span>
                            <img class="img-profile rounded-circle" src="./admin_images/<?php echo $admin_image; ?>" width="40">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user fa-sm fa-fw me-2"></i> Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cogs fa-sm fa-fw me-2"></i> Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="./admin_logout.php"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <div class="admin-profile">
                    <img src="./admin_images/<?php echo $admin_image; ?>" alt="Admin Photo">
                    <h4><?php echo $admin_name; ?></h4>
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
            <!-- End Sidebar -->

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <?php if(!isset($_GET) || empty($_GET)): ?>
                    <h1 class="page-title">Dashboard Overview</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </nav>
                    
                    <!-- Dashboard Cards -->
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
                    
                    <!-- Recent Orders -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Recent Orders
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>User</th>
                                            <th>Amount</th>
                                            <th>Invoice</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $get_orders = "SELECT * FROM `user_orders` ORDER BY order_date DESC LIMIT 5";
                                            $result_orders = mysqli_query($con, $get_orders);
                                            while($row_orders = mysqli_fetch_assoc($result_orders)) {
                                                $order_id = $row_orders['order_id'];
                                                $user_id = $row_orders['user_id'];
                                                $amount = $row_orders['amount_due'];
                                                $invoice = $row_orders['invoice_number'];
                                                $order_date = $row_orders['order_date'];
                                                $order_status = $row_orders['order_status'];
                                                
                                                // Get user details
                                                $get_user = "SELECT * FROM `user_table` WHERE user_id='$user_id'";
                                                $result_user = mysqli_query($con, $get_user);
                                                $row_user = mysqli_fetch_assoc($result_user);
                                                $username = $row_user['username'];
                                                
                                                echo "<tr>
                                                    <td>$order_id</td>
                                                    <td>$username</td>
                                                    <td>$amount</td>
                                                    <td>$invoice</td>
                                                    <td>$order_date</td>
                                                    <td><span class='badge badge-success'>$order_status</span></td>
                                                </tr>";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Changed Page Content -->
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
                <?php endif; ?>
            </div>
            <!-- End Main Content -->
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="../assets/js/bootstrap.bundle.js"></script>
    <!-- Custom JS -->
    <script>
        // Activate the current nav link based on URL
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.nav-link');
            const currentUrl = window.location.href;
            
            navLinks.forEach(link => {
                if (link.href === currentUrl) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>

</html>