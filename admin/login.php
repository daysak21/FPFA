<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="styleadmin.css" rel="stylesheet">
</head>
<body class="login-page">
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <img src="assets/img/admin-logo.png" alt="Admin Logo">
                <h2>Admin Dashboard</h2>
                <p>Connectez-vous pour accéder au panneau d'administration</p>
            </div>
            
            <form action="process_login.php" method="POST" class="login-form">
                <div class="form-group">
                    <input type="text" class="form-control" name="username" placeholder="Nom d'utilisateur" required>
                </div>
                
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Mot de passe" required>
                </div>
                
                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i>Se connecter
                </button>
            </form>
            
            <div class="login-footer">
                <p>© 2024 Admin Dashboard | <a href="#">Mot de passe oublié?</a></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 