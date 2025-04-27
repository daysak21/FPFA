<?php
include('../includes/connect.php');

if(isset($_POST['insert_product'])){
    $product_title=$_POST['product_title'];
    $product_description=$_POST['product_description'];
    $product_keywords=$_POST['product_keywords'];
    $product_category=$_POST['product_category'];
    $product_brand=$_POST['product_brand'];
    $product_price=$_POST['product_price'];
    $product_status='true';
    
 
    $product_image_one=$_FILES['product_image_one']['name'];
    $product_image_two=$_FILES['product_image_two']['name'];
    $product_image_three=$_FILES['product_image_three']['name'];
    

    $temp_image_one=$_FILES['product_image_one']['tmp_name'];
    $temp_image_two=$_FILES['product_image_two']['tmp_name'];
    $temp_image_three=$_FILES['product_image_three']['tmp_name'];

    if($product_title == '' || $product_description == '' || $product_keywords == '' || $product_category == '' || $product_brand == '' || empty($product_price) || empty($product_image_one) || empty($product_image_two) || empty($product_image_three)){
        echo "<script>alert(\"Fields should not be empty\");</script>";
        exit();
    }else{
 
        move_uploaded_file($temp_image_one,"./product_images/$product_image_one");
        move_uploaded_file($temp_image_two,"./product_images/$product_image_two");
        move_uploaded_file($temp_image_three,"./product_images/$product_image_three");
        

        $insert_query = "INSERT INTO `products` (product_title,product_description,product_keywords,category_id,brand_id,product_image_one,product_image_two,product_image_three,product_price,date,status) VALUES ('$product_title','$product_description','$product_keywords','$product_category','$product_brand','$product_image_one','$product_image_two','$product_image_three','$product_price',NOW(),'$product_status')";
        $insert_result=mysqli_query($con,$insert_query);
        
        if($insert_result){
            echo "<script>alert(\"Product Inserted Successfully\");</script>";
            echo "<script>window.location.href='index.php?view_products';</script>";
        }
    }
}

if(!isset($_POST['insert_product'])) {
    header("Location: index.php?view_products");
    exit();
}
?>