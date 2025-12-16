<?php
include 'base.php';

if (is_post()) {
    $email = req('email');

    if ($email == '') {
        $_err['email'] = 'Required';
    }
    else if (!is_email($email)) {
        $_err['email'] = 'Invalid email';
    }
    else if (!is_exists($email, 'user', 'email')) {
        $_err['email'] = 'Not exists';
    }

    if (!$_err) {
        $stm = $_db->prepare('SELECT * FROM user WHERE email=?');
        $stm->execute([$email]);
        $u = $stm->fetch();

        $id = sha1(uniqid() . rand());

        $stm = $_db->prepare('
            DELETE FROM token WHERE user_id = ?;
            INSERT INTO token (id, expire, user_id)
            VALUES (?, ADDTIME(NOW(), "00:05"), ?);
        ');
        $stm->execute([$u->id, $id, $u->id]);

        $url = "/var/www/html/HewAss/app/user/token.php?id=$id";

        $m = get_mail();
        $m->addAddress($u->email, $u->name);
        $m->isHTML(true);
        $m->Subject = 'Reset Password';
        $m->Body = "
            <p>Dear $u->name,</p>
            <h2 style='color:#0b2c3d'>Reset Password</h2>
            <p>
                Click <a href='$url'>here</a> to reset your password.
            </p>
            <p>From, JLYY Admin</p>
        ";
        $m->send();

        temp('info', 'Reset link sent to your email');
        redirect('login.php');
    }
}

$_title = 'Forgot Password';
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
.forget-hero{
    height:100vh;
    background:url("images/sushi_b_1.jpg") center/cover no-repeat;
    position:relative;
}

.forget-overlay{
    position:absolute;
    inset:0;
    background:rgba(0,0,0,0.45);
    display:flex;
    align-items:center;
    justify-content:center;
}

/* ===== Card ===== */
.forget-card{
    width:420px;
    background:rgba(255,255,255,0.96);
    border-radius:22px;
    padding:50px 45px;
    box-shadow:0 30px 70px rgba(0,0,0,.25);
    text-align:center;
}

/* ===== Title ===== */
.forget-title{
    font-weight:300;
    letter-spacing:3px;
    margin-bottom:10px;
}

.forget-sub{
    font-size:13px;
    color:var(--text-muted);
    margin-bottom:35px;
}

/* ===== Form ===== */
.forget-form input{
    width:100%;
    padding:14px 16px;
    border-radius:14px;
    border:1px solid #e5e7eb;
    margin-bottom:14px;
    font-size:14px;
}

.forget-form input:focus{
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
.btn-forget{
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

.btn-forget:hover{
    background:var(--deep-blue);
    color:#fff;
}

/* ===== Links ===== */
.forget-extra{
    margin-top:25px;
    font-size:13px;
}

.forget-extra a{
    color:var(--deep-blue);
    text-decoration:none;
}

.forget-extra a:hover{
    text-decoration:underline;
}
</style>

<div class="forget-hero">
    <div class="forget-overlay">

        <div class="forget-card">

            <h2 class="forget-title">FORGOT PASSWORD</h2>
            <p class="forget-sub">
                Enter your email and we’ll send you a reset link
            </p>

            <div id="info"><?= temp('info') ?></div>

            <form method="post" class="forget-form">
                <?= html_text('email', 'placeholder="Email address"') ?>
                <?= err('email') ?>

                <button class="btn-forget">
                    SEND RESET LINK
                </button>
            </form>

            <div class="forget-extra">
                <a href="login.php">← Back to Login</a>
            </div>

        </div>

    </div>
</div>
