<?php
session_start();
require_once 'includes/db_config.php';
require_once 'includes/functions.php';

// Check if user is logged in and has permission
if (!isset($_SESSION['user_id']) || !has_permission('admin')) {
    header('Location: login');
    exit();
}

// Check if user ID is provided
if (!isset($_GET['id'])) {
    $_SESSION['error'] = "User ID is required";
    header('Location: users.php');
    exit();
}

$errors = [];
$success = '';
$user_id = (int)$_GET['id'];

// Get user data
try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();
    
    if (!$user) {
        $_SESSION['error'] = "User not found";
        header('Location: users.php');
        exit();
    }
} catch (PDOException $e) {
    error_log("Error fetching user: " . $e->getMessage());
    $_SESSION['error'] = "Error fetching user data";
    header('Location: users.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = sanitize_input($_POST['full_name'] ?? '');
    $email = sanitize_input($_POST['email'] ?? '');
    $password = $_POST['password'] ?? ''; // Optional for edit
    $user_type = sanitize_input($_POST['user_type'] ?? '');
    $user_active = isset($_POST['user_active']) ? 1 : 0;

    // Validate inputs
    if (empty($full_name)) $errors[] = "Full name is required";
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!is_valid_email($email)) {
        $errors[] = "Invalid email format";
    } elseif ($email !== $user['email'] && email_exists($pdo, $email)) {
        $errors[] = "Email already exists";
    }
    if (!empty($password) && strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long";
    }
    if (empty($user_type)) $errors[] = "User type is required";

    if (empty($errors)) {
        try {
            if (!empty($password)) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE users SET full_name = ?, email = ?, password = ?, user_type = ?, user_active = ? WHERE id = ?");
                $stmt->execute([$full_name, $email, $hashed_password, $user_type, $user_active, $user_id]);
            } else {
                $stmt = $pdo->prepare("UPDATE users SET full_name = ?, email = ?, user_type = ?, user_active = ? WHERE id = ?");
                $stmt->execute([$full_name, $email, $user_type, $user_active, $user_id]);
            }
            
            // Log the activity
            log_activity($pdo, $_SESSION['user_id'], 'edit_user', "Updated user: $email");
            
            $_SESSION['success'] = "User updated successfully!";
            header('Location: users.php');
            exit();
            
        } catch (PDOException $e) {
            error_log("Error updating user: " . $e->getMessage());
            $errors[] = "Error updating user: " . $e->getMessage();
        }
    }
}

// Include header and sidebar after all potential redirects
include 'includes/header.php';
include 'includes/sidebar.php';
?>
<title>Edit User | Admin Panel</title>
<div class="flex items-center md:justify-between flex-wrap gap-2 mb-6">
    <h4 class="text-default-900 text-lg font-medium mb-2">Users</h4>
    <div class="md:flex hidden items-center gap-3 text-sm font-semibold">
        <a href="/wdr" class="text-sm font-medium text-default-700">Dashboard</a>
        <i class="material-symbols-rounded text-xl flex-shrink-0 text-default-500">chevron_right</i>
        <a href="#" class="text-sm font-medium text-default-700">Users</a>
    </div>
</div>

<?php if (!empty($errors)): ?>
    <div class="mb-4 p-4 bg-red-100 border border-red-200 text-red-700 rounded-lg">
        <ul class="list-disc list-inside">
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="bg-white rounded-lg shadow-sm">
    <div class="p-6">
        <form action="" method="POST" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input type="text" id="full_name" name="full_name" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                           value="<?php echo htmlspecialchars($user['full_name']); ?>" 
                           required>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                           value="<?php echo htmlspecialchars($user['email']); ?>" 
                           required>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password (Leave empty to keep current)</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <button type="button" onclick="togglePassword()" 
                                class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700">
                            <i class="material-symbols-rounded text-xl password-eye">visibility</i>
                        </button>
                    </div>
                </div>

                <div>
                    <label for="user_type" class="block text-sm font-medium text-gray-700 mb-1">User Type</label>
                    <select id="user_type" name="user_type" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                            required>
                        <option value="">Select User Type</option>
                        <option value="admin" <?php echo $user['user_type'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                        <option value="user" <?php echo $user['user_type'] === 'user' ? 'selected' : ''; ?>>User</option>
                    </select>
                </div>

                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="user_active" name="user_active" 
                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                           <?php echo $user['user_active'] ? 'checked' : ''; ?>>
                    <label for="user_active" class="text-sm font-medium text-gray-700">Active User</label>
                </div>
            </div>

            <div class="flex justify-end space-x-4 pt-4">
                <a href="users.php" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Update User
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.querySelector('.password-eye');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.textContent = 'visibility_off';
    } else {
        passwordInput.type = 'password';
        eyeIcon.textContent = 'visibility';
    }
}
</script>
<?php include 'includes/footer.php'; ?>
