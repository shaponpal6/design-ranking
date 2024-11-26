<?php
if (!isset($_SESSION)) {
    session_start();
}

// Check if user is not logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Store the requested URL for redirect after login
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    header('Location: login.php');
    exit();
}

// Function to check user type
function check_user_type($required_type) {
    if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== $required_type) {
        header('Location: index.php');
        exit();
    }
}
?>
