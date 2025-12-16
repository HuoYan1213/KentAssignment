<?php
require '_base.php';
include "_head.php";

$rating_filter = isset($_GET['rating']) ? (int)$_GET['rating'] : 0;

if ($rating_filter >= 1 && $rating_filter <= 5) {
    $stm = $_db->prepare('SELECT * FROM feedback WHERE rating = ? ORDER BY id DESC');
    $stm->execute([$rating_filter]);
} else {
    $stm = $_db->query('SELECT * FROM feedback ORDER BY id DESC');
}

$feedbacks = $stm->fetchAll();

$count_aqua = $count_cobalt = $count_sky = $count_azure = $count_ice = 0;

foreach ($feedbacks as $f) {
    switch ((int)$f->rating) {
        case 5: $count_aqua++; break;
        case 4: $count_cobalt++; break;
        case 3: $count_sky++; break;
        case 2: $count_azure++; break;
        case 1: $count_ice++; break;
    }
}

$total_feedbacks = count($feedbacks);
?>

<body>
<div class="bwfb-container">

  <!-- Feedback Summary -->
  <section class="bwfb-summary">
      <h2>Feedback Overview</h2>

      <!-- Filter -->
      <form method="get" class="bwfb-filter">
          <label for="bwfb-rating">Filter by Rating:</label>
          <select name="rating" id="bwfb-rating" onchange="this.form.submit()">
              <option value="">All Ratings</option>
              <option value="5" <?= ($rating_filter===5)?'selected':'' ?>>5 Stars</option>
              <option value="4" <?= ($rating_filter===4)?'selected':'' ?>>4 Stars</option>
              <option value="3" <?= ($rating_filter===3)?'selected':'' ?>>3 Stars</option>
              <option value="2" <?= ($rating_filter===2)?'selected':'' ?>>2 Stars</option>
              <option value="1" <?= ($rating_filter===1)?'selected':'' ?>>1 Star</option>
          </select>
      </form>

      <div class="bwfb-summary-cards">
          <div class="bwfb-card">
              <span>Total</span>
              <h3><?= $total_feedbacks ?></h3>
          </div>
          <div class="bwfb-card">
              <span>5 ⭐⭐⭐⭐⭐</span>
              <h3><?= $count_aqua ?></h3>
          </div>
          <div class="bwfb-card">
              <span>4 ⭐⭐⭐⭐</span>
              <h3><?= $count_cobalt ?></h3>
          </div>
          <div class="bwfb-card">
              <span>3 ⭐⭐⭐</span>
              <h3><?= $count_sky ?></h3>
          </div>
          <div class="bwfb-card">
              <span>2 ⭐⭐</span>
              <h3><?= $count_azure ?></h3>
          </div>
          <div class="bwfb-card">
              <span>1 ⭐</span>
              <h3><?= $count_ice ?></h3>
          </div>
      </div>
  </section>
</div>

  <!-- Feedback List -->
  <section class="bwfb-list">
  <?php if ($total_feedbacks == 0): ?>
      <p class="bwfb-empty">No feedback yet. Be the first to share your experience!</p>
  <?php else: ?>
      <?php foreach ($feedbacks as $f): ?>
      <div class="bwfb-item">
          <div class="bwfb-header">
              <span class="bwfb-user">User #<?= $f->id ?></span>
              <span class="bwfb-stars"><?= str_repeat('⭐', (int)$f->rating) ?></span>
          </div>
          <p class="bwfb-message"><?= htmlspecialchars($f->message) ?></p>
      </div>
      <?php endforeach; ?>
  <?php endif; ?>
  </section>


</body>
</html>
