<?php
require 'base.php';
require 'head2.php';

$_title = 'User | Order Detail';

$o_id = $_GET['o_id'] ?? 0;
$userId = $_SESSION['user']->id;

$sqlOrder = "SELECT * FROM orders WHERE o_id = ? AND id = ?";
$stmtOrder = $_db->prepare($sqlOrder);
$stmtOrder->execute([$o_id, $userId]);
$order = $stmtOrder->fetch();

if (!$order) {
    die("Order not found or you don't have permission to view it.");
}

$sqlItems = "
    SELECT oi.*, p.p_name AS product_name
    FROM order_items oi
    JOIN product p ON oi.p_id = p.p_id
    WHERE oi.o_id = ?
";
$stmtItems = $_db->prepare($sqlItems);
$stmtItems->execute([$o_id]);
$items = $stmtItems->fetchAll();
?>

<div class="order-page">
    <h2 class="section-title">Order Details #<?= $order->o_id ?></h2>

    <div class="order-detail-grid">
        <?php 
        $subtotal = 0;
        foreach ($items as $item):
            $total = $item->price * $item->quantity;
            $subtotal += $total;
        ?>
        <div class="order-detail-card">
            <div class="order-detail-item">
                <span class="product-name"><?= $item->product_name ?></span>
                <span class="product-qty">$<?= number_format($item->price,2) ?> × <?= $item->quantity ?></span>
                <span class="product-total">$<?= number_format($total,2) ?></span>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="order-summary">
        <div><span>Subtotal:</span> <span>RM<?= number_format($subtotal,2) ?></span></div>
        <div><span>Packaging:</span> <span>RM3.00</span></div>
        <div><span>Tax (6%):</span> <span>RM<?= number_format($subtotal*0.06,2) ?></span></div>
        <div class="total"><span>Total:</span> <span>RM<?= number_format($subtotal + 3 + $subtotal*0.06,2) ?></span></div>
    </div>

    <div class="btn-back-wrapper">
        <a href="history.php" class="btn-detail">Back to History</a>
    </div>
</div>

<style>
/* ================= BLUEWAVE ORDER DETAIL ================= */
    body {
        margin: 0;
        font-family: 'Inter', sans-serif;
        background: #f6f8fa;
        color: #0b2c3d;
    }

    .order-page {
        max-width: 1000px;
        margin: 50px auto;
        padding: 0 30px;
    }

    .section-title {
        text-align: center;
        font-size: 32px;
        font-weight: 300;
        color: #0b2c3d;
        margin-bottom: 40px;
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

    /* Grid for order items */
    .order-detail-grid {
        display: grid;
        gap: 15px;
        margin-bottom: 30px;
    }

    /* Individual order item card */
    .order-detail-card {
        background: #ffffff;
        border-radius: 8px;
        padding: 18px 22px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.05);
        display: flex;
        flex-direction: column;
    }

    .order-detail-item {
        display: flex;
        justify-content: space-between;
        font-size: 15px;
        color: #334155;
        margin-bottom: 6px;
    }

    .order-detail-item span {
        display: inline-block;
        min-width: 100px;
        text-align: right;
    }

    .product-name {
        text-align: left;
        font-weight: 500;
    }

    /* Order summary */
    .order-summary {
        background: #ffffff;
        border-radius: 8px;
        padding: 20px 25px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.05);
        margin-bottom: 30px;
    }

    .order-summary div {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        font-size: 15px;
        color: #0b2c3d;
    }

    .order-summary .total {
        font-weight: 600;
        font-size: 16px;
        border-top: 1px solid #e2e8f0;
        padding-top: 10px;
    }

    /* Button */
    .btn-back-wrapper {
        text-align: center;
        margin-top: 30px; 
    }

    .btn-detail {
        display: inline-block;
        padding: 10px 22px;
        background: #1e3a8a33;
        color: #1e40af;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 500;
        border: 1px solid #1e40af;
        transition: 0.3s;
    }

    .btn-detail:hover {
        background: #1e40af1a;
        color: #1e40af;
        border-color: #1e40af;
    }

    /* Responsive */
    @media(max-width:768px) {
        .order-detail-item {
            flex-direction: column;
            align-items: flex-start;
        }

        .order-detail-item span {
            text-align: left;
            min-width: auto;
        }
    }
</style>

<?php include 'footer.php'; ?>