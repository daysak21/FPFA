<?php
if (isset($_GET['delete_user'])) {
    $delete_id = intval($_GET['delete_user']); // Ensure it's an integer for safety

    if (!$con) {
        die("Database connection failed");
    }

    // Fetch user image
    $get_image_query = "SELECT user_image FROM user_table WHERE user_id = $delete_id";
    $get_image_result = mysqli_query($con, $get_image_query);

    if ($get_image_result && mysqli_num_rows($get_image_result) > 0) {
        $row = mysqli_fetch_assoc($get_image_result);
        $user_image = $row['user_image'];

        // Delete image if it exists
        if (!empty($user_image) && file_exists("user_images/$user_image")) {
            unlink("user_images/$user_image");
        }

        // Delete user from database
        $delete_query = "DELETE FROM `user_table` WHERE user_id = $delete_id";
        $delete_result = mysqli_query($con, $delete_query);

        if ($delete_result) {
            echo "<script>alert('User deleted successfully');</script>";
            echo "<script>window.location.href = 'index.php?list_users';</script>";
        } else {
            echo "<script>alert('Failed to delete user');</script>";
        }
    } else {
        echo "<script>alert('User not found');</script>";
    }
}
?>