<?php
include 'base.php';
auth('admin','member');
$_title = 'BlueWave Sushi';
include 'head2.php';
?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap');

:root{
    --deep-blue:#0b2c3d;
    --soft-blue:#6fa6c9;
    --bg-white:#ffffff;
    --bg-light:#f6f8fa;
    --text-dark:#1f2d3d;
    --text-muted:#6b7280;
}

body{
    margin:0;
    font-family:'Inter',sans-serif;
    background:var(--bg-light);
    color:var(--text-dark);
    line-height:1.8;
}

/* ================= HERO ================= */
.sushi-hero{
    position:relative;
    height:85vh;
    overflow:hidden;
}

.hero-slide{
    position:absolute;
    inset:0;
    opacity:0;
    transition:opacity 1.5s ease;
}

.hero-slide.active{ opacity:1; }

.hero-slide img{
    width:100%;
    height:100%;
    object-fit:cover;
}

.hero-overlay{
    position:absolute;
    inset:0;
    background:rgba(0,0,0,0.35);
    display:flex;
    align-items:center;
    justify-content:center;
    text-align:center;
}

.hero-content h1{
    font-size:56px;
    font-weight:300;
    color:#fff;
    letter-spacing:2px;
    margin-bottom:20px;
}

.hero-content p{
    color:#e5e7eb;
    font-size:18px;
    margin-bottom:40px;
}

.hero-btn{
    padding:14px 46px;
    border:1px solid #fff;
    color:#fff;
    text-decoration:none;
    border-radius:40px;
    font-size:14px;
    letter-spacing:2px;
    transition:.4s;
}

.hero-btn:hover{
    background:#fff;
    color:#000;
}

/* ================= SECTION BASE ================= */
.section{
    padding:80px 10%;
    background:var(--bg-white);
}

.section.alt{
    background:var(--bg-light);
}

.section-title{
    font-size:34px;
    font-weight:300;
    text-align:center;
    letter-spacing:3px;
    margin-bottom:80px;
}

/* ================= SIGNATURE ================= */
.signature-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:45px;
}

.signature-item img{
    width:100%;
    height:360px;
    object-fit:cover;
    border-radius:12px;
}

.signature-item{
    text-align: center;
}

.signature-item h3{
    margin:16px 0 6px;
    font-weight:400;
}

.signature-item p{
    margin:0;
    font-size:13px;
    letter-spacing:1px;
    color:#6b7280;
}

/* ================= ABOUT ================= */
.about-wrap{
    display:grid;
    grid-template-columns:1.2fr 0.8fr;
    gap:80px;
    align-items:center;
}

.about-text h2{
    font-size:32px;
    font-weight:300;
    letter-spacing:2px;
    margin-bottom:30px;
}

.about-text p{
    max-width:520px;
    color:var(--text-muted);
    margin-bottom:30px;
}

.about-list{
    list-style:none;
    padding:0;
}

.about-list li{
    margin-bottom:18px;
    font-size:14px;
    letter-spacing:1px;
}

.about-image img{
    width:280px;
    height:420px;
    object-fit:cover;
    border-radius:14px;
}

/* ===== Chef Philosophy ===== */
.chef-philosophy{
    background:#eef2f7;
    padding:80px 10%;
}

.chef-wrapper{
    display:grid;
    grid-template-columns: 1fr 1fr;
    gap:80px;
    align-items:center;
}

.chef-image img{
    width:100%;
    height:520px;
    object-fit:cover;
    border-radius:18px;
}

.chef-label{
    font-size:12px;
    letter-spacing:3px;
    color:#64748b;
}

.chef-text h2{
    font-size:38px;
    margin:15px 0 20px;
    color:#0f172a;
}

.chef-lead{
    font-size:18px;
    color:#334155;
    line-height:1.8;
}

.chef-divider{
    width:60px;
    height:2px;
    background:#1e40af;
    margin:30px 0;
}

.chef-desc{
    font-size:15px;
    line-height:1.9;
    color:#475569;
}

.chef-sign{
    margin-top:30px;
    font-style:italic;
    color:#1e293b;
}

/* ================= LOCATION ================= */
.map-frame{
    width:100%;
    height:380px;
    border-radius:14px;
    border:none;
}
.map-container{
    width:100%;
    height:420px;
    border:none;
    border-radius:20px;
    box-shadow:0 20px 50px rgba(0,0,0,.12);
}

/* ================= TESTIMONIAL ================= */
.testimonial-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:36px;
}

.testimonial{
    font-size:14px;
    color:var(--text-muted);
}

.testimonial span{
    display:block;
    margin-top:16px;
    font-size:12px;
    color:var(--deep-blue);
    letter-spacing:1px;
}

/* ================= RESPONSIVE ================= */
@media(max-width:900px){
    .signature-grid,
    .testimonial-grid{
        grid-template-columns:1fr;
    }
    .about-wrap{
        grid-template-columns:1fr;
        text-align:center;
    }
    .about-image img{
        margin:auto;
    }
}
</style>

<!-- HERO -->
<section class="sushi-hero">
    <div class="hero-slide active"><img src="images/sushi_b_8.avif"></div>
    <div class="hero-slide"><img src="images/sushi_b_2.jpg"></div>
    <div class="hero-slide"><img src="images/sushi_b_6.avif"></div>

    <div class="hero-overlay">
        <div class="hero-content">
            <h1>BLUEWAVE SUSHI</h1>
            <p>Refined sushi. Crafted with silence & precision.</p>
            <a href="product/product.php" class="hero-btn">DISCOVER MENU</a>
        </div>
    </div>
</section>

<!-- SIGNATURE -->
<section class="section">
    <h2 class="section-title">SIGNATURE SELECTION</h2>
    <div class="signature-grid">
        <div class="signature-item">
            <img src="images/Dragon_Roll.jpg">
            <h3>Dragon Roll</h3>
            <p>Unagi · Avocado · House Sauce</p>
        </div>
        <div class="signature-item">
            <img src="images/Salmon_Nigiri.jpg">
            <h3>Salmon Nigiri</h3>
            <p>Premium cut · Hand-pressed rice</p>
        </div>
        <div class="signature-item">
            <img src="images/Rainbow_Roll.jpg">
            <h3>Rainbow Roll</h3>
            <p>Seasonal fish · Balanced harmony</p>
        </div>
    </div>
</section>

<!-- ABOUT -->
<section class="section alt">
    <div class="about-wrap">
        <div class="about-text">
            <h2>WHY BLUEWAVE</h2>
            <p>
                Inspired by traditional Japanese craftsmanship,  
                BlueWave Sushi delivers an elevated dining experience through simplicity.
            </p>
            <ul class="about-list">
                <li>— Daily sourced premium seafood</li>
                <li>— Trained sushi chefs with authentic techniques</li>
                <li>— Minimalist, calm dining atmosphere</li>
                <li>— Seamless ordering experience</li>
            </ul>
        </div>
        <div class="about-image">
            <img src="images/sushi_3.jpg">
        </div>
    </div>
</section>

<!-- Chef Philosophy -->
<section class="chef-philosophy">
    <div class="chef-wrapper">

        <div class="chef-image">
            <img src="images/sushi_chef.avif" alt="Sushi Chef">
        </div>

        <div class="chef-text">
            <span class="chef-label">OUR PHILOSOPHY</span>
            <h2>The Art Behind Every Slice</h2>

            <p class="chef-lead">
                Sushi is not fast food.  
                It is a balance of timing, temperature, and respect.
            </p>

            <div class="chef-divider"></div>

            <p class="chef-desc">
                Our head chef believes that true sushi begins long before it reaches the plate.  
                From selecting seasonal fish at dawn to precise knife work, every step follows
                Japanese tradition with a modern touch.
            </p>

            <p class="chef-sign">
                — Head Chef, BlueWave Sushi
            </p>
        </div>

    </div>
</section>

<!-- LOCATION -->
<section class="section">
    <h2 class="section-title">OUR LOCATION</h2>
    <iframe
      class="map-container"
      src="https://www.google.com/maps?q=Kampar%20Perak&output=embed"
      loading="lazy"
      referrerpolicy="no-referrer-when-downgrade">
  </iframe>
</section>

<!-- TESTIMONIAL -->
<section class="section alt">
    <h2 class="section-title">GUEST EXPERIENCE</h2>
    <div class="testimonial-grid">
        <div class="testimonial">
            “Exceptional freshness and balance.”
            <span>— Emily R.</span>
        </div>
        <div class="testimonial">
            “A calm and refined sushi experience.”
            <span>— Daniel K.</span>
        </div>
        <div class="testimonial">
            “True Japanese craftsmanship.”
            <span>— Mei Ling</span>
        </div>
    </div>
</section>

<script>
let slides=document.querySelectorAll('.hero-slide');
let i=0;
setInterval(()=>{
    slides[i].classList.remove('active');
    i=(i+1)%slides.length;
    slides[i].classList.add('active');
},5000);
</script>

<?php include 'footer.php'; ?>
