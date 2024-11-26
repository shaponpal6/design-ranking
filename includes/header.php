<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once 'db_config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Admin Dashboard" name="description">

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Jsvectormap plugin css -->
    <link href="assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css">

    <!-- Icons css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css">

    <!-- App css -->
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css">

    <script src="assets/libs/iconify-icon/iconify-icon.min.js"></script>

    <style type="text/css">
        .logo-wrapper {
            position: relative;
            display: inline-block;
            width: 100px;
            height: 100px;
        }

        .logo-edit {
            cursor: pointer;
            font-size: 16px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .logo-wrapper:hover .logo-edit {
            opacity: 1;
        }

        .logo-input {
            display: none;
        }
    </style>
</head>

<body>
    <div class="wrapper">