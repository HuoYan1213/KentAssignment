<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_title ?? 'JLYY Food Ordering System' ?></title>
    <link rel="shortcut icon" href="images/logo.jpg">
    <link rel="stylesheet" href="/HEWASS/app/css/app.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="js/app.js"></script>
</head>
<body>
<div id="info"><?= temp('info') ?></div>

<header class="bw-header">
    <div class="bw-header-inner">
        <div class="bw-brand" onclick="window.location.href='main.php'">
            <img src="/HEWASS/app/images/logo.jpg" alt="BlueWave Sushi">
            <span class="bw-brand-name">BLUEWAVE</span>
        </div>

        <?php if ($_user): ?>
            <div class="bw-user">
                <span class="bw-role"><?= strtoupper($_user->role) ?></span>
                <img src="/HEWASS/app/user/images_user/<?= $_user->photo ?>" alt="User"
                     onclick="window.location.href='/HEWASS/app/user/profile.php';">
            </div>
        <?php endif ?>
    </div>
</header>

<nav class="bw-nav">
    <div class="bw-nav-inner">
        <div class="bw-nav-left">
            <a href="/HEWASS/app/main.php">HOME</a>
            <?php if ($_user): ?><a href="/HEWASS/app/product/product.php">MENU</a><?php endif ?>
            <?php if ($_user): ?><a href="/HEWASS/app/Cart/cart.php">CART</a><?php endif ?>
            <?php if ($_user?->role == 'admin'): ?><a href="/HEWASS/app/staff/home_pagae.php">MANAGEMENT</a><?php endif ?>
        </div>

        <div class="bw-nav-right">
            <a href="/HEWASS/app/about_us/us.php">ABOUT</a>

            <?php if ($_user): ?>
            <div class="bw-dropdown">
                <span><?= strtoupper($_user->name) ?></span>
                <div class="bw-dropdown-menu">
                    <a href="/HEWASS/app/user/profile.php">Profile</a>
                    <a href="/HEWASS/app/user/password.php">Security</a>
                    <a href="/HEWASS/app/user/history.php">Orders</a>
                    <a href="/HEWASS/app/logout.php">Logout</a>
                </div>
            </div>
            <?php endif ?>
        </div>
    </div>
</nav>


