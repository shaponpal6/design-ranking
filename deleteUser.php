<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// Check if user ID was provided
if (!isset($_GET['id'])) {
    $_SESSION['error'] = "No user ID provided.";
    header('Location: users.php');
    exit();
}

$userId = filter_var($_GET['id'], FILTER_VALIDATE_INT);
if ($userId === false) {
    $_SESSION['error'] = "Invalid user ID format.";
    header('Location: users.php');
    exit();
}

// If confirmation is received via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
    require_once 'includes/db_config.php';
    
    try {
        // Delete the user
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$userId]);

        if ($stmt->rowCount() > 0) {
            $_SESSION['success'] = "User has been successfully deleted.";
        } else {
            $_SESSION['error'] = "Failed to delete user.";
        }
        header('Location: users.php');
        exit();
    } catch(PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
        header('Location: users.php');
        exit();
    }
}

// Get user details for confirmation
require_once 'includes/db_config.php';
try {
    $stmt = $pdo->prepare("SELECT full_name FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch();
    
    if (!$user) {
        $_SESSION['error'] = "User not found.";
        header('Location: users.php');
        exit();
    }
} catch(PDOException $e) {
    $_SESSION['error'] = "Database error: " . $e->getMessage();
    header('Location: users.php');
    exit();
}
?>
<?php
include 'includes/header.php';
include 'includes/sidebar.php';

?>
<div class="flex items-center justify-center min-h-[60vh]">
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full">
        <h2 class="text-2xl font-bold mb-4 text-center text-gray-800">Confirm Delete</h2>
        <p class="text-gray-600 mb-6 text-center">
            Are you sure you want to delete the user "<?php echo htmlspecialchars($user['full_name']); ?>"?<br>
            This action cannot be undone.
        </p>
        <div class="flex justify-center gap-4">
            <form method="POST">
                <input type="hidden" name="confirm_delete" value="1">
                <button type="submit" class="px-6 py-2 bg-red-500 text-white rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                    Delete User
                </button>
            </form>
            <a href="users.php" class="px-6 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50">
                Cancel
            </a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
