<?php
session_start();
include 'includes/header.php';
include 'includes/sidebar.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login');
    exit();
}

require_once 'includes/db_config.php';

// Fetch all users
try {
    $stmt = $pdo->prepare("SELECT id, full_name, email, user_type, created_on, last_login, user_active FROM users ORDER BY id DESC");
    $stmt->execute();
    $users = $stmt->fetchAll();
} catch(PDOException $e) {
    die("Error fetching users: " . $e->getMessage());
}
?>
<title>Users | Admin Panel</title>

<div class="flex items-center md:justify-between flex-wrap gap-2 mb-6">
                    <h4 class="text-default-900 text-lg font-medium mb-2">Users</h4>

                    <div class="md:flex hidden items-center gap-3 text-sm font-semibold">
                        <a href="/wdr" class="text-sm font-medium text-default-700">Dashboard</a>
                        <i class="material-symbols-rounded text-xl flex-shrink-0 text-default-500">chevron_right</i>
                        <a href="#" class="text-sm font-medium text-default-700"> Users</a>
    
                    </div>
                </div>

<?php if (isset($_SESSION['success'])): ?>
    <div class="mb-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-lg">
        <?php 
        echo htmlspecialchars($_SESSION['success']); 
        unset($_SESSION['success']);
        ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="mb-4 p-4 bg-red-100 border border-red-200 text-red-700 rounded-lg">
        <?php 
        echo htmlspecialchars($_SESSION['error']); 
        unset($_SESSION['error']);
        ?>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <div class="flex justify-between items-center">
            <h4 class="card-title">All Users</h4>
            <button type="button" class="btn btn-primary">
                <a class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" href="addUser.php">Add New User</a>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-start text-sm text-default-500">
                        ID</th>
                    <th scope="col"
                        class="px-6 py-3 text-start text-sm text-default-500">
                        Full Name
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-start text-sm text-default-500">
                        Email
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-start text-sm text-default-500">
                        Role
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-start text-sm text-default-500">
                        Status
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-start text-sm text-default-500">
                        Created On
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-start text-sm text-default-500">
                        Last Login
                    </th>
                    <th scope="col" class="px-6 py-3 text-end text-sm text-default-500">
                    Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user): ?>
                <tr class="odd:bg-white even:bg-gray-100">
                    <td
                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-default-800">
                        <?php echo htmlspecialchars($user['id']); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-default-800">
                    <?php echo htmlspecialchars($user['full_name']); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-default-800">
                    <?php echo htmlspecialchars($user['email']); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-default-800">
                    <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-primary text-white"><?php echo htmlspecialchars(ucfirst($user['user_type'])); ?></span></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-default-800">
                    <?php if ($user['user_active']): ?>
                <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-green-500 text-white">Active</span>
            <?php else: ?>
                <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-red-500 text-white">Inactive</span>
            <?php endif; ?>   
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-default-800">
                <?php echo date('M d, Y', strtotime($user['created_on'])); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-default-800">
                    <?php echo $user['last_login'] ? date('M d, Y H:i', strtotime($user['last_login'])) : 'Never'; ?></td>
                    <td
                        class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                        <div class="flex justify-end gap-2">
                            <a class="text-primary hover:text-sky-700" href="editUser.php?id=<?php echo htmlspecialchars($user['id']); ?>">
                                <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-black text-white">Edit</span>
                            </a>
                            <a class="text-primary hover:text-sky-700" href="deleteUser.php?id=<?php echo htmlspecialchars($user['id']); ?>">
                                <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-red-500 text-white">Delete</span>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
           
            </table>
        </div>
    </div>
</div>
</main>

<!-- Footer -->
<?php include 'includes/footer.php'; ?>