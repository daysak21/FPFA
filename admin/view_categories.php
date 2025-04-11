<?php
include('../includes/connect.php');
session_start();
if(!isset($_SESSION['admin_username'])){
    echo "<script>window.open('./admin_login.php','_self');</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Management Panel</title>
    <link rel="stylesheet" href="styleA.css">
</head>

<body>
    <div class="floating-panel-container" id="categoryPanel">
        <div class="floating-panel">
            <div class="panel-header">
                <span>Category Management</span>
                <button class="close-btn" id="closeCategoryPanel">×</button>
            </div>
            <div class="panel-content">
                <table class="user-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Category Title</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $get_categories_query = "SELECT * FROM `categories`";
                        $get_categories_result = mysqli_query($con, $get_categories_query);
                        $row_count = mysqli_num_rows($get_categories_result);

                        if ($row_count == 0) {
                            echo '<tr><td colspan="3" style="text-align: center; padding: 20px;">No categories found</td></tr>';
                        } else {
                            while ($row_fetch_categories = mysqli_fetch_array($get_categories_result)) {
                                $category_id = $row_fetch_categories['category_id'];
                                $category_title = $row_fetch_categories['category_title'];
                                
                                echo "
                                <tr>
                                    <td>{$category_id}</td>
                                    <td>{$category_title}</td>
                                    <td>
                                        <div style='display: flex; gap: 8px;'>
                                            <button class='action-btn btn-edit' onclick=\"editCategory('{$category_id}')\">
                                                <svg width='14' height='14' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                                    <path d='M11 4H4C3.46957 4 2.96086 4.21071 2.58579 4.58579C2.21071 4.96086 2 5.46957 2 6V20C2 20.5304 2.21071 21.0391 2.58579 21.4142C2.96086 21.7893 3.46957 22 4 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V13M18.5 2.5C18.8978 2.10217 19.4374 1.87868 20 1.87868C20.5626 1.87868 21.1022 2.10217 21.5 2.5C21.8978 2.89782 22.1213 3.43739 22.1213 4C22.1213 4.56261 21.8978 5.10217 21.5 5.5L12 15L8 16L9 12L18.5 2.5Z' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/>
                                                </svg>
                                                Edit
                                            </button>
                                            <button class='action-btn btn-delete' onclick=\"confirmDelete('delete_category.php?delete_category={$category_id}', '{$category_title}')\">
                                                <svg width='14' height='14' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                                    <path d='M19 7L18.1327 19.1425C18.0579 20.1891 17.187 21 16.1378 21H7.86224C6.81296 21 5.94208 20.1891 5.86732 19.1425L5 7M10 11V17M14 11V17M15 7V4C15 3.44772 14.5523 3 14 3H10C9.44772 3 9 3.44772 9 4V7M4 7H20' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/>
                                                </svg>
                                                Delete
                                            </button>
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
    </div>

    <script>
        // Close button functionality
        document.getElementById('closeCategoryPanel').addEventListener('click', function() {
            document.getElementById('categoryPanel').style.display = 'none';
        });

        function confirmDelete(url, categoryName) {
            if (confirm(`Are you sure you want to delete category "${categoryName}"? This action cannot be undone.`)) {
                window.location.href = url;
            }
        }

        function editCategory(categoryId) {
            window.location.href = `index.php?edit_category=${categoryId}`;
        }
    </script>
</body>

</html>