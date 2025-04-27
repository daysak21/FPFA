<?php
include('./includes/connect.php');
include('./functions/common_functions.php');
session_start();

if(!isset($_SESSION['username'])) {
    header("Location: user_login.php");
    exit();
}

// Récupérer les informations de l'utilisateur connecté
$user_session_name = $_SESSION['username'];
$select_user_query = "SELECT * FROM `user_table` WHERE username='$user_session_name'";
$select_user_result = mysqli_query($con,$select_user_query);
$row_user_fetch = mysqli_fetch_assoc($select_user_result);
$user_id = $row_user_fetch['user_id'];
$username = $row_user_fetch['username'];
$user_email = $row_user_fetch['user_email'];
$user_address = $row_user_fetch['user_address'];
$user_mobile = $row_user_fetch['user_mobile'];
$user_image = $row_user_fetch['user_image'];

// Update data
if(isset($_POST['user_update'])){
    $update_id = $user_id;
    $update_user = $_POST['user_username'];
    $update_email = $_POST['user_email'];
    $update_address = $_POST['user_address'];
    $update_mobile = $_POST['user_mobile'];
    $update_image = $_FILES['user_image']['name'] != ''? $_FILES['user_image']['name'] : $user_image;
    $update_image_tmp = $_FILES['user_image']['tmp_name'];
    
    if($_FILES['user_image']['name'] != '') {
        move_uploaded_file($update_image_tmp,"./user_images/$update_image");
    }
    
    // update query 
    $update_query = "UPDATE `user_table` SET username='$update_user',user_email='$update_email',user_image='$update_image',user_address='$update_address',user_mobile='$update_mobile' WHERE user_id=$update_id";
    $update_result = mysqli_query($con,$update_query);
    if($update_result){
        $_SESSION['username'] = $update_user;
        echo "<script>window.alert('Data updated successfully');</script>";
        echo "<script>window.open('profile.php','_self');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Account</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .edit-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            animation: fadeIn 0.5s ease-out;
        }

        .edit-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 30px rgba(0,0,0,0.1);
        }

        .edit-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .edit-title {
            font-size: 2rem;
            font-weight: 700;
            color: #495057;
            margin-bottom: 10px;
        }

        .edit-subtitle {
            color: #6c757d;
            font-size: 1rem;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #495057;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
            outline: none;
        }

        .image-preview {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            margin: 15px auto;
            border: 4px solid #28a745;
            position: relative;
        }

        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-upload {
            text-align: center;
            margin-bottom: 20px;
        }

        .image-upload input[type="file"] {
            display: none;
        }

        .image-upload label {
            display: inline-block;
            padding: 8px 20px;
            background: #f8f9fa;
            color: #495057;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .image-upload label:hover {
            background: #e9ecef;
        }

        .btn-update {
            display: block;
            width: 100%;
            padding: 12px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-update:hover {
            background: #218838;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        }

        .btn-back {
            display: inline-block;
            padding: 8px 20px;
            background: #f8f9fa;
            color: #495057;
            border-radius: 8px;
            text-decoration: none;
            margin-top: 20px;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background: #e9ecef;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .edit-container {
                padding: 15px;
            }

            .edit-card {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <?php require "navbar.php"; ?>

    <div class="edit-container">
        <div class="edit-card">
            <div class="edit-header">
                <h1 class="edit-title">Edit Account</h1>
                <p class="edit-subtitle">Update your personal information</p>
            </div>

            <form action="" method="post" enctype="multipart/form-data">
                <div class="image-upload">
                    <div class="image-preview">
                        <img src="./user_images/<?php echo $user_image;?>" alt="Profile Image">
                    </div>
                    <label for="user_image">
                        <i class="fas fa-camera"></i> Change Photo
                    </label>
                    <input type="file" name="user_image" id="user_image" class="form-control">
                </div>

                <div class="form-group">
                    <label for="user_username" class="form-label">Username</label>
                    <input type="text" name="user_username" id="user_username" class="form-control" value="<?php echo $username;?>">
                </div>

                <div class="form-group">
                    <label for="user_email" class="form-label">Email</label>
                    <input type="email" name="user_email" id="user_email" class="form-control" value="<?php echo $user_email;?>">
                </div>

                <div class="form-group">
                    <label for="user_address" class="form-label">Address</label>
                    <input type="text" name="user_address" id="user_address" class="form-control" value="<?php echo $user_address;?>">
                </div>

                <div class="form-group">
                    <label for="user_mobile" class="form-label">Mobile Number</label>
                    <input type="text" name="user_mobile" id="user_mobile" class="form-control" value="<?php echo $user_mobile;?>">
                </div>

                <button type="submit" name="user_update" class="btn-update">
                    <i class="fas fa-save"></i> Update Profile
                </button>
            </form>

            <a href="profile.php" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back to Profile
            </a>
        </div>
    </div>

    <?php require "footer.php"; ?>
    <script src="assets/js/bootstrap.bundle.js"></script>
    <script>
        // Preview image before upload
        document.getElementById('user_image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('.image-preview img').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>