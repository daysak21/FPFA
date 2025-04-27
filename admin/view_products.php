<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styleadmin.css">
</head>

<body>
    <div class="container page-container">
        <div class="page-header">
            <h2 class="page-title">All Products</h2>
            <button class="btn btn-insert" data-bs-toggle="modal" data-bs-target="#addProductModal">
                <i class="fas fa-plus"></i>Add Product
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <?php
                    $get_products = "SELECT * FROM `products`";
                    $result = mysqli_query($con, $get_products);
                    $row_count = mysqli_num_rows($result);
                    if($row_count > 0){
                        echo "
                        <tr>
                            <th>Product ID</th>
                            <th>Title</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        ";
                    }
                    ?>
                </thead>
                <tbody>
                    <?php
                    if($row_count == 0){
                        echo "<tr><td colspan='6' class='text-center py-4'>No products found</td></tr>";
                    } else {
                        while($row = mysqli_fetch_assoc($result)){
                            $product_id = $row['product_id'];
                            $product_title = $row['product_title'];
                            $product_image1 = $row['product_image_one'];
                            $product_price = $row['product_price'];
                            $status = $row['status'];
                            $get_product_details = "SELECT * FROM `products` WHERE product_id = $product_id";
                            $product_details_result = mysqli_query($con, $get_product_details);
                            $product_details = mysqli_fetch_assoc($product_details_result);
                            $product_description = $product_details['product_description'];
                            $product_keywords = $product_details['product_keywords'];
                            $category_id = $product_details['category_id'];
                            $brand_id = $product_details['brand_id'];
                            $product_image_two = $product_details['product_image_two'];
                            $product_image_three = $product_details['product_image_three'];
                            
                            echo "
                            <tr>
                                <td>$product_id</td>
                                <td>$product_title</td>
                                <td>
                                    <img src='./product_images/$product_image1' class='thumbnail-image' alt='$product_title'/>
                                </td>
                                <td>$product_price DT</td>
                                <td>$status</td>
                                <td>
                                    <div class='d-flex gap-2'>
                                        <!-- Edit Button (opens modal) -->
                                        <button class='btn btn-action btn-edit' data-bs-toggle='modal' data-bs-target='#editModal_$product_id'>
                                            <i class='fas fa-edit'></i>
                                        </button>
                                        <button class='btn btn-action btn-delete' data-bs-toggle='modal' data-bs-target='#deleteModal_$product_id'>
                                            <i class='fas fa-trash'></i>
                                        </button>
                                    </div>
                        
                                    <!-- Edit Modal -->
                                    <div class='modal fade' id='editModal_$product_id' tabindex='-1' aria-labelledby='editModal_$product_id.Label' aria-hidden='true'>
                                        <div class='modal-dialog modal-dialog-centered modal-lg'>
                                            <div class='modal-content'>
                                                <div class='modal-header'>
                                                    <h5 class='modal-title' id='editModal_$product_id.Label'>Edit Product</h5>
                                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                                </div>
                                                <form action='' method='post' enctype='multipart/form-data'>
                                                    <div class='modal-body'>
                                                        <input type='hidden' name='edit_id' value='$product_id'>
                                                        
                                                        <div class='mb-3'>
                                                            <label for='product_title_$product_id' class='form-label'>Product Title</label>
                                                            <input type='text' name='product_title' id='product_title_$product_id' class='form-control' required value='$product_title'>
                                                        </div>
                                                        
                                                        <div class='mb-3'>
                                                            <label for='product_description_$product_id' class='form-label'>Product Description</label>
                                                            <input type='text' name='product_description' id='product_description_$product_id' class='form-control' required value='$product_description'>
                                                        </div>
                                                        
                                                        <div class='mb-3'>
                                                            <label for='product_keywords_$product_id' class='form-label'>Product Keywords</label>
                                                            <input type='text' name='product_keywords' id='product_keywords_$product_id' class='form-control' required value='$product_keywords'>
                                                        </div>
                                                        
                                                        <div class='mb-3'>
                                                            <label for='product_category_$product_id' class='form-label'>Product Category</label>
                                                            <select name='product_category' id='product_category_$product_id' class='form-select' required>
                                                                ";
                                                                $select_category_query_all = "SELECT * FROM `categories`";
                                                                $select_category_result_all = mysqli_query($con,$select_category_query_all);
                                                                while($fetch_category_name_all = mysqli_fetch_array($select_category_result_all)){
                                                                    $category_name_is_all = $fetch_category_name_all['category_title'];
                                                                    $category_id_is_all = $fetch_category_name_all['category_id'];
                                                                    echo $category_id_is_all == $category_id ? "
                                                                    <option value='$category_id_is_all' selected>$category_name_is_all</option>
                                                                " : "
                                                                <option value='$category_id_is_all'>$category_name_is_all</option>
                                                            ";
                                                                }
                                                                echo "
                                                            </select>
                                                        </div>
                                                        
                                                        <div class='mb-3'>
                                                            <label for='product_brand_$product_id' class='form-label'>Product Brand</label>
                                                            <select name='product_brand' id='product_brand_$product_id' class='form-select' required>
                                                                ";
                                                                $select_brand_query_all = "SELECT * FROM `brands`";
                                                                $select_brand_result_all = mysqli_query($con,$select_brand_query_all);
                                                                while($fetch_brand_name_all = mysqli_fetch_array($select_brand_result_all)){
                                                                    $brand_name_is_all = $fetch_brand_name_all['brand_title'];
                                                                    $brand_id_is_all = $fetch_brand_name_all['brand_id'];
                                                                    echo $brand_id_is_all == $brand_id ? "
                                                                    <option value='$brand_id_is_all' selected>$brand_name_is_all</option>
                                                                " : "
                                                                <option value='$brand_id_is_all'>$brand_name_is_all</option>
                                                            ";
                                                                }
                                                                echo "
                                                            </select>
                                                        </div>
                                                        
                                                        <div class='mb-3'>
                                                            <label for='product_image_one_$product_id' class='form-label'>Product Image 1</label>
                                                            <div class='d-flex align-items-center gap-2'>
                                                                <input type='file' name='product_image_one' id='product_image_one_$product_id' class='form-control'>
                                                                <img src='./product_images/$product_image1' alt='$product_title' class='img-thumbnail' width='60px' height='60px'>
                                                            </div>
                                                            <input type='hidden' name='product_image_one_old' value='$product_image1'>
                                                        </div>
                                                        
                                                        <div class='mb-3'>
                                                            <label for='product_image_two_$product_id' class='form-label'>Product Image 2</label>
                                                            <div class='d-flex align-items-center gap-2'>
                                                                <input type='file' name='product_image_two' id='product_image_two_$product_id' class='form-control'>
                                                                <img src='./product_images/$product_image_two' alt='$product_title' class='img-thumbnail' width='60px' height='60px'>
                                                            </div>
                                                            <input type='hidden' name='product_image_two_old' value='$product_image_two'>
                                                        </div>
                                                        
                                                        <div class='mb-3'>
                                                            <label for='product_image_three_$product_id' class='form-label'>Product Image 3</label>
                                                            <div class='d-flex align-items-center gap-2'>
                                                                <input type='file' name='product_image_three' id='product_image_three_$product_id' class='form-control'>
                                                                <img src='./product_images/$product_image_three' alt='$product_title' class='img-thumbnail' width='60px' height='60px'>
                                                            </div>
                                                            <input type='hidden' name='product_image_three_old' value='$product_image_three'>
                                                        </div>
                                                        
                                                        <div class='mb-3'>
                                                            <label for='product_price_$product_id' class='form-label'>Product Price</label>
                                                            <input type='number' name='product_price' id='product_price_$product_id' class='form-control' required value='$product_price'>
                                                        </div>
                                                    </div>
                                                    <div class='modal-footer'>
                                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
                                                        <button type='submit' name='update_product' class='btn btn-primary'>Update Product</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                        
                                    <!-- Delete Modal -->
                                    <div class='modal fade' id='deleteModal_$product_id' tabindex='-1' aria-labelledby='deleteModal_$product_id.Label' aria-hidden='true'>
                                        <div class='modal-dialog modal-dialog-centered'>
                                            <div class='modal-content'>
                                                <div class='modal-body'>
                                                    <i class='fas fa-exclamation-circle'></i>
                                                    <h4 class='mt-3'>Are you sure you want to delete <strong>$product_title</strong>?</h4>
                                                    <p class='text-muted'>This action cannot be undone.</p>
                                                    <div class='d-flex justify-content-center gap-3 mt-4'>
                                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
                                                        <a href='index.php?delete_product=$product_id' class='btn btn-danger'>Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            ";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="insert_product.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="product_title" class="form-label">Product Title</label>
                                <input type="text" name="product_title" id="product_title" class="form-control" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="product_price" class="form-label">Product Price</label>
                                <input type="number" name="product_price" id="product_price" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="product_description" class="form-label">Product Description</label>
                            <input type="text" name="product_description" id="product_description" class="form-control" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="product_keywords" class="form-label">Product Keywords</label>
                            <input type="text" name="product_keywords" id="product_keywords" class="form-control" required>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="product_category" class="form-label">Product Category</label>
                                <select name="product_category" id="product_category" class="form-select" required>
                                    <option value="">Select a category</option>
                                    <?php
                                    $select_category_query = "SELECT * FROM `categories`";
                                    $select_category_result = mysqli_query($con, $select_category_query);
                                    while($fetch_category = mysqli_fetch_array($select_category_result)){
                                        $category_title = $fetch_category['category_title'];
                                        $category_id = $fetch_category['category_id'];
                                        echo "<option value='$category_id'>$category_title</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="product_brand" class="form-label">Product Brand</label>
                                <select name="product_brand" id="product_brand" class="form-select" required>
                                    <option value="">Select a brand</option>
                                    <?php

                                    $select_brand_query = "SELECT * FROM `brands`";
                                    $select_brand_result = mysqli_query($con, $select_brand_query);
                                    while($fetch_brand = mysqli_fetch_array($select_brand_result)){
                                        $brand_title = $fetch_brand['brand_title'];
                                        $brand_id = $fetch_brand['brand_id'];
                                        echo "<option value='$brand_id'>$brand_title</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="product_image_one" class="form-label">Product Image 1</label>
                            <input type="file" name="product_image_one" id="product_image_one" class="form-control" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="product_image_two" class="form-label">Product Image 2</label>
                            <input type="file" name="product_image_two" id="product_image_two" class="form-control" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="product_image_three" class="form-label">Product Image 3</label>
                            <input type="file" name="product_image_three" id="product_image_three" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="insert_product" class="btn btn-primary">Add Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>