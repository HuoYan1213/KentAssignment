<?php
require 'base.php';
require 'head2.php';

$_title = 'User | Order History';

$id = $_SESSION['user']->id;

$sql = "SELECT o_id, total_amount, status FROM orders WHERE id = ?";
$stm = $_db->prepare($sql);
$stm->execute([$id]);
$orders = $stm->fetchAll();
?>

<div class="order-page">
    <h2 class="section-title">My Order History</h2>

    <?php if (empty($orders)): ?>
        <p class="no-orders">You have no orders yet.</p>
    <?php else: ?>
        <div class="order-grid">
            <?php foreach ($orders as $order): ?>
            <div class="order-card">
                <div class="order-header">
                    <span class="order-id">Order #<?= $order->o_id ?></span>
                    <span class="order-status <?= strtolower($order->status) ?>"><?= $order->status ?></span>
                </div>
                <div class="order-body">
                    <p><strong>Total:</strong> RM<?= number_format($order->total_amount, 2) ?></p>
                    <a href="order_detail.php?o_id=<?= $order->o_id ?>" class="btn-detail">View Details</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
/* ================= BLUEWAVE ORDER PAGE ================= */

body {
    margin: 0;
    font-family: 'Inter', sans-serif;
    background: #f6f8fa;
    color: #0b2c3d;
}

.order-page {
    max-width: 1200px;
    margin: 50px auto;
    padding: 0 30px;
}

.section-title {
    text-align: center;
    font-size: 36px;
    font-weight: 300;
    color: #0b2c3d;
    margin-bottom: 50px;
    letter-spacing: 2px;
}

.section-title::after {
    content: '';
    display: block;
    width: 80px;
    height: 3px;
    background: #1e40af;
    margin: 15px auto 0;
    border-radius: 2px;
}

/* Grid for cards */
.order-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
}

/* Individual order card */
.order-card {
    background: #ffffff;
    border-radius: 8px; 
    padding: 20px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.05); 
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: transform .3s, box-shadow .3s;
}

.order-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 36px rgba(0,0,0,0.08);
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.order-id {
    font-weight: 500;
    color: #0b2c3d;
    letter-spacing: 1px;
}

.order-status {
    font-weight: 600;
    padding: 6px 14px;
    border-radius: 12px;
    font-size: 13px;
}

/* Status colors */
.order-status.pending {
    background: #e0e7ff;
    color: #1e40af;
}

.order-status.shipped {
    background: #d1fae5;
    color: #059669;
}

.order-status.cancelled {
    background: #fee2e2;
    color: #b91c1c;
}

.order-body p {
    margin: 10px 0;
    color: #334155;
    font-size: 14px;
}


.btn-detail {
    display: inline-block;
    margin-top: 10px;
    padding: 8px 18px;
    background: #1e3a8a;
    color: #ffffff;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 500;
    transition: 0.3s;
}

.btn-detail:hover {
    background: #1e40af;
}

/* No orders message */
.no-orders {
    text-align: center;
    font-size: 16px;
    color: #64748b;
    margin-top: 30px;
}

/* Responsive */
@media(max-width: 768px) {
    .order-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php include 'footer.php'; ?>