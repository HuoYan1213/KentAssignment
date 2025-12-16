<?php
include "app/head.php";
?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap');

:root{
    --deep-blue:#0b2c3d;
    --soft-blue:#6fa6c9;
    --bg-white:#ffffff;
    --text-muted:#e5e7eb;
}

body{
    margin:0;
    font-family:'Inter',sans-serif;
}

/* ===== Hero Background ===== */
.welcome-hero{
    height:100vh;
    background:url("images/sushi_b_7.jpg") center/cover no-repeat;
    position:relative;
}

/* ===== Overlay ===== */
.welcome-overlay{
    position:absolute;
    inset:0;
    background:rgba(0,0,0,0.45);
    display:flex;
    align-items:center;
    justify-content:center;
    text-align:center;
}

/* ===== Content ===== */
.welcome-content{
    max-width:720px;
    padding:0 20px;
}

.welcome-title{
    font-size:40px;
    font-weight:300;
    letter-spacing:3px;
    color:#fff;
    margin-bottom:20px;
}

.welcome-sub{
    font-size:17px;
    color:var(--text-muted);
    margin-bottom:45px;
    line-height:1.8;
}

/* ===== Button ===== */
.btn-enter{
    padding:14px 46px;
    border:1px solid #fff;
    color:#fff;
    background:transparent;
    border-radius:40px;
    font-size:14px;
    letter-spacing:2px;
    cursor:pointer;
    transition:.4s;
}

.btn-enter:hover{
    background:#fff;
    color:#000;
}

/* ===== Responsive ===== */
@media(max-width:768px){
    .welcome-title{
        font-size:34px;
    }
}
</style>

<div class="welcome-hero">
    <div class="welcome-overlay">
        <div class="welcome-content">

            <h1 class="welcome-title">
                WELCOME TO BLUEWAVE SUSHI
            </h1>

            <p class="welcome-sub">
                Where Bluewave Sushi Meets Joy.  
                A refined sushi experience, crafted with precision.
            </p>

            <button class="btn-enter" onclick="location.href='app/login.php'">
                ENTER SYSTEM
            </button>

        </div>
    </div>
</div>
