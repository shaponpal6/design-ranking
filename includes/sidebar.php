<?php
if(!isset($_SESSION)) {
    session_start();
}
?>
<!-- Start Sidebar -->
<aside id="app-menu"
    class="hs-overlay fixed inset-y-0 start-0 z-60 hidden w-sidenav min-w-sidenav bg-white border-e border-default-200 overflow-y-auto -translate-x-full transform transition-all duration-300 hs-overlay-open:translate-x-0 lg:bottom-0 lg:end-auto lg:z-30 lg:block lg:translate-x-0 rtl:translate-x-full rtl:hs-overlay-open:translate-x-0 rtl:lg:translate-x-0 print:hidden [--body-scroll:true] [--overlay-backdrop:true] lg:[--overlay-backdrop:false]">

    <!-- Sidenav Logo -->
    <div class="sticky top-0 flex h-topbar items-center justify-center px-6 border-b border-default-200">
        <a href="index">
            <img src="assets/images/logo.png" alt="logo" class="flex h-10">
        </a>
    </div>

    <div class="p-4" data-simplebar>
        <ul class="admin-menu hs-accordion-group flex w-full flex-col gap-1.5">
            <li class="menu-item">
                <a class="group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-700 transition-all hover:bg-default-900/5"
                    href="index">
                    <i class="material-symbols-rounded text-2xl">home</i>
                    Dashboard
                </a>
            </li>

            <li class="px-5 py-2 text-sm font-medium text-default-600">Management</li>

            <li class="menu-item">
                <a class="group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-700 transition-all hover:bg-default-900/5"
                    href="users">
                    <i class="material-symbols-rounded text-2xl">person</i>
                    Users
                </a>
            </li>

            

            <li class="menu-item">
                <a href="#"
                    class="group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-700 transition-all hover:bg-default-900/5"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="material-symbols-rounded text-2xl">logout</i>
                    Log Out
                </a>
                <form id="logout-form" action="logout" method="POST" class="hidden">
                </form>
            </li>
        </ul>
    </div>
</aside>
<!-- End Sidebar -->
<div class="page-content">
<main>