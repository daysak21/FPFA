<?php
include('../includes/connect.php');
include('../functions/common_functions.php');
session_start();

// Check if user ID is provided
if (!isset($_GET['user_id'])) {
    echo "<script>alert('User ID not specified')</script>";
    echo "<script>window.open('index.php?view_users','_self')</script>";
    exit();
}

$user_id = $_GET['user_id'];

// Get user information
$select_query = "SELECT * FROM user_table WHERE user_id='$user_id'";
$result_query = mysqli_query($con, $select_query);
$row_fetch = mysqli_fetch_assoc($result_query);

if (!$row_fetch) {
    echo "<script>alert('User not found')</script>";
    echo "<script>window.open('index.php?view_users','_self')</script>";
    exit();
}

// Process form
if (isset($_POST['update_user'])) {
    $username = $_POST['username'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
    $user_address = $_POST['user_address'];
    $user_mobile = $_POST['user_mobile'];
    
    // Check if email already exists for another user
    $check_email = "SELECT * FROM user_table WHERE user_email='$user_email' AND user_id!='$user_id'";
    $result_check = mysqli_query($con, $check_email);
    
    if (mysqli_num_rows($result_check) > 0) {
        echo "<script>alert('This email is already used by another user')</script>";
    } else {
        // Update user information
        $update_query = "UPDATE user_table SET 
            username='$username',
            user_email='$user_email',
            user_password='$user_password',
            user_address='$user_address',
            user_mobile='$user_mobile'
            WHERE user_id='$user_id'";
            
        $result_update = mysqli_query($con, $update_query);
        
        if ($result_update) {
            echo "<script>alert('User updated successfully')</script>";
            echo "<script>window.open('index.php?view_users','_self')</script>";
        } else {
            echo "<script>alert('Error updating user')</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <!-- Link to your custom CSS -->
    <link rel="stylesheet" href="styleadmin.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="add-user-form-container mt-5">
        <h2 class="text-center mb-4">Edit User</h2>
        <form action="" method="post" class="w-50 m-auto">
            <div class="form-outline mb-4">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" name="username" class="form-control" value="<?php echo $row_fetch['username']; ?>" required>
            </div>

            <div class="form-outline mb-4">
                <label for="user_email" class="form-label">Email</label>
                <input type="email" id="user_email" name="user_email" class="form-control" value="<?php echo $row_fetch['user_email']; ?>" required>
            </div>

            <div class="form-outline mb-4">
                <label for="user_password" class="form-label">Password</label>
                <input type="password" id="user_password" name="user_password" class="form-control" value="<?php echo $row_fetch['user_password']; ?>" required>
            </div>

            <div class="form-outline mb-4">
                <label for="user_address" class="form-label">Address</label>
                <input type="text" id="user_address" name="user_address" class="form-control" value="<?php echo $row_fetch['user_address']; ?>" required>
            </div>

            <div class="form-outline mb-4">
                <label for="user_mobile" class="form-label">Phone Number</label>
                <input type="text" id="user_mobile" name="user_mobile" class="form-control" value="<?php echo $row_fetch['user_mobile']; ?>" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary px-4 me-2 mb-2" name="update_user">
                    <i class="fas fa-save me-2"></i>Update
                </button>
                <a href="index.php?list_users" class="btn btn-secondary px-4 mb-2">
                    <i class="fas fa-times me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>