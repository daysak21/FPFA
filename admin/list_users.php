<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-4">
        <div class="categ-header d-flex justify-content-between align-items-center mb-3">
            <div class="sub-title d-flex align-items-center">
                <span class="shape me-2"></span>
                <h2>All Users</h2>
            </div>
            <!-- Insert User Button -->
            <a href="insert_user.php" class="btn btn-success">
                + Insert User
            </a>
        </div>

        <div class="table-data">
            <table class="table table-bordered table-hover table-striped text-center">
                <thead class="table-dark">
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
                        echo "<h2 class='text-center text-light p-2 bg-dark'>No users yet</h2>";
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
                                    <img src='../users_area/user_images/$user_image' alt='$username photo' class='img-thumbnail' width='100px'/>
                                </td>
                                <td>$user_address</td>
                                <td>$user_mobile</td>
                                <td class='d-flex justify-content-center gap-2'>
                                    <!-- Edit Button -->
                                    <a href='index.php?edit_user=$user_id' class='btn btn-warning btn-sm'>Edit</a>

                                    <!-- Delete Button trigger modal -->
                                    <button class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#deleteModal_$user_id'>Delete</button>
                                </td>
                            </tr>

                            <!-- Delete Modal -->
                            <div class='modal fade' id='deleteModal_$user_id' tabindex='-1' aria-labelledby='deleteModal_$user_id.Label' aria-hidden='true'>
                                <div class='modal-dialog modal-dialog-centered'>
                                    <div class='modal-content'>
                                        <div class='modal-body text-center'>
                                            <svg width='50' height='50' viewBox='0 0 60 60' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                                <circle cx='29.5' cy='30.5' r='26' stroke='#EA4335' stroke-width='3'/>
                                                <path d='M41.2715 22.2715C42.248 21.2949 42.248 19.709 41.2715 18.7324C40.2949 17.7559 38.709 17.7559 37.7324 18.7324L29.5059 26.9668L21.2715 18.7402C20.2949 17.7637 18.709 17.7637 17.7324 18.7402C16.7559 19.7168 16.7559 21.3027 17.7324 22.2793L25.9668 30.5059L17.7402 38.7402C16.7637 39.7168 16.7637 41.3027 17.7402 42.2793C18.7168 43.2559 20.3027 43.2559 21.2793 42.2793L29.5059 34.0449L37.7402 42.2715C38.7168 43.248 40.3027 43.248 41.2793 42.2715C42.2559 41.2949 42.2559 39.709 41.2793 38.7324L33.0449 30.5059L41.2715 22.2715Z' fill='#EA4335'/>
                                            </svg>
                                            <h4 class='mt-3'>Are you sure you want to delete <strong>$username</strong>?</h4>
                                            <div class='mt-4 d-flex justify-content-center gap-3'>
                                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
                                                <a href='index.php?delete_user=$user_id' class='btn btn-danger'>Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
