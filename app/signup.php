<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'base.php';
// ----------------------------------------------------------------------------

if (is_post()) {
    $email    = req('email');
    $password = req('password');
    $confirm  = req('confirm');
    $name     = req('name');
    $f = get_file('photo');
    
    // Validate: email
    if (!$email) {
        $_err['email'] = 'Required';
    }
    else if (strlen($email) > 100) {
        $_err['email'] = 'Maximum 100 characters';
    }
    else if (!is_email($email)) {
        $_err['email'] = 'Invalid email';
    }
    else if (!is_unique($email, 'user', 'email')) {
        $_err['email'] = 'Duplicated';
    }

    // Validate: password
    if (!$password) {
        $_err['password'] = 'Required';
    }
    else if (strlen($password) < 5 || strlen($password) > 100) {
        $_err['password'] = 'Between 5-100 characters';
    }

    // Validate: confirm
    if (!$confirm) {
        $_err['confirm'] = 'Required';
    }
    else if (strlen($confirm) < 5 || strlen($confirm) > 100) {
        $_err['confirm'] = 'Between 5-100 characters';
    }
    else if ($confirm != $password) {
        $_err['confirm'] = 'Not matched';
    }

    // Validate: name
    if (!$name) {
        $_err['name'] = 'Required';
    }
    else if (strlen($name) > 100) {
        $_err['name'] = 'Maximum 100 characters';
    }

    // Validate: photo (file)
    if (!$f) {
        $_err['photo'] = 'Required';
    }
    else if (!str_starts_with($f->type, 'image/')) {
        $_err['photo'] = 'Must be image';
    }
    else if ($f->size > 1 * 1024 * 1024) {
        $_err['photo'] = 'Maximum 1MB';
    }

     // DB operation
     if (!$_err) {

        // (1) Save photo
        if (!is_dir('images_user')) {
            mkdir('images_user', 0777, true);
        }
        $photo = save_photo($f, 'images_user');
        
        //  Insert user (member)
        $stm = $_db->prepare('
            INSERT INTO user (email, password, name, role, photo)
            VALUES (?, ?, ?, "member", ?)
        ');
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stm->execute([$email, $hashed_password, $name, $photo]);

        temp('info', 'Record inserted');
        redirect('login.php');
    }
}

$_title = 'User | Register Member';
include 'head.php';
?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap');

:root{
    --deep-blue:#0b2c3d;
    --soft-blue:#6fa6c9;
    --bg-white:#ffffff;
    --text-muted:#6b7280;
}
body{margin:0;font-family:'Inter',sans-serif}

.signup-hero{height:100vh;background:url("images/sushi_b_1.jpg") center/cover no-repeat;position:relative}
.signup-overlay{position:absolute;inset:0;background:rgba(0,0,0,0.45);display:flex;align-items:center;justify-content:center}

.signup-card{width:520px;background:rgba(255,255,255,0.97);border-radius:18px;padding:36px 42px;box-shadow:0 30px 70px rgba(0,0,0,.22)}
.signup-logo img{width:80px;margin-bottom:12px}
.signup-title{font-weight:300;letter-spacing:3px;margin-bottom:6px}
.signup-sub{font-size:13px;color:var(--text-muted);margin-bottom:20px}

.signup-form input[type="text"],.signup-form input[type="password"],.signup-form input[type="email"]{width:100%;padding:12px 14px;border-radius:12px;border:1px solid #e8eef3;margin-bottom:12px;font-size:14px}
.signup-form input:focus{outline:none;border-color:var(--soft-blue)}
.signup-form label.upload{display:inline-block;cursor:pointer}
.signup-form label.upload img{width:80px;height:80px;object-fit:cover;border-radius:8px;border:1px solid #e6eef3}
.signup-btn{display:block;width:100%;padding:12px;border-radius:999px;border:1px solid var(--deep-blue);background:var(--deep-blue);color:#fff;cursor:pointer;font-weight:700}
.signup-card .login-link{color:var(--deep-blue);text-decoration:none}
.error{color:#dc2626;font-size:13px;margin-bottom:10px}

@media(max-width:640px){.signup-card{width:92%;padding:24px}}
</style>

<div class="signup-hero">
    <div class="signup-overlay">
        <div class="signup-card">
            <div class="signup-logo">
                <img src="images/logo.jpg" alt="JLYY">
            </div>

            <h2 class="signup-title">JLYY ORDERING SYSTEM</h2>
            <p class="signup-sub">Create a new account to start ordering</p>

            <div id="info"><?= temp('info') ?></div>

            <form method="post" class="signup-form" enctype="multipart/form-data">
                <?= html_text('email', 'maxlength="100" placeholder="Email"') ?>
                <?= err('email') ?>

                <?= html_password('password', 'maxlength="100" placeholder="Password"') ?>
                <?= err('password') ?>

                <?= html_password('confirm', 'maxlength="100" placeholder="Confirm"') ?>
                <?= err('confirm') ?>

                <?= html_text('name', 'maxlength="100" placeholder="Full name"') ?>
                <?= err('name') ?>

                <label for="photo">Photo</label>
                <label class="upload" tabindex="0">
                    <?= html_file('photo', 'image/*', 'hidden') ?>
                    <img src="images/photo.jpg" alt="upload">
                </label>
                <?= err('photo') ?>

                <div style="margin-top:14px">
                    <button class="signup-btn">Sign up</button>
                </div>
            </form>

            <div style="text-align:center;margin-top:14px">
                <hr>
                <a href="login.php" class="login-link">Already have an account? Log in</a>
            </div>
        </div>
    </div>
</div>
