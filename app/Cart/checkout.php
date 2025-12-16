<?php require '_head.php'; ?>

<style>
.checkout-page {
    max-width: 1200px;
    margin: 40px auto;
    padding: 0 20px;
}

.checkout-page h1 {
    text-align: center;
    margin-bottom: 30px;
    font-size: 32px;
    color: #0b2c3d;
    font-weight: 600;
}

.checkout-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
    margin-bottom: 40px;
}

.checkout-box {
    background: #fff;
    padding: 24px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.checkout-title {
    margin: 0 0 20px 0;
    font-size: 20px;
    color: #0b2c3d;
    font-weight: 600;
}

.payment-methods {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.payment-methods label {
    display: flex;
    align-items: center;
    padding: 12px;
    border: 1px solid #e6eef3;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.2s;
}

.payment-methods label:hover {
    background: #f8fbfc;
    border-color: #90b4d8;
}

.payment-methods input[type="radio"] {
    margin-right: 10px;
    cursor: pointer;
}

.checkout-summary-item {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid #e6eef3;
    color: #0b2c3d;
    font-size: 14px;
}

.checkout-summary-item:last-child {
    border-bottom: none;
}

.checkout-summary-item.checkout-total {
    font-weight: 700;
    font-size: 16px;
    color: #034c75;
    padding-top: 12px;
}

.checkout-btn {
    display: block;
    width: 100%;
    background: linear-gradient(135deg, #0566a0, #034c75);
    color: white;
    border: none;
    padding: 14px;
    border-radius: 999px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
    margin-top: 20px;
}

.checkout-btn:hover {
    background: linear-gradient(135deg, #034c75, #02344e);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(3, 76, 117, 0.25);
}

@media(max-width: 768px) {
    .checkout-container {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="checkout-page">
    <h1>Checkout</h1>
    
    <form id="checkout-form" action="order_successful.php" method="POST">
        <input type="hidden" name="cart_data" id="cart_data_input">
        <input type="hidden" name="payment_method" id="payment_method_input">

        <div class="checkout-container">
            <!-- Payment Section -->
            <div class="checkout-box">
                <h2 class="checkout-title">Payment Method</h2>
                <div class="payment-methods">
                    <label><input type="radio" name="payment" value="debit" checked> Debit Card</label>
                    <label><input type="radio" name="payment" value="credit"> Credit Card</label>
                    <label><input type="radio" name="payment" value="touchngo"> Touch 'n Go eWallet</label>
                    <label><input type="radio" name="payment" value="JLYY"> JLYY Pay</label>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="checkout-box">
                <h2 class="checkout-title">Your Order</h2>
                <div id="checkout-summary">
                    <!-- JavaScript will fill in this part -->
                </div>
                <button type="submit" class="checkout-btn">Place Order</button>
            </div>
        </div>
    </form>
</div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cartData = JSON.parse(localStorage.getItem('foodCart')) || { items: [], totalPrice: 0 };
            const summary = document.getElementById('checkout-summary');

            if (cartData.items.length === 0) {
                window.location.href = 'cart.php';
                return;
            }

            summary.innerHTML = '';
            cartData.items.forEach(item => {
                summary.innerHTML += `
                    <div class="checkout-summary-item">
                        <span>${item.name} × ${item.quantity}</span>
                        <span>RM ${(item.price * item.quantity).toFixed(2)}</span>
                    </div>
                `;
            });

            const subtotal = cartData.totalPrice;
            const packaging = 3.00;
            const tax = subtotal * 0.06;
            const total = subtotal + packaging + tax;

            summary.innerHTML += `
                <div class="checkout-summary-item"><span>Subtotal</span><span>RM ${subtotal.toFixed(2)}</span></div>
                <div class="checkout-summary-item"><span>Packaging fee</span><span>RM ${packaging.toFixed(2)}</span></div>
                <div class="checkout-summary-item"><span>Tax (6%)</span><span>RM ${tax.toFixed(2)}</span></div>
                <div class="checkout-summary-item checkout-total"><span>Total</span><span>RM ${total.toFixed(2)}</span></div>
            `;
        });

        document.getElementById('checkout-form').addEventListener('submit', function () {
            const cartData = localStorage.getItem('foodCart');
            const paymentMethod = document.querySelector('input[name="payment"]:checked').value;

            document.getElementById('cart_data_input').value = cartData;
            document.getElementById('payment_method_input').value = paymentMethod;
        });
    </script>
</body>
</html>

<?php include '../footer.php'; ?>