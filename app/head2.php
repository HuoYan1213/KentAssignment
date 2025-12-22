<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_title ?? 'JLYY Food Ordering System' ?></title>
    <link rel="shortcut icon" href="images/logo.jpg">
    <link rel="stylesheet" href="css/app.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="js/app.js"></script>
</head>
<body>
<div id="info"><?= temp('info') ?></div>

<header class="bw-header">
    <div class="bw-header-inner">
        <div class="bw-brand" onclick="window.location.href='main.php'">
            <img src="images/logo.jpg" alt="BlueWave Sushi">
            <span class="bw-brand-name">BLUEWAVE</span>
        </div>

        <?php if ($_user): ?>
            <div class="bw-user">
                <span class="bw-role"><?= strtoupper($_user->role) ?></span>
                <img src="<?= ($_user->photo && file_exists("images_user/$_user->photo")) ? "images_user/$_user->photo" : "images/photo.jpg" ?>" alt="User"
                     onclick="window.location.href='profile.php';">
            </div>
        <?php endif ?>
    </div>
</header>

<nav class="bw-nav">
    <div class="bw-nav-inner">
        <div class="bw-nav-left">
            <a href="main.php">HOME</a>
            <?php if ($_user): ?><a href="user_product.php">MENU</a><?php endif ?>
            <?php if ($_user): ?><a href="cart.php">CART</a><?php endif ?>
            <?php if ($_user?->role == 'admin'): ?><a href="home_pagae.php">MANAGEMENT</a><?php endif ?>
        </div>

        <div class="bw-nav-right">
            <a href="us.php">ABOUT</a>

            <?php if ($_user): ?>
            <div class="bw-dropdown">
                <span><?= strtoupper($_user->name) ?></span>
                <div class="bw-dropdown-menu">
                    <a href="profile.php">Profile</a>
                    <a href="password.php">Security</a>
                    <a href="history.php">Orders</a>
                    <a href="logout.php">Logout</a>
                </div>
            </div>
            <?php endif ?>
        </div>
    </div>
</nav>

<style>
    .bw-nav-right {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .bw-dropdown {
        position: relative;
        display: inline-flex;
        align-items: center;
        cursor: pointer;
        height: 100%;
        padding: 10px 0;
    }

    .bw-dropdown-menu {
        display: none; 
        position: absolute;
        top: 100%;
        right: 0; 
        background-color: #ffffff;
        min-width: 160px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        border-radius: 8px;
        z-index: 9999; 
        overflow: hidden;
        flex-direction: column;
        margin-top: 5px; 
    }

    .bw-dropdown:hover .bw-dropdown-menu {
        display: flex;
    }

    .bw-dropdown-menu a {
        padding: 12px 20px;
        text-decoration: none;
        color: #333;
        font-size: 14px;
        white-space: nowrap;
        border-bottom: 1px solid #f3f4f6;
        transition: background 0.2s;
        display: block;
    }

    .bw-dropdown-menu a:last-child {
        border-bottom: none;
    }

    .bw-dropdown-menu a:hover {
        background-color: #f9fafb;
        color: #0566a0;
    }
</style>
