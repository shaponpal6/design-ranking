<?php
require_once 'includes/error_logger.php';

// Start the session if not already started
session_start();

try {
    // Log the logout attempt
    if (isset($_SESSION['user_email'])) {
        logError("Logout attempt for user: " . $_SESSION['user_email'], __FILE__, __LINE__);
    }

    // Clear all session variables
    $_SESSION = array();

    // Destroy the session cookie
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time()-3600, '/');
    }

    // Clear remember me cookie if it exists
    if (isset($_COOKIE['remember_token'])) {
        setcookie('remember_token', '', time()-3600, '/');
    }

    // Destroy the session
    session_destroy();

    // Start new session for success message
    session_start();
    $_SESSION['success'] = 'You have been successfully logged out.';
    
    logError("Successful logout", __FILE__, __LINE__);
    
    // Redirect to login page
    header("Location: login");
    exit();
    
} catch(Exception $e) {
    logError("Logout error: " . $e->getMessage(), __FILE__, __LINE__, [
        'trace' => $e->getTraceAsString()
    ]);
    
    // Start new session for error message
    session_start();
    $_SESSION['error'] = 'An error occurred during logout. Please try again.';
    
    // Redirect to login page
    header("Location: login");
    exit();
}
