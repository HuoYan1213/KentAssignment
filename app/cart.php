<?php 
require "base.php";
require 'head2.php'; 
?>

<style>
.cart-page {
    max-width: 1200px;
    margin: 40px auto;
    padding: 0 20px;
}

.cart-page h1 {
    text-align: center;
    margin-bottom: 30px;
    font-size: 32px;
    color: #0b2c3d;
    font-weight: 600;
}

.cart-page table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    margin-bottom: 30px;
}

.cart-page table th {
    background: #034c75;
    color: white;
    padding: 16px;
    text-align: left;
    font-weight: 600;
    font-size: 14px;
    letter-spacing: 1px;
}

.cart-page table td {
    padding: 14px 16px;
    border-bottom: 1px solid #e6eef3;
    color: #0b2c3d;
}

.cart-page tbody tr:last-child td {
    border-bottom: none;
}

.cart-page tbody tr:hover {
    background: #f8fbfc;
}

.total-price {
    background: #fff;
    padding: 24px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    margin-bottom: 30px;
    max-width: 400px;
    margin-left: auto;
    margin-right: auto;
}

.total-price table {
    width: 100%;
    margin: 0;
    box-shadow: none;
}

.total-price table tr {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid #e6eef3;
}

.total-price table tr:last-child {
    border-bottom: none;
    font-weight: 700;
    font-size: 18px;
    color: #034c75;
}

.total-price table td {
    border: none;
    padding: 0;
}

.price-align {
    text-align: right;
}

.checkout-btn-container {
    text-align: center;
    margin-bottom: 40px;
}

.btn {
    background: linear-gradient(135deg, #0566a0, #034c75);
    color: white;
    border: none;
    padding: 14px 40px;
    border-radius: 999px;
    font-size: 15px;
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

.remove-btn {
    color: #dc2626;
    cursor: pointer;
    text-decoration: none;
    font-weight: 600;
    font-size: 13px;
    transition: 0.2s;
}

.remove-btn:hover {
    color: #b91c1c;
    text-decoration: underline;
}

@media(max-width: 768px) {
    .cart-page {
        margin: 20px auto;
    }
    
    .cart-page table,
    .total-price {
        font-size: 14px;
    }
    
    .cart-page table th,
    .cart-page table td {
        padding: 12px 8px;
    }
}
</style>

<div class="cart-page">
    <h1>Shopping Cart</h1>
    <table>
    <thead>
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Subtotal</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody id="cart-items">        
    </tbody>
</table>


    <div class="total-price">
        <table>
            <tr>
                <td>Subtotal</td>
                <td class="price-align" id="cart-subtotal">RM 0.00</td>
            </tr>
            <tr>
                <td>Tax</td>
                <td class="price-align" id="cart-tax">RM 0.00</td>
            </tr>
            <tr>
                <td>Total</td>
                <td class="price-align" id="cart-total">RM 0.00</td>
            </tr>
        </table>
    </div>

    <div class="checkout-btn-container">
        <a href="checkout.php" class="btn">Proceed to Checkout</a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cartData = JSON.parse(localStorage.getItem('foodCart')) || { items: [], totalPrice: 0 };
        const cartItemsContainer = document.getElementById('cart-items');
        const subtotalElement = document.getElementById('cart-subtotal');
        const taxElement = document.getElementById('cart-tax');
        const totalElement = document.getElementById('cart-total');

        if (cartData.items.length === 0) {
            cartItemsContainer.innerHTML = '<tr><td colspan="4">Your cart is empty.</td></tr>';
            subtotalElement.textContent = 'RM 0.00';
            taxElement.textContent = 'RM 0.00';
            totalElement.textContent = 'RM 0.00';
            return;
        }

        let subtotal = 0;

        cartData.items.forEach((item, index) => {
            const itemTotal = item.price * item.quantity;
            subtotal += itemTotal;

            cartItemsContainer.innerHTML += `
                <tr>
                    <td>${item.name}</td>
                    <td>${item.quantity}</td>
                    <td>RM ${itemTotal.toFixed(2)}</td>
                    <td><span class="remove-btn" onclick="removeItem(${index})">Remove</span></td>
                </tr>
            `;
        });

        const tax = subtotal * 0.06;
        const total = subtotal + tax;

        subtotalElement.textContent = `RM ${subtotal.toFixed(2)}`;
        taxElement.textContent = `RM ${tax.toFixed(2)}`;
        totalElement.textContent = `RM ${total.toFixed(2)}`;
    });
</script>

<script src="js/cart.js"></script>
</body>
</html>
<?php include 'footer.php'; ?>