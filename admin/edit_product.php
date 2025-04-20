<?php
if(isset($_POST['update_product'])){
    $edit_id = $_POST['edit_id'];
    $product_title = $_POST['product_title'];
    $product_description = $_POST['product_description'];
    $product_keywords = $_POST['product_keywords'];
    $product_category_id = $_POST['product_category'];
    $product_brand_id = $_POST['product_brand'];
    
    $product_image_one_old = $_POST['product_image_one_old'];
    $product_image_two_old = $_POST['product_image_two_old'];
    $product_image_three_old = $_POST['product_image_three_old'];
    
    $product_image_one = $_FILES['product_image_one']['name'] == '' ? $product_image_one_old : $_FILES['product_image_one']['name'];
    $product_image_one_tmp = $_FILES['product_image_one']['tmp_name'];
    $product_image_two = $_FILES['product_image_two']['name'] == '' ? $product_image_two_old : $_FILES['product_image_two']['name'];
    $product_image_two_tmp = $_FILES['product_image_two']['tmp_name'];
    $product_image_three = $_FILES['product_image_three']['name'] == '' ? $product_image_three_old : $_FILES['product_image_three']['name'];
    $product_image_three_tmp = $_FILES['product_image_three']['tmp_name'];
    $product_price = $_POST['product_price'];
  
    if(empty($product_title) || empty($product_description) || empty($product_keywords) || empty($product_category_id) || empty($product_brand_id) || empty($product_price)){
        echo "<script>window.alert('Please fill all required fields');</script>";
    }else{
        if($_FILES['product_image_one']['name'] != '') {
            move_uploaded_file($product_image_one_tmp,"./product_images/$product_image_one");
        }
        if($_FILES['product_image_two']['name'] != '') {
            move_uploaded_file($product_image_two_tmp,"./product_images/$product_image_two");
        }
        if($_FILES['product_image_three']['name'] != '') {
            move_uploaded_file($product_image_three_tmp,"./product_images/$product_image_three");
        }
        

        $update_product_query = "UPDATE `products` SET 
            category_id=$product_category_id,
            brand_id=$product_brand_id,
            product_title='$product_title',
            product_description='$product_description',
            product_keywords='$product_keywords',
            product_image_one='$product_image_one',
            product_image_two='$product_image_two',
            product_image_three='$product_image_three',
            product_price='$product_price',
            date=NOW() 
            WHERE product_id = $edit_id";
        $update_product_result = mysqli_query($con,$update_product_query);
        if($update_product_result){
            echo "<script>window.alert('Product updated successfully');</script>";
            echo "<script>window.location.href='index.php?view_products';</script>";
        }
    }
}
?>