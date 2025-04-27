<?php
include('../includes/connect.php');


if (isset($_POST['insert_categ_title'])) {
    $category_title = $_POST['categ_title'];
    $select_query = "SELECT * FROM `categories` WHERE category_title = '$category_title'";
    $select_result = mysqli_query($con,$select_query);
    $numOfResults = mysqli_num_rows($select_result);
    
    if ($numOfResults > 0) {
        echo "<script>alert('Category is already in Database');</script>";
        echo "<script>window.location.href='index.php?view_categories';</script>";
    } else {
        $insert_query = "INSERT INTO `categories` (category_title) VALUES ('$category_title')";
        $insert_result = mysqli_query($con, $insert_query);
        
        if ($insert_result){
            echo "<script>alert('Category has been inserted successfully');</script>";
            echo "<script>window.location.href='index.php?view_categories';</script>";
        }
    }
}

if(!isset($_POST['insert_categ_title'])) {
    header("Location: index.php?view_categories");
    exit();
}
?>