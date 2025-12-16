<?php 
require '_base.php'; 
require '_head.php';
?>

<!-- HERO -->
<section class="bw-contact-hero">
    <div class="bw-contact-hero-inner">
        <h1>Contact BlueWave Sushi</h1>
        <p>Need Assistance? We’re here for you 24/7! Reach out to us through any of the options below.</p>
    </div>
</section>

<!-- CONTACT CARDS -->
<section class="bw-contact-section">
    <a href="mailto:bluewave@example.com" class="bw-contact-card">
        <div class="bw-contact-icon">📧</div>
        <h3>Email Us</h3>
        <p>bluewave@example.com</p>
    </a>

    <a href="tel:0123456789" class="bw-contact-card">
        <div class="bw-contact-icon">📞</div>
        <h3>Call Us</h3>
        <p>012-3456789</p>
    </a>
</section>

<!-- CONTACT INFO TABLE -->
<section class="bw-contact-info">
    <h2>Contact Us</h2>
    <table class="bw-contact-table">
        <tr>
            <th><span class="icon">🏢</span> Company</th>
            <td>BlueWave Sushi</td>
        </tr>
        <tr>
            <th><span class="icon">✉️</span> Email</th>
            <td>bluewave@example.com</td>
        </tr>
        <tr>
            <th><span class="icon">📞</span> Phone</th>
            <td>012-3456789</td>
        </tr>
        <tr>
            <th><span class="icon">⏰</span> Hours</th>
            <td>24 hours, 7 days a week</td>
        </tr>
    </table>
</section>

<style>
/* ===== HERO ===== */
.bw-contact-hero{
    padding:120px 10% 100px;
    background:
        linear-gradient(rgba(11,44,61,.75), rgba(11,44,61,.75)),
        url("picture/contact.webp") center/cover no-repeat;
    text-align:center;
    color:#fff;
}

.bw-contact-hero-inner h1{
    font-size:46px;
    font-weight:300;
    letter-spacing:4px;
    margin-bottom:20px;
}

.bw-contact-hero-inner p{
    font-size:16px;
    color:#e5e7eb;
    max-width:700px;
    margin:auto;
    line-height:1.9;
}

/* ===== CONTACT CARDS ===== */
.bw-contact-section{
    padding:80px 10%;
    display:flex;
    justify-content:center;
    gap:36px;
    flex-wrap:wrap;
}

.bw-contact-card{
    background:#ffffff;
    padding:34px 30px;
    border-radius:18px;
    text-decoration:none;
    color:#1f2d3d;
    box-shadow:0 18px 40px rgba(0,0,0,.08);
    text-align:center;
    width:280px;
    transition:.4s ease;
}

.bw-contact-card:hover{
    transform:translateY(-6px);
    box-shadow:0 28px 60px rgba(11,44,61,.18);
}

.bw-contact-icon{
    font-size:36px;
    margin-bottom:20px;
}

.bw-contact-card h3{
    font-size:20px;
    margin-bottom:10px;
    letter-spacing:1px;
}

.bw-contact-card p{
    font-size:14px;
    color:#6b7280;
}

/* ===== CONTACT INFO TABLE ===== */
.bw-contact-info{
    padding:100px 10%;
    text-align:center;
    font-family:'Segoe UI', sans-serif;
}

.bw-contact-info h2{
    font-size:40px;
    margin-bottom:60px;
    font-weight:600;
    color:#0b2c3d;
    letter-spacing:1.5px;
}

.bw-contact-table{
    width:100%;
    max-width:800px;
    margin:auto;
    border-collapse:separate;
    border-spacing:0 20px;
    font-size:18px;
    color:#1f2d3d;
}

.bw-contact-table th{
    text-align:left;
    padding:25px;
    background:none;
    color:#0b2c3d;
    font-weight:500;
    font-size:18px;
    letter-spacing:0.5px;
    border-left:4px solid #0b2c3d;
    border-radius:6px 0 0 6px;
}

.bw-contact-table td{
    padding:25px;
    background:none;
    font-size:18px;
    border-left:none;
    text-align:left;
}

.bw-contact-table tr{
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius:12px;
}

.bw-contact-table tr:hover td{
    transform: translateY(-2px);
    box-shadow:0 6px 20px rgba(0,0,0,0.08);
}

.bw-contact-table .icon{
    margin-right:12px;
}

/* ===== RESPONSIVE ===== */
@media(max-width:768px){
    .bw-contact-info{
        padding:60px 5%;
    }
    .bw-contact-table th, .bw-contact-table td{
        padding:20px;
        font-size:16px;
    }
}
</style>
