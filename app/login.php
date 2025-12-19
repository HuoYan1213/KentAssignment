<?php
include 'base.php';
$_title = 'Login';

if (is_post()) {
    $email    = req('email');
    $password = req('password');

    if ($email == '') $_err['email'] = 'Required';
    else if (!is_email($email)) $_err['email'] = 'Invalid email';

    if ($password == '') $_err['password'] = 'Required';

    if (!$_err) {
        $stm = $_db->prepare('
            SELECT * FROM user
            WHERE email = ? AND password = SHA1(?)
        ');
        $stm->execute([$email, $password]);
        $u = $stm->fetch();

        if ($u) {
            login($u);
            temp('info', 'Login successfully');
            header('Location: index.php');
            exit;
        }
        else {
            $_err['password'] = 'Email or password not matched';
        }
    }
}
include 'head.php';
?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap');

:root{
    --deep-blue:#0b2c3d;
    --soft-blue:#6fa6c9;
    --bg-white:#ffffff;
    --text-dark:#1f2d3d;
    --text-muted:#6b7280;
}

body{
    margin:0;
    font-family:'Inter',sans-serif;
}

/* ===== Background ===== */
.login-hero{
    height:100vh;
    background:url("images/sushi_b_1.jpg") center/cover no-repeat;
    position:relative;
}

.login-overlay{
    position:absolute;
    inset:0;
    background:rgba(0,0,0,0.45);
    display:flex;
    align-items:center;
    justify-content:center;
}

/* ===== Login Card ===== */
.login-card{
    width:420px;
    background:rgba(255,255,255,0.96);
    border-radius:22px;
    padding:50px 45px;
    box-shadow:0 30px 70px rgba(0,0,0,.25);
    text-align:center;
}

/* ===== Brand ===== */
.login-logo img{
    width:80px;
    margin-bottom:12px;
}

.login-title{
    font-weight:300;
    letter-spacing:3px;
    margin-bottom:8px;
}

.login-sub{
    font-size:13px;
    color:var(--text-muted);
    margin-bottom:35px;
}

/* ===== Form ===== */
.login-form input{
    max-width: 380px; 
    width:100%;
    padding:14px 16px;
    border-radius:14px;
    border:1px solid #e5e7eb;
    margin-bottom:14px;
    font-size:14px;
}

.login-form input:focus{
    outline:none;
    border-color:var(--soft-blue);
}

.error{
    text-align:left;
    font-size:12px;
    color:#dc2626;
    margin-bottom:10px;
}

/* ===== Button ===== */
.btn-login{
    width:100%;
    padding:14px;
    border-radius:40px;
    border:1px solid var(--deep-blue);
    background:transparent;
    letter-spacing:2px;
    font-size:13px;
    cursor:pointer;
    transition:.4s;
}

.btn-login:hover{
    background:var(--deep-blue);
    color:#fff;
}

/* ===== Extra Links ===== */
.login-extra{
    margin-top:25px;
    font-size:13px;
}

.login-extra a{
    color:var(--deep-blue);
    text-decoration:none;
}

.login-extra a:hover{
    text-decoration:underline;
}

.divider{
    margin:22px 0;
    height:1px;
    background:#e5e7eb;
}

.btn-create{
    border:none;
    background:none;
    font-size:13px;
    letter-spacing:2px;
    cursor:pointer;
    color:#000;
}

.btn-create:hover{
    color:var(--deep-blue);
}
</style>

<div class="login-hero">
    <div class="login-overlay">

        <div class="login-card">

            <div class="login-logo">
                <img src="images/logo.jpg" alt="JLYY">
            </div>

            <h2 class="login-title">BLUEWAVE SUSHI</h2>
            <p class="login-sub">Where Bluewave Sushi meets Joy</p>

            <div id="info"><?= temp('info') ?></div>

            <form method="post" class="login-form">
                <?= html_text('email', 'placeholder="Email"') ?>
                <?= err('email') ?>

                <?= html_password('password', 'placeholder="Password"') ?>
                <?= err('password') ?>

                <button class="btn-login">LOGIN</button>
            </form>

            <div class="login-extra">
                <a href="forget.php">Forgot password?</a>

                <div class="divider"></div>

                <button class="btn-create" onclick="location.href='signup.php'">
                    CREATE NEW ACCOUNT
                </button>
            </div>

        </div>

    </div>
</div>
