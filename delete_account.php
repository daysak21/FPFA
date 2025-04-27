<?php
include('./includes/connect.php');
include('./functions/common_functions.php');
session_start();

if(!isset($_SESSION['username'])) {
    header("Location: user_login.php");
    exit();
}

if(isset($_POST['delete_account'])) {
    $username = $_SESSION['username'];
    $delete_query = "DELETE FROM `user_table` WHERE username='$username'";
    $result = mysqli_query($con, $delete_query);
    if($result) {
        session_destroy();
        echo "<script>alert('Account has been deleted successfully');</script>";
        echo "<script>window.open('index.php','_self');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .delete-container {
            max-width: 600px;
            margin: 40px auto;
            padding: 30px;
            animation: fadeIn 0.5s ease-out;
        }

        .delete-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 30px rgba(0,0,0,0.1);
            text-align: center;
        }

        .warning-icon {
            font-size: 4rem;
            color: #dc3545;
            margin-bottom: 20px;
            animation: pulse 2s infinite;
        }

        .delete-title {
            font-size: 2rem;
            font-weight: 700;
            color: #dc3545;
            margin-bottom: 20px;
        }

        .delete-message {
            color: #495057;
            font-size: 1.1rem;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .consequences {
            background: rgba(220, 53, 69, 0.1);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
        }

        .consequences-title {
            color: #dc3545;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .consequences-list {
            list-style: none;
            padding: 0;
            margin: 0;
            text-align: left;
        }

        .consequences-list li {
            margin-bottom: 10px;
            color: #495057;
            display: flex;
            align-items: center;
        }

        .consequences-list li i {
            color: #dc3545;
            margin-right: 10px;
        }

        .btn-group {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
        }

        .btn-delete {
            padding: 12px 30px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-delete:hover {
            background: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
        }

        .btn-cancel {
            padding: 12px 30px;
            background: #6c757d;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-cancel:hover {
            background: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
        }

        @media (max-width: 768px) {
            .delete-container {
                padding: 15px;
            }

            .delete-card {
                padding: 20px;
            }

            .btn-group {
                flex-direction: column;
            }

            .btn-delete, .btn-cancel {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <?php require "navbar.php"; ?>

    <div class="delete-container">
        <div class="delete-card">
            <i class="fas fa-exclamation-triangle warning-icon"></i>
            <h1 class="delete-title">Delete Account</h1>
            <p class="delete-message">
                Are you sure you want to delete your account? This action cannot be undone and all your data will be permanently removed.
            </p>

            <div class="consequences">
                <h2 class="consequences-title">What happens when you delete your account:</h2>
                <ul class="consequences-list">
                    <li>
                        <i class="fas fa-times-circle"></i>
                        Your profile and personal information will be permanently deleted
                    </li>
                    <li>
                        <i class="fas fa-times-circle"></i>
                        Your order history will be removed
                    </li>
                    <li>
                        <i class="fas fa-times-circle"></i>
                        You will lose access to all your account features
                    </li>
                    <li>
                        <i class="fas fa-times-circle"></i>
                        This action cannot be reversed
                    </li>
                </ul>
            </div>

            <form action="" method="post">
                <div class="btn-group">
                    <a href="profile.php" class="btn-cancel">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    <button type="submit" name="delete_account" class="btn-delete" onclick="return confirm('Are you absolutely sure you want to delete your account?')">
                        <i class="fas fa-trash-alt"></i> Delete Account
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php require "footer.php"; ?>
    <script src="assets/js/bootstrap.bundle.js"></script>
</body>
</html>