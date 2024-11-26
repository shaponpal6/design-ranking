<!-- Topbar Start -->
<header class="h-16 flex items-center border-b border-gray-200 bg-white px-6">
    <div class="flex items-center gap-4 w-full">
        <button type="button" class="toggle-sidebar text-lg text-gray-600 lg:hidden">
            <i class="material-symbols-rounded">menu</i>
        </button>

        <div class="flex items-center gap-4 ms-auto">
            <div class="flex items-center gap-2">
                <div class="dropdown">
                    <button type="button" class="dropdown-toggle flex items-center gap-2" id="userDropdown" data-hs-dropdown="#userDropdownMenu" aria-expanded="false">
                        <img src="assets/images/users/avatar-1.jpg" alt="user-image" class="rounded-full h-8 w-8">
                        <span class="text-sm font-medium text-gray-600 hidden sm:block">
                            <?php echo isset($_SESSION['full_name']) ? htmlspecialchars($_SESSION['full_name']) : 'User'; ?>
                        </span>
                    </button>
                    <div id="userDropdownMenu" class="hs-dropdown-menu duration hs-dropdown-open:opacity-100 w-48 hidden z-10">
                        <div class="py-2 first:pt-0 last:pb-0">
                            <a class="flex items-center gap-3 py-2 px-4 text-sm text-gray-800 hover:bg-gray-100 hover:text-gray-900" href="profile">
                                <i class="material-symbols-rounded text-lg">account_circle</i>
                                My Profile
                            </a>
                            <a class="flex items-center gap-3 py-2 px-4 text-sm text-gray-800 hover:bg-gray-100 hover:text-gray-900" href="settings">
                                <i class="material-symbols-rounded text-lg">settings</i>
                                Settings
                            </a>
                            <hr class="my-2">
                            <a class="flex items-center gap-3 py-2 px-4 text-sm text-gray-800 hover:bg-gray-100 hover:text-gray-900" href="logout">
                                <i class="material-symbols-rounded text-lg">logout</i>
                                Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Topbar End -->
