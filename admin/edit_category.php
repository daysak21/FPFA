<?php
if(isset($_POST['update_category'])){
    $edit_id = $_POST['category_id'];
    $category_title = $_POST['category_title'];
    if(empty($category_title)){
        echo "<script>window.alert('Please fill the field');</script>";
        echo "<script>window.location.href='index.php?view_categories';</script>";
    } else {
        $update_category_query = "UPDATE `categories` SET category_title='$category_title' WHERE category_id = $edit_id";
        $update_category_result = mysqli_query($con, $update_category_query);
        
        if($update_category_result){
            echo "<script>window.alert('Category updated successfully');</script>";
            echo "<script>window.location.href='index.php?view_categories';</script>";
        }
    }
}

if(!isset($_POST['update_category'])) {
    header("Location: index.php?view_categories");
    exit();
}
?>