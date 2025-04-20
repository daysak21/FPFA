<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Payments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styleadmin.css">
</head>

<body>
    <div class="container page-container">
        <div class="page-header">
            <h2 class="page-title">All Payments</h2>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <?php
                    $get_payment_query = "SELECT * FROM `user_payments`";
                    $get_payment_result = mysqli_query($con, $get_payment_query);
                    $row_count = mysqli_num_rows($get_payment_result);
                    if($row_count > 0){
                        echo "
                        <tr>
                            <th>Payment No.</th>
                            <th>Order ID</th>
                            <th>Invoice Number</th>
                            <th>Amount</th>
                            <th>Payment Method</th>
                            <th>Payment Date</th>
                            <th>Actions</th>
                        </tr>
                        ";
                    }
                    ?>
                </thead>
                <tbody>
                    <?php
                    if ($row_count == 0) {
                        echo "<tr><td colspan='7' class='text-center py-4'>No payments found</td></tr>";
                    } else {
                        $id_number = 1;
                        while ($row_fetch_payments = mysqli_fetch_array($get_payment_result)) {
                            $payment_id = $row_fetch_payments['payment_id'];
                            $order_id = $row_fetch_payments['order_id'];
                            $invoice_number = $row_fetch_payments['invoice_number'];
                            $amount = $row_fetch_payments['amount'];
                            $payment_method = $row_fetch_payments['payment_method'];
                            $payment_date = $row_fetch_payments['payment_date'];
                            
                            $method_badge_class = '';
                            switch(strtolower($payment_method)) {
                                case 'credit card':
                                    $method_badge_class = 'bg-primary';
                                    break;
                                case 'paypal':
                                    $method_badge_class = 'bg-info text-dark';
                                    break;
                                case 'cash on delivery':
                                    $method_badge_class = 'bg-success';
                                    break;
                                default:
                                    $method_badge_class = 'bg-secondary';
                            }
                            
                            echo "
                            <tr>
                                <td>$id_number</td>
                                <td>$order_id</td>
                                <td>$invoice_number</td>
                                <td>$amount DT</td>
                                <td><span class='badge $method_badge_class'>$payment_method</span></td>
                                <td>$payment_date</td>
                                <td>
                                    <div class='d-flex gap-2'>
                                        <button class='btn btn-action btn-view' data-bs-toggle='modal' data-bs-target='#viewModal_$payment_id'>
                                            <i class='fas fa-eye'></i>
                                        </button>
                                        <button class='btn btn-action btn-delete' data-bs-toggle='modal' data-bs-target='#deleteModal_$payment_id'>
                                            <i class='fas fa-trash'></i>
                                        </button>
                                    </div>

                                    <!-- View Payment Modal -->
                                    <div class='modal fade' id='viewModal_$payment_id' tabindex='-1' aria-labelledby='viewModal_$payment_id.Label' aria-hidden='true'>
                                        <div class='modal-dialog modal-dialog-centered'>
                                            <div class='modal-content'>
                                                <div class='modal-header'>
                                                    <h5 class='modal-title' id='viewModal_$payment_id.Label'>Payment Details</h5>
                                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                                </div>
                                                <div class='modal-body'>
                                                    <div class='row mb-3'>
                                                        <div class='col-md-6'>
                                                            <p><strong>Payment ID:</strong> $payment_id</p>
                                                            <p><strong>Order ID:</strong> $order_id</p>
                                                            <p><strong>Invoice Number:</strong> $invoice_number</p>
                                                        </div>
                                                        <div class='col-md-6'>
                                                            <p><strong>Amount:</strong> $amount DT</p>
                                                            <p><strong>Payment Method:</strong> <span class='badge $method_badge_class'>$payment_method</span></p>
                                                            <p><strong>Payment Date:</strong> $payment_date</p>
                                                        </div>
                                                    </div>";
                                                    

                            $get_order_query = "SELECT * FROM `user_orders` WHERE order_id = $order_id";
                            $get_order_result = mysqli_query($con, $get_order_query);
                            
                            if(mysqli_num_rows($get_order_result) > 0) {
                                $order = mysqli_fetch_assoc($get_order_result);
                                $order_status = $order['order_status'];
                                $total_products = $order['total_products'];
                                
                                $status_badge_class = $order_status == 'paid' ? 'bg-success' : 'bg-warning text-dark';
                                
                                echo "
                                                    <h6 class='mt-4 mb-3'>Related Order Information</h6>
                                                    <div class='table-responsive'>
                                                        <table class='table table-sm table-bordered'>
                                                            <tr>
                                                                <th>Order Status</th>
                                                                <td><span class='badge $status_badge_class'>$order_status</span></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Total Products</th>
                                                                <td>$total_products</td>
                                                            </tr>
                                                        </table>
                                                    </div>";
                            }
                            
                            echo "
                                                </div>
                                                <div class='modal-footer'>
                                                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                                    <a href='index.php?list_orders' class='btn btn-primary'>View Related Order</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class='modal fade' id='deleteModal_$payment_id' tabindex='-1' aria-labelledby='deleteModal_$payment_id.Label' aria-hidden='true'>
                                        <div class='modal-dialog modal-dialog-centered'>
                                            <div class='modal-content'>
                                                <div class='modal-body'>
                                                    <div class='text-center mb-4'>
                                                        <i class='fas fa-exclamation-circle text-danger' style='font-size: 3rem;'></i>
                                                    </div>
                                                    <h4 class='text-center mt-3'>Are you sure you want to delete this payment?</h4>
                                                    <p class='text-center text-muted'>Payment #$id_number with invoice number <strong>$invoice_number</strong></p>
                                                    <p class='text-center text-muted'>This action cannot be undone.</p>
                                                    <div class='d-flex justify-content-center gap-3 mt-4'>
                                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
                                                        <a href='index.php?delete_payment=$payment_id' class='btn btn-danger'>Delete</a>
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