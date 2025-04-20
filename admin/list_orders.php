<?php
if(isset($_POST['update_order_status'])){
    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];
    $update_query = "UPDATE `user_orders` SET order_status='$new_status' WHERE order_id = $order_id";
    $update_result = mysqli_query($con, $update_query);
    
    if($update_result){
        echo "<script>window.alert('Order status updated successfully');</script>";
    } else {
        echo "<script>window.alert('Error updating order status');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styleadmin.css">
</head>

<body>
    <div class="container page-container">
        <div class="page-header">
            <h2 class="page-title">All Orders</h2>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <?php
                    $get_order_query = "SELECT * FROM `user_orders`";
                    $get_order_result = mysqli_query($con, $get_order_query);
                    $row_count = mysqli_num_rows($get_order_result);
                    if($row_count > 0){
                        echo "
                        <tr>
                            <th>Order No.</th>
                            <th>Due Amount</th>
                            <th>Invoice Number</th>
                            <th>Total Products</th>
                            <th>Order Date</th>
                            <th>Status</th>
                            <th>Complete/Incomplete</th>
                            <th>Actions</th>
                        </tr>
                        ";
                    }
                    ?>
                </thead>
                <tbody>
                    <?php
                    if ($row_count == 0) {
                        echo "<tr><td colspan='8' class='text-center py-4'>No orders found</td></tr>";
                    } else {
                        $id_number = 1;
                        while ($row_fetch_orders = mysqli_fetch_array($get_order_result)) {
                            $order_id = $row_fetch_orders['order_id'];
                            $amount_due = $row_fetch_orders['amount_due'];
                            $invoice_number = $row_fetch_orders['invoice_number'];
                            $total_products = $row_fetch_orders['total_products'];
                            $order_date = $row_fetch_orders['order_date'];
                            $order_status = $row_fetch_orders['order_status'];
                            $order_complete = $row_fetch_orders['order_status'] == 'paid' ? 'Complete' : 'Incomplete';
                   
                            $status_badge_class = $order_status == 'paid' ? 'bg-success' : 'bg-warning text-dark';
                            
                            echo "
                            <tr>
                                <td>$id_number</td>
                                <td>$amount_due DT</td>
                                <td>$invoice_number</td>
                                <td>$total_products</td>
                                <td>$order_date</td>
                                <td><span class='badge $status_badge_class'>$order_status</span></td>
                                <td>$order_complete</td>
                                <td>
                                    <div class='d-flex gap-2'>
                                        <button class='btn btn-action btn-view' data-bs-toggle='modal' data-bs-target='#viewModal_$order_id'>
                                            <i class='fas fa-eye'></i>
                                        </button>
                                        <button class='btn btn-action btn-delete' data-bs-toggle='modal' data-bs-target='#deleteModal_$order_id'>
                                            <i class='fas fa-trash'></i>
                                        </button>";
                            

                            if($order_status != 'paid') {
                                echo "
                                        <form method='post' action=''>
                                            <input type='hidden' name='order_id' value='$order_id'>
                                            <input type='hidden' name='new_status' value='paid'>
                                            <button type='submit' name='update_order_status' class='btn btn-action btn-success'>
                                                <i class='fas fa-check'></i>
                                            </button>
                                        </form>";
                            }
                            
                            echo "
                                    </div>

                                    <!-- View Order Modal -->
                                    <div class='modal fade' id='viewModal_$order_id' tabindex='-1' aria-labelledby='viewModal_$order_id.Label' aria-hidden='true'>
                                        <div class='modal-dialog modal-dialog-centered modal-lg'>
                                            <div class='modal-content'>
                                                <div class='modal-header'>
                                                    <h5 class='modal-title' id='viewModal_$order_id.Label'>Order Details</h5>
                                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                                </div>
                                                <div class='modal-body'>
                                                    <div class='row mb-3'>
                                                        <div class='col-md-6'>
                                                            <p><strong>Order ID:</strong> $order_id</p>
                                                            <p><strong>Invoice Number:</strong> $invoice_number</p>
                                                            <p><strong>Order Date:</strong> $order_date</p>
                                                        </div>
                                                        <div class='col-md-6'>
                                                            <p><strong>Amount Due:</strong> $amount_due DT</p>
                                                            <p><strong>Total Products:</strong> $total_products</p>
                                                            <p><strong>Status:</strong> <span class='badge $status_badge_class'>$order_status</span></p>
                                                        </div>
                                                    </div>
                                                    
                                                    <h6 class='mt-4 mb-3'>Products in this Order</h6>
                                                    <div class='table-responsive'>
                                                        <table class='table table-sm table-bordered'>
                                                            <thead class='table-light'>
                                                                <tr>
                                                                    <th>Product</th>
                                                                    <th>Quantity</th>
                                                                    <th>Price</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>";
                                                            

                            $get_items_query = "SELECT * FROM `orders_pending` WHERE invoice_number = '$invoice_number'";
                            $get_items_result = mysqli_query($con, $get_items_query);
                            
                            if(mysqli_num_rows($get_items_result) > 0) {
                                while($item = mysqli_fetch_assoc($get_items_result)) {
                                    $product_id = $item['product_id'];
                                    $quantity = $item['quantity'];
                                    
                                    $get_product_query = "SELECT * FROM `products` WHERE product_id = $product_id";
                                    $get_product_result = mysqli_query($con, $get_product_query);
                                    $product = mysqli_fetch_assoc($get_product_result);
                                    
                                    $product_title = $product ? $product['product_title'] : 'Product not found';
                                    $product_price = $product ? $product['product_price'] : 0;
                                    
                                    echo "
                                    <tr>
                                        <td>$product_title</td>
                                        <td>$quantity</td>
                                        <td>$product_price DT</td>
                                    </tr>
                                    ";
                                }
                            } else {
                                echo "<tr><td colspan='3' class='text-center'>No product details available</td></tr>";
                            }
                            
                            echo "
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class='modal-footer'>
                                                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>";
                            
                          
                            if($order_status != 'paid') {
                                echo "
                                                    <form method='post' action=''>
                                                        <input type='hidden' name='order_id' value='$order_id'>
                                                        <input type='hidden' name='new_status' value='paid'>
                                                        <button type='submit' name='update_order_status' class='btn btn-success'>Mark as Paid</button>
                                                    </form>";
                            }
                            
                            echo "
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class='modal fade' id='deleteModal_$order_id' tabindex='-1' aria-labelledby='deleteModal_$order_id.Label' aria-hidden='true'>
                                        <div class='modal-dialog modal-dialog-centered'>
                                            <div class='modal-content'>
                                                <div class='modal-body'>
                                                    <div class='text-center mb-4'>
                                                        <i class='fas fa-exclamation-circle text-danger' style='font-size: 3rem;'></i>
                                                    </div>
                                                    <h4 class='text-center mt-3'>Are you sure you want to delete this order?</h4>
                                                    <p class='text-center text-muted'>Order #$id_number with invoice number <strong>$invoice_number</strong></p>
                                                    <p class='text-center text-muted'>This action cannot be undone.</p>
                                                    <div class='d-flex justify-content-center gap-3 mt-4'>
                                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
                                                        <a href='index.php?delete_order=$order_id' class='btn btn-danger'>Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            ";

                            $id_number++;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>