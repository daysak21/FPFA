<?php
include('../includes/connect.php');
session_start();
if(!isset($_SESSION['admin_username'])){
    echo "<script>window.open('./admin_login.php','_self');</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Management Panel</title>
    <link rel="stylesheet" href="styleB.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>
    <!-- Centered Floating Panel -->
    <div class="floating-panel-container">
        <div class="floating-panel">
            <div class="panel-header">
                <span>Orders Management</span>
                <button class="close-btn"  onclick="window.history.back()">×</button>
            </div>
            <div class="panel-content">
                <table class="orders-table">
                    <thead>
                        <?php
                        $get_order_query = "SELECT * FROM `user_orders`";
                        $get_order_result = mysqli_query($con, $get_order_query);
                        $row_count = mysqli_num_rows($get_order_result);
                        
                        if($row_count != 0) {
                            echo "
                            <tr>
                                <th>Order No.</th>
                                <th>Amount Due</th>
                                <th>Invoice Number</th>
                                <th>Total Products</th>
                                <th>Order Date</th>
                                <th>Status</th>
                                <th>Completion</th>
                                <th>Actions</th>
                            </tr>
                            ";
                        }
                        ?>
                    </thead>
                    <tbody>
                        <?php
                        if ($row_count == 0) {
                            echo '<tr><td colspan="8" style="text-align: center; padding: 20px;">No orders found</td></tr>';
                        } else {
                            $id_number = 1;
                            while ($row_fetch_orders = mysqli_fetch_array($get_order_result)) {
                                $order_id = $row_fetch_orders['order_id'];
                                $amount_due = $row_fetch_orders['amount_due'];
                                $invoice_number = $row_fetch_orders['invoice_number'];
                                $total_products = $row_fetch_orders['total_products'];
                                $order_date = $row_fetch_orders['order_date'];
                                $order_status = $row_fetch_orders['order_status'];
                                $is_complete = $row_fetch_orders['order_status'] == 'paid';
                                
                                $status_class = $order_status == 'paid' ? 'badge-complete' : 'badge-pending';
                                $completion_class = $is_complete ? 'badge-complete' : 'badge-incomplete';
                                $completion_text = $is_complete ? 'Complete' : 'Incomplete';
                                
                                echo "
                                <tr>
                                    <td>$id_number</td>
                                    <td>$amount_due DH</td>
                                    <td>$invoice_number</td>
                                    <td>$total_products</td>
                                    <td>$order_date</td>
                                    <td><span class='status-badge $status_class'>$order_status</span></td>
                                    <td><span class='status-badge $completion_class'>$completion_text</span></td>
                                    <td>
                                        <button class='action-btn btn-delete' onclick=\"showDeleteModal('$order_id', '$id_number')\">
                                            <i class='bi bi-trash'></i>
                                            Delete
                                        </button>
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
    </div>
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center">
                        <div class="mb-4">
                            <i class="bi bi-exclamation-triangle-fill text-danger modal-icon"></i>
                        </div>
                        <h3 class="mb-3">Are you sure?</h3>
                        <p class="text-muted">Do you really want to delete this order? This action cannot be undone.</p>
                        <div class="modal-buttons">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <a id="confirmDeleteBtn" href="#" class="btn btn-danger">
                                <i class="bi bi-trash"></i> Delete
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Show delete confirmation modal
        function showDeleteModal(orderId, orderNumber) {
            // Set the delete URL
            document.getElementById('confirmDeleteBtn').href = `index.php?delete_order=${orderId}`;
            
            // Show the modal (using Bootstrap)
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>