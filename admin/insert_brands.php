<?php 
    include('../includes/connect.php');
    if(isset($_POST['insert_brand_title'])){
        $brand_title=$_POST['brand_title'];
        $select_query="SELECT * FROM `brands` WHERE brand_title = '$brand_title'";
        $select_result=mysqli_query($con,$select_query);
        $numOfResults=mysqli_num_rows($select_result);
        if($numOfResults>0){
            echo "<script>alert('This Brand is already in DataBase');</script>";
        }else{
                $insert_query="INSERT INTO `brands` (brand_title) VALUES ('$brand_title')";
                $insert_result=mysqli_query($con,$insert_query);
                if ($insert_result){
                    echo "<script>alert('Brand has been inserted successfully');</script>";
                }
            
        }
    }
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="text-center mb-4">Insert Brand</h1>
            <form action="" method="POST" class="d-flex flex-column gap-3 mb-3">
                <div class="form-outline">
                    <label for="brand_title" class="form-label">Brand Title</label>
                    <input type="text" class="form-control" name="brand_title" id="brand_title" placeholder="Insert Brand Title" required>
                </div>
                <div class="form-outline text-center">
                    <input type="submit" class="btn btn-primary" name="insert_brand_title" value="Insert Brand">
                </div>
            </form>
        </div>
    </div>
</div>
