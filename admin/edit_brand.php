<?php
if(isset($_POST['update_brand'])){
    $edit_id = $_POST['brand_id'];
    $brand_title = $_POST['brand_title'];
    if(empty($brand_title)){
        echo "<script>window.alert('Please fill the field');</script>";
        echo "<script>window.location.href='index.php?view_brands';</script>";
    } else {
        $update_brand_query = "UPDATE `brands` SET brand_title='$brand_title' WHERE brand_id = $edit_id";
        $update_brand_result = mysqli_query($con, $update_brand_query);
        if($update_brand_result){
            echo "<script>window.alert('Brand updated successfully');</script>";
            echo "<script>window.location.href='index.php?view_brands';</script>";
        }
    }
}

if(!isset($_POST['update_brand'])) {
    header("Location: index.php?view_brands");
    exit();
}
?>