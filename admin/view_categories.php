<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Categories</title>
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
            <h2 class="page-title">All Categories</h2>
            <a href="index.php?insert_category" class="btn btn-insert">
                <i class="fas fa-plus"></i>Add Category
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <?php
                    $get_categories = "SELECT * FROM `categories`";
                    $result = mysqli_query($con, $get_categories);
                    $row_count = mysqli_num_rows($result);
                    if($row_count > 0){
                        echo "
                        <tr>
                            <th>Category ID</th>
                            <th>Category Title</th>
                            <th>Actions</th>
                        </tr>
                        ";
                    }
                    ?>
                </thead>
                <tbody>
                    <?php
                    if($row_count == 0){
                        echo "<tr><td colspan='3' class='text-center py-4'>No categories found</td></tr>";
                    } else {
                        while($row = mysqli_fetch_assoc($result)){
                            $category_id = $row['category_id'];
                            $category_title = $row['category_title'];
                            echo "
                            <tr>
                                <td>$category_id</td>
                                <td>$category_title</td>
                                <td>
                                    <div class='d-flex gap-2'>
                                        <a href='index.php?edit_category=$category_id' class='btn btn-action btn-edit'>
                                            <i class='fas fa-edit'></i>
                                        </a>
                                        <button class='btn btn-action btn-delete' data-bs-toggle='modal' data-bs-target='#deleteModal_$category_id'>
                                            <i class='fas fa-trash'></i>
                                        </button>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class='modal fade' id='deleteModal_$category_id' tabindex='-1' aria-labelledby='deleteModal_$category_id.Label' aria-hidden='true'>
                                        <div class='modal-dialog modal-dialog-centered'>
                                            <div class='modal-content'>
                                                <div class='modal-body'>
                                                    <i class='fas fa-exclamation-circle'></i>
                                                    <h4 class='mt-3'>Are you sure you want to delete <strong>$category_title</strong>?</h4>
                                                    <p class='text-muted'>This action cannot be undone.</p>
                                                    <div class='d-flex justify-content-center gap-3 mt-4'>
                                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
                                                        <a href='index.php?delete_category=$category_id' class='btn btn-danger'>Delete</a>
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