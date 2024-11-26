<?php
session_start();

// If user is already logged in, redirect to dashboard
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: index');
    exit();
}

require_once 'includes/db_config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Login | Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Admin Dashboard Login" name="description">

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Icons css -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" rel="stylesheet">

    <!-- App css -->
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css">

    <style>
        .card-container {
            max-width: 400px;
            margin: 0 auto;
        }
        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            color: #6b7280;
        }
        .password-toggle:hover {
            color: #374151;
        }
        .form-input {
            padding-right: 40px;
        }
    </style>
</head>

<body class="bg-default-100">
    <div class="container">
        <div class="row justify-content-center min-vh-100 align-items-center">
            <div class="card-container">
                <div class="card">
                    <div class="p-6">
                        <div class="text-center mb-4">
                            <a href="index">
                                <img src="assets/images/logo.png" alt="" height="40" class="mx-auto">
                            </a>
                            <h4 class="card-title mt-4 mb-2">Welcome Back!</h4>
                            <p class="text-default-800">Enter your email and password to access admin panel.</p>
                        </div>

                        <?php
                        if (isset($_SESSION['error'])) {
                            echo '<div class="alert alert-danger mb-4">' . htmlspecialchars($_SESSION['error']) . '</div>';
                            unset($_SESSION['error']);
                        }
                        if (isset($_SESSION['success'])) {
                            echo '<div class="alert alert-success mb-4">' . htmlspecialchars($_SESSION['success']) . '</div>';
                            unset($_SESSION['success']);
                        }
                        ?>

                        <form action="auth" method="POST">
                            <div class="mb-3">
                                <label for="email" class="text-default-800 text-sm font-medium inline-block mb-2">Email address</label>
                                <input type="email" class="form-input" id="email" name="email" 
                                    placeholder="Enter your email" autocomplete="off" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="text-default-800 text-sm font-medium inline-block mb-2">Password</label>
                                <div class="relative">
                                    <input type="password" class="form-input" id="password" name="password" 
                                        placeholder="Enter your password" autocomplete="new-password" required>
                                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                        <i class="material-symbols-rounded text-xl" id="password-toggle">visibility</i>
                                    </button>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 mb-4">
                                <input type="checkbox" class="form-checkbox rounded border border-gray-200" id="remember" name="remember">
                                <label class="text-default-800 text-sm font-medium inline-block" for="remember">Remember me</label>
                            </div>
                            <button type="submit" class="btn bg-red-500 text-white w-full">Sign In</button>
                        </form>

                        <div class="text-center mt-4">
                            <p class="text-default-600">Don't have an account? <a href="#" class="text-primary fw-medium ms-1">Contact Admin</a></p>
                            <p><a href="#" class="text-primary fw-medium">Forgot your password?</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Plugin js -->
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    
    <!-- App js -->
    <script src="assets/js/app.js"></script>

    <script>
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById('password-toggle');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.textContent = 'visibility_off';
        } else {
            input.type = 'password';
            icon.textContent = 'visibility';
        }
    }
    </script>
</body>
</html>
