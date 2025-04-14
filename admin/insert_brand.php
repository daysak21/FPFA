<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Brand</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styleadmin.css">
</head>
<body>
    <div class="container page-container">
        <div class="page-header">
            <h2 class="page-title">Insert Brand</h2>
            <a href="index.php?view_brands" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="brand_title" class="form-label">Brand Title</label>
                        <input type="text" class="form-control" id="brand_title" name="brand_title" required>
                    </div>
                    <div class="mb-3">
                        <label for="brand_image" class="form-label">Brand Image</label>
                        <input type="file" class="form-control" id="brand_image" name="brand_image" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="insert_brand">Insert Brand</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
include('../includes/connect.php');
if(isset($_POST['insert_brand'])) {
    $brand_title = $_POST['brand_title'];
    
    // Accessing image
    $brand_image = $_FILES['brand_image']['name'];
    $brand_image_tmp = $_FILES['brand_image']['tmp_name'];
    
    // Checking if brand already exists
    $select_query = "SELECT * FROM `brands` WHERE brand_title='$brand_title'";
    $result_select = mysqli_query($con, $select_query);
    $number = mysqli_num_rows($result_select);
    
    if($number > 0) {
        echo "<script>alert('This brand is already present in the database')</script>";
    } else {
        move_uploaded_file($brand_image_tmp, "./brand_images/$brand_image");
        
        // Insert query
        $insert_query = "INSERT INTO `brands` (brand_title, brand_image) VALUES ('$brand_title', '$brand_image')";
        $result = mysqli_query($con, $insert_query);
        
        if($result) {
            echo "<script>alert('Brand has been inserted successfully')</script>";
            echo "<script>window.open('index.php?view_brands', '_self')</script>";
        }
    }
}
?>

<div class="categ-header">
    <div class="sub-title">
        <span class="shape"></span>
        <h2>Insert Brands</h2>
    </div>
</div>

<form action="" method="POST" enctype="multipart/form-data" class="mb-2">
    <div class="input-group w-90 mb-3">
        <span class="input-group-text secondry-1" id="basic-addon1">
            <svg xmlns="http://www.w3.org/2000/svg" height="1em" fill="#ffffff" viewBox="0 0 384 512">
                <path d="M14 2.2C22.5-1.7 32.5-.3 39.6 5.8L80 40.4 120.4 5.8c9-7.7 22.3-7.7 31.2 0L192 40.4 232.4 5.8c9-7.7 22.3-7.7 31.2 0L304 40.4 344.4 5.8c7.1-6.1 17.1-7.5 25.6-3.6s14 12.4 14 21.8V488c0 9.4-5.5 17.9-14 21.8s-18.5 2.5-25.6-3.6L304 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L192 471.6l-40.4 34.6c-9 7.7-22.3 7.7-31.2 0L80 471.6 39.6 506.2c-7.1 6.1-17.1 7.5-25.6 3.6S0 497.4 0 488V24C0 14.6 5.5 6.1 14 2.2zM96 144c-8.8 0-16 7.2-16 16s7.2 16 16 16H288c8.8 0 16-7.2 16-16s-7.2-16-16-16H96zM80 352c0 8.8 7.2 16 16 16H288c8.8 0 16-7.2 16-16s-7.2-16-16-16H96c-8.8 0-16 7.2-16 16zM96 240c-8.8 0-16 7.2-16 16s7.2 16 16 16H288c8.8 0 16-7.2 16-16s-7.2-16-16-16H96z" />
            </svg>
        </span>
        <input type="text" class="form-control" name="brand_title" placeholder="Insert Brand" aria-label="brand" aria-describedby="basic-addon1">
    </div>
    <div class="input-group w-90 mb-3">
        <span class="input-group-text secondry-1" id="basic-addon1">
            <i class="fas fa-image"></i>
        </span>
        <input type="file" class="form-control" name="brand_image" aria-label="brand image" aria-describedby="basic-addon1">
    </div>
    <div class="input-group w-10 mb-3">
        <input type="submit" class="btn btn-primary" name="insert_brand" value="Insert Brand" aria-label="Username" aria-describedby="basic-addon1">
    </div>
</form> 