<?php
include('../includes/connect.php');
include('../functions/common_functions.php');

if(isset($_GET['delete_category'])){
    $delete_id = mysqli_real_escape_string($con, $_GET['delete_category']);
    
    // First check if category exists
    $check_query = "SELECT * FROM `categories` WHERE category_id = '$delete_id'";
    $check_result = mysqli_query($con, $check_query);
    
    if(mysqli_num_rows($check_result) > 0) {
        // Check if there are any products in this category
        $check_products = "SELECT * FROM `products` WHERE category_id = '$delete_id'";
        $products_result = mysqli_query($con, $check_products);
        
        if(mysqli_num_rows($products_result) > 0) {
            echo "<script>alert('Cannot delete category. There are products associated with this category.');</script>";
            echo "<script>window.open('index.php?view_categories','_self');</script>";
        } else {
            // Delete the category
            $delete_query = "DELETE FROM `categories` WHERE category_id = '$delete_id'";
            $delete_result = mysqli_query($con, $delete_query);
            
            if($delete_result){
                echo "<script>alert('Category deleted successfully');</script>";
                echo "<script>window.open('index.php?view_categories','_self');</script>";
            } else {
                echo "<script>alert('Error deleting category: " . mysqli_error($con) . "');</script>";
                echo "<script>window.open('index.php?view_categories','_self');</script>";
            }
        }
    } else {
        echo "<script>alert('Category not found');</script>";
        echo "<script>window.open('index.php?view_categories','_self');</script>";
    }
}
?>