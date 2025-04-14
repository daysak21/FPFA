<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users Page</title>
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
            <h2 class="page-title">All Users</h2>
            <a href="insert_user.php" class="btn btn-insert">
                <i class="fas fa-plus"></i>Insert User
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <?php
                    $get_user_query = "SELECT * FROM `user_table`";
                    $get_user_result = mysqli_query($con, $get_user_query);
                    $row_count = mysqli_num_rows($get_user_result);
                    if($row_count!=0){
                        echo "
                        <tr>
                            <th>User No.</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Image</th>
                            <th>Address</th>
                            <th>Mobile</th>
                            <th>Actions</th>
                        </tr>
                        ";
                    }
                    ?>
                </thead>
                <tbody>
                    <?php
                    if ($row_count == 0) {
                        echo "<tr><td colspan='7' class='text-center py-4'>No users found</td></tr>";
                    } else {
                        $id_number = 1;
                        while ($row_fetch_users = mysqli_fetch_array($get_user_result)) {
                            $user_id = $row_fetch_users['user_id'];
                            $username = $row_fetch_users['username'];
                            $user_email = $row_fetch_users['user_email'];
                            $user_image = $row_fetch_users['user_image'];
                            $user_address = $row_fetch_users['user_address'];
                            $user_mobile = $row_fetch_users['user_mobile'];
                            echo "
                            <tr>
                                <td>$id_number</td>
                                <td>$username</td>
                                <td>$user_email</td>
                                <td>
                                    <img src='../users_area/user_images/$user_image' alt='$username photo' class='thumbnail-image'/>
                                </td>
                                <td>$user_address</td>
                                <td>$user_mobile</td>
                                <td>
                                    <div class='d-flex gap-2'>
                                        <a href='edit_user.php?user_id=$user_id' class='btn btn-action btn-edit'>
                                            <i class='fas fa-edit'></i>
                                        </a>
                                        <button class='btn btn-action btn-delete' data-bs-toggle='modal' data-bs-target='#deleteModal_$user_id'>
                                            <i class='fas fa-trash'></i>
                                        </button>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class='modal fade' id='deleteModal_$user_id' tabindex='-1' aria-labelledby='deleteModal_$user_id.Label' aria-hidden='true'>
                                        <div class='modal-dialog modal-dialog-centered'>
                                            <div class='modal-content'>
                                                <div class='modal-body'>
                                                    <i class='fas fa-exclamation-circle'></i>
                                                    <h4 class='mt-3'>Are you sure you want to delete <strong>$username</strong>?</h4>
                                                    <p class='text-muted'>This action cannot be undone.</p>
                                                    <div class='d-flex justify-content-center gap-3 mt-4'>
                                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
                                                        <a href='delete_user.php?delete_user=$user_id' class='btn btn-danger'>Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            ";
                            $id_number++;
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
