<?php
require "base.php";
include "head2.php";
?>

<link rel="stylesheet" href="css/aboutUs.css">

<!-- HERO -->
<section class="bw-advanced-hero">
    <div class="bw-advanced-hero-content">
      <h1>BLUEWAVE SUSHI</h1>
      <p>Refined sushi. Seamless ordering experience.</p>
    </div>
</section>

<!-- ABOUT -->
<section class="bw-advanced-section">
    <h2 class="bw-advanced-section-title">ABOUT BLUEWAVE SUSHI</h2>
    <p class="bw-advanced-section-text">
      BlueWave Sushi embodies the elegance and discipline of Japanese culinary tradition.
      From ingredient selection to our digital ordering system, every step is crafted with
      precision and balance. Guests enjoy a calm, intuitive, and refined experience — focusing
      on what truly matters: exceptional sushi.
    </p>
</section>

<div class="bw-advanced-container">

  <!-- TEAM -->
  <section class="bw-advanced-section alt">
    <h2 class="bw-advanced-section-title">OUR FOUNDING TEAM</h2>
    <div class="bw-advanced-team-grid">
      <div class="bw-advanced-team-card">
        <img src="picture/ZhiYing.jpg" alt="Gan Zhi Ying">
        <h3>Gan Zhi Ying</h3>
        <span>System Architecture & Logic</span>
      </div>
      <div class="bw-advanced-team-card">
        <img src="picture/WeiJian.jpg" alt="See Wei Jian">
        <h3>See Wei Jian</h3>
        <span>User Interface Design</span>
      </div>
      <div class="bw-advanced-team-card">
        <img src="picture/QiLin.jpg" alt="Chong Qi Lin">
        <h3>Chong Qi Lin</h3>
        <span>Backend Development</span>
      </div>
    </div>
  </section>

  <!-- FEATURES -->
  <section class="bw-advanced-section">
    <h2 class="bw-advanced-section-title">WHY CHOOSE BLUEWAVE</h2>
    <ul class="bw-advanced-feature-list">
      <li><strong>Crafted Quality</strong> — premium sushi made with care</li>
      <li><strong>Seamless Ordering</strong> — intuitive, minimal steps</li>
      <li><strong>Calm & Refined</strong> — digital flow inspired by Japanese dining</li>
    </ul>
  </section>

  <!-- FEEDBACK -->
  <section class="bw-advanced-section alt">
    <h2 class="bw-advanced-section-title">FEEDBACK CENTER</h2>
    <div class="bw-advanced-action-grid">
      <a href="feedback_view.php" class="bw-advanced-action-card">
        <h3>View Feedback</h3>
        <p>Discover what our guests are saying</p>
      </a>
      <a href="feedback_add.php" class="bw-advanced-action-card">
        <h3>Submit Feedback</h3>
        <p>Share your experience with BlueWave Sushi</p>
      </a>
    </div>
  </section>

</div>

</body>
</html>
<?php include 'footer.php'; ?>