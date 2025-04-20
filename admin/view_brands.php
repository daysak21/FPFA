<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Brands</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="styleadmin.css">
</head>

<body>
    <div class="container page-container">
        <div class="page-header">
            <h2 class="page-title">All Brands</h2>
 
            <button class="btn btn-insert" data-bs-toggle="modal" data-bs-target="#addBrandModal">
                <i class="fas fa-plus"></i>Add Brand
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <?php
                    $get_brands = "SELECT * FROM `brands`";
                    $result = mysqli_query($con, $get_brands);
                    $row_count = mysqli_num_rows($result);
                    if($row_count > 0){
                        echo "
                        <tr>
                            <th>Brand ID</th>
                            <th>Brand Title</th>
                            <th>Actions</th>
                        </tr>
                        ";
                    }
                    ?>
                </thead>
                <tbody>
                    <?php
                    if($row_count == 0){
                        echo "<tr><td colspan='4' class='text-center py-4'>No brands found</td></tr>";
                    } else {
                        while($row = mysqli_fetch_assoc($result)){
                            $brand_id = $row['brand_id'];
                            $brand_title = $row['brand_title'];
                            echo "
                            <tr>
                                <td>$brand_id</td>
                                <td>$brand_title</td>
                                <td>
                                    <div class='d-flex gap-2'>
                                        <!-- Changed to button that opens edit modal -->
                                        <button class='btn btn-action btn-edit' data-bs-toggle='modal' data-bs-target='#editModal_$brand_id'>
                                            <i class='fas fa-edit'></i>
                                        </button>
                                        <button class='btn btn-action btn-delete' data-bs-toggle='modal' data-bs-target='#deleteModal_$brand_id'>
                                            <i class='fas fa-trash'></i>
                                        </button>
                                    </div>

                                    <!-- Edit Modal -->
                                    <div class='modal fade' id='editModal_$brand_id' tabindex='-1' aria-labelledby='editModal_$brand_id.Label' aria-hidden='true'>
                                        <div class='modal-dialog modal-dialog-centered'>
                                            <div class='modal-content'>
                                                <div class='modal-header'>
                                                    <h5 class='modal-title' id='editModal_$brand_id.Label'>Edit Brand</h5>
                                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                                </div>
                                                <form action='edit_brand.php' method='post'>
                                                    <div class='modal-body'>
                                                        <input type='hidden' name='brand_id' value='$brand_id'>
                                                        <div class='mb-3'>
                                                            <label for='brand_title_$brand_id' class='form-label'>Brand Title</label>
                                                            <input type='text' name='brand_title' id='brand_title_$brand_id' class='form-control' required value='$brand_title'>
                                                        </div>
                                                    </div>
                                                    <div class='modal-footer'>
                                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
                                                        <button type='submit' name='update_brand' class='btn btn-primary'>Update Brand</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class='modal fade' id='deleteModal_$brand_id' tabindex='-1' aria-labelledby='deleteModal_$brand_id.Label' aria-hidden='true'>
                                        <div class='modal-dialog modal-dialog-centered'>
                                            <div class='modal-content'>
                                                <div class='modal-body'>
                                                    <i class='fas fa-exclamation-circle'></i>
                                                    <h4 class='mt-3'>Are you sure you want to delete <strong>$brand_title</strong>?</h4>
                                                    <p class='text-muted'>This action cannot be undone.</p>
                                                    <div class='d-flex justify-content-center gap-3 mt-4'>
                                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
                                                        <a href='index.php?delete_brand=$brand_id' class='btn btn-danger'>Delete</a>
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

    <div class="modal fade" id="addBrandModal" tabindex="-1" aria-labelledby="addBrandModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBrandModalLabel">Add New Brand</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="insert_brands.php" method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="brand_title" class="form-label">Brand Title</label>
                            <input type="text" class="form-control" name="brand_title" id="brand_title" placeholder="Enter brand name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="insert_brand_title" class="btn btn-primary">Add Brand</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>