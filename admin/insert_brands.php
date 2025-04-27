<?php 
include('../includes/connect.php');

if(isset($_POST['insert_brand_title'])){
    $brand_title = $_POST['brand_title'];
    $select_query = "SELECT * FROM `brands` WHERE brand_title = '$brand_title'";
    $select_result = mysqli_query($con, $select_query);
    $numOfResults = mysqli_num_rows($select_result);
    
    if($numOfResults > 0){
        echo "<script>alert('This Brand is already in DataBase');</script>";
        echo "<script>window.location.href='index.php?view_brands';</script>";
    } else {
        $insert_query = "INSERT INTO `brands` (brand_title) VALUES ('$brand_title')";
        $insert_result = mysqli_query($con, $insert_query);
        
        if ($insert_result){
            echo "<script>alert('Brand has been inserted successfully');</script>";
            echo "<script>window.location.href='index.php?view_brands';</script>";
        }
    }
}

if(!isset($_POST['insert_brand_title'])) {
    header("Location: index.php?view_brands");
    exit();
}
?>