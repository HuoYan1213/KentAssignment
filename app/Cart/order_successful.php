<?php
require '../base.php';
require '../head2.php';
$_title = 'Order Successful';

if (!$_user) {
    die('You must be logged in to place an order.');
}

$userId = $_user->id;

// Retrieve POST data
$cartRaw = post('cart_data', '');
$paymentMethod = post('payment_method', '');

if (!$cartRaw) {
    die('Cart is empty.');
}

$cart = json_decode($cartRaw, true);

$subtotal = 0;
foreach ($cart['items'] as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}

$packaging = 3.00;
$tax = $subtotal * 0.06;
$total_amount = $subtotal + $packaging + $tax;

try {
    $_db->beginTransaction();

    // STEP 1: insert orders
    $stmt = $_db->prepare("INSERT INTO orders (id, total_amount, status) VALUES (?, ?, 'Paid')");
    $stmt->execute([$userId, $total_amount]);

    $orderId = $_db->lastInsertId();

    // STEP 2: insert order_items
    $itemStmt = $_db->prepare("INSERT INTO order_items (o_id, p_id, quantity, price) VALUES (?, ?, ?, ?)");
    foreach ($cart['items'] as $item) {
        $itemStmt->execute([
            $orderId,
            $item['id'],
            $item['quantity'],
            $item['price']
        ]);
    }

    $_db->commit();
} catch (Exception $e) {
    $_db->rollBack();
    die("Failed to place order: " . $e->getMessage());
}
?>

<style>
.order-success-page {
    max-width: 1000px;
    margin: 40px auto;
    padding: 0 20px;
}

.success-message {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    padding: 30px;
    border-radius: 8px;
    text-align: center;
    margin-bottom: 30px;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
}

.success-message h1 {
    margin: 0 0 10px 0;
    font-size: 28px;
    font-weight: 700;
}

.success-message p {
    margin: 0;
    font-size: 16px;
}

.receipt-box {
    background: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    margin-bottom: 30px;
}

.receipt-header {
    text-align: center;
    margin-bottom: 20px;
}

.receipt-header img {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
}

.receipt-items {
    margin-bottom: 20px;
}

.item-row {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr;
    gap: 16px;
    padding: 12px 0;
    border-bottom: 1px solid #e6eef3;
    color: #0b2c3d;
    font-size: 14px;
}

.item-row.header {
    font-weight: 700;
    background: #f8fbfc;
    padding: 12px;
    margin: -30px -30px 12px -30px;
    padding: 12px 30px;
}

.item-row:last-child {
    border-bottom: none;
}

.totals {
    border-top: 2px solid #034c75;
    padding-top: 16px;
    margin-top: 16px;
}

.total-row {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    color: #0b2c3d;
    font-size: 14px;
}

.total-row.final-total {
    font-weight: 700;
    font-size: 16px;
    color: #034c75;
}

.payment-info {
    background: #f8fbfc;
    padding: 16px;
    border-radius: 8px;
    margin-top: 20px;
    color: #0b2c3d;
    font-size: 14px;
}

.payment-info strong {
    color: #034c75;
}

.action-buttons {
    display: flex;
    gap: 12px;
    justify-content: center;
    margin-top: 30px;
}

.btn {
    background: linear-gradient(135deg, #0566a0, #034c75);
    color: white;
    border: none;
    padding: 12px 32px;
    border-radius: 999px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
    text-decoration: none;
    display: inline-block;
}

.btn:hover {
    background: linear-gradient(135deg, #034c75, #02344e);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(3, 76, 117, 0.25);
}

.btn-secondary {
    background: #6b7280;
}

.btn-secondary:hover {
    background: #4b5563;
}

@media(max-width: 768px) {
    .order-success-page {
        margin: 20px auto;
    }
    
    .item-row {
        grid-template-columns: 1fr;
        gap: 8px;
    }
    
    .action-buttons {
        flex-direction: column;
    }
}
</style>

<div class="order-success-page">
    <div class="success-message">
        <h1>✓ Thank You for Your Order!</h1>
        <p>Your payment has been processed successfully.</p>
    </div>

    <div class="receipt-box">
        <div class="receipt-header">
            <img src="../images/logo.jpg" alt="JLYY Restaurant">
            <h2 style="margin: 12px 0 0 0; color: #0b2c3d;">Order Receipt</h2>
        </div>

        <div class="receipt-items" id="receipt-items">
        </div>

        <div class="totals">
            <div class="total-row"><span>Subtotal</span><span id="subtotal">RM 0.00</span></div>
            <div class="total-row"><span>Packaging Fee</span><span>RM 3.00</span></div>
            <div class="total-row"><span>Tax (6%)</span><span id="tax">RM 0.00</span></div>
            <div class="total-row final-total"><span>Total</span><span id="total">RM 0.00</span></div>
        </div>

        <div class="payment-info">
            <strong>Payment Method:</strong> 
            <?php
            $map = [
                'debit' => 'Debit Card',
                'credit' => 'Credit Card',
                'touchngo' => "Touch 'n Go eWallet",
                'JLYY' => 'JLYY Pay'
            ];
            echo $map[$paymentMethod] ?? 'Unknown';
            ?>
        </div>
    </div>

    <div style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); text-align: center; margin-bottom: 30px; color: #0b2c3d;">
        <p style="margin: 0; font-size: 16px; font-weight: 600;">
            ⏱️ Your meal will be ready for pickup in <strong>20 minutes</strong>
        </p>
    </div>

    <div class="action-buttons">
        <a href="../product/product.php" class="btn">Continue Shopping</a>
        <a href="../user/history.php" class="btn btn-secondary">View Orders</a>
        <a href="../main.php" class="btn btn-secondary">Back to Home</a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const cartData = JSON.parse(localStorage.getItem('foodCart')) || { items: [], totalPrice: 0 };
    const receiptItems = document.getElementById('receipt-items');

    if (!cartData.items || cartData.items.length === 0) {
        receiptItems.innerHTML = '<p>Your cart is empty.</p>';
        return;
    }

    let subtotal = 0;
    receiptItems.innerHTML = `
        <div class="item-row header">
            <div>Product</div>
            <div>Price × Qty</div>
            <div>Total</div>
        </div>
    `;

    cartData.items.forEach(item => {
        const itemTotal = item.price * item.quantity;
        subtotal += itemTotal;

        receiptItems.innerHTML += `
            <div class="item-row">
                <div>${item.name}</div>
                <div>RM${item.price.toFixed(2)} × ${item.quantity}</div>
                <div>RM${itemTotal.toFixed(2)}</div>
            </div>
        `;
    });

    const packaging = 3.00;
    const tax = subtotal * 0.06;
    const total = subtotal + packaging + tax;

    document.getElementById('subtotal').textContent = `RM ${subtotal.toFixed(2)}`;
    document.getElementById('tax').textContent = `RM ${tax.toFixed(2)}`;
    document.getElementById('total').textContent = `RM ${total.toFixed(2)}`;

    localStorage.removeItem('foodCart');
});
</script>
</body>
</html>

<?php include '../footer.php'; ?>