<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Brands</title>
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
            <h2 class="page-title">All Brands</h2>
            <a href="index.php?insert_brand" class="btn btn-insert">
                <i class="fas fa-plus"></i>Add Brand
            </a>
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
                            <th>Brand Image</th>
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
                            $brand_image = $row['brand_image'];
                            echo "
                            <tr>
                                <td>$brand_id</td>
                                <td>$brand_title</td>
                                <td>
                                    <img src='./brand_images/$brand_image' class='thumbnail-image' alt='$brand_title'/>
                                </td>
                                <td>
                                    <div class='d-flex gap-2'>
                                        <a href='index.php?edit_brand=$brand_id' class='btn btn-action btn-edit'>
                                            <i class='fas fa-edit'></i>
                                        </a>
                                        <button class='btn btn-action btn-delete' data-bs-toggle='modal' data-bs-target='#deleteModal_$brand_id'>
                                            <i class='fas fa-trash'></i>
                                        </button>
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>