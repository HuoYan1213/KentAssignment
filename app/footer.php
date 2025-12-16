<footer class="bw-footer">
  <div class="bw-footer-inner">

    <!-- About Company -->
    <div class="bw-footer-column">
      <h4 class="bw-footer-title">BlueWave</h4>
      <a href="us.php">About Us</a>
      <a href="feedback_view.php">Feedback</a>
      <a href="contact.php">Contact Us</a>
      <a href="FAQ.php">FAQ</a>
    </div>

    <!-- Policy & Product -->
    <div class="bw-footer-column">
      <h4 class="bw-footer-title">Policy & Offerings</h4>
      <a href="product.php">Menu</a>
      <a href="term_policies.php">Terms & Conditions</a>
    </div>

    <!-- Payments -->
    <div class="bw-footer-column bw-footer-payments">
      <h4 class="bw-footer-title">Accepted Payments</h4>
      <div class="bw-payment-icons">
        <img src="images/visa.png" alt="Visa">
        <img src="images/mastercard.png" alt="Mastercard">
        <img src="images/mydebit.png" alt="MyDebit">
        <img src="images/TnG1.png" alt="TNG">
      </div>
      <p class="bw-footer-credit">
        Developed with ❤️ by <strong>BLUEWAVE SUSHI</strong> &middot; &copy; <?= date('Y') ?>
      </p>
    </div>

  </div>
</footer>

<style>
/* ================= BLUEWAVE FOOTER ================= */
.bw-footer {
    background: linear-gradient(180deg, #082231, #0b2c3d);
    color: #e5e7eb;
    padding: 60px 90px;
    font-family: 'Inter', sans-serif;
}

.bw-footer-inner {
    max-width: 1440px;
    margin: auto;
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 60px;
}

.bw-footer-column {
    display: flex;
    flex-direction: column;
    gap: 12px;
    min-width: 180px;
}

.bw-footer-title {
    font-size: 16px;
    font-weight: 600;
    letter-spacing: 2px;
    margin-bottom: 18px;
    color: #ffffff;
}

.bw-footer-column a {
    text-decoration: none;
    color: #cfd8e3;
    font-size: 13px;
    transition: color .3s;
}

.bw-footer-column a:hover {
    color: #ffffff;
}

.bw-footer-payments .bw-payment-icons {
    display: flex;
    gap: 12px;
    margin: 8px 0 18px;
}

.bw-footer-payments .bw-payment-icons img {
    width: 42px;
    height: 26px;
    object-fit: contain;
}

.bw-footer-credit {
    font-size: 12px;
    color: #9fb6c9;
    margin-top: 12px;
}

/* Responsive */
@media(max-width: 900px){
    .bw-footer-inner {
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 40px;
    }
    .bw-footer-column {
        align-items: center;
    }
    .bw-footer-payments .bw-payment-icons {
        justify-content: center;
    }
}
</style>
