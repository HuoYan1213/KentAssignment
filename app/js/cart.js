// Initialize cart if not exists in localStorage
if (!localStorage.getItem('foodCart')) {
    localStorage.setItem('foodCart', JSON.stringify({
        items: [],
        totalPrice: 0
    }));
}

// Load cart on page load
document.addEventListener('DOMContentLoaded', function() {
    updateCartCount();
    
    // If we're on the cart page, display cart items
    if (document.querySelector('.cart-page')) {
        displayCartItems();
    }
});

// Update the cart items count in the header
function updateCartCount() {
    const cartData = JSON.parse(localStorage.getItem('foodCart'));
    const cartCountElements = document.querySelectorAll('.cart-count');
    
    if (cartData && cartData.items) {
        const totalItems = cartData.items.reduce((total, item) => total + item.quantity, 0);
        
        cartCountElements.forEach(element => {
            element.textContent = totalItems;
        });
    } else {
        cartCountElements.forEach(element => {
            element.textContent = '0';
        });
    }
}

// Display cart items on the cart page
function displayCartItems() {
    const cartItemsContainer = document.getElementById('cart-items');
    
    // Exit if not on cart page
    if (!cartItemsContainer) return;
    
    const cartData = JSON.parse(localStorage.getItem('foodCart'));
    
    if (!cartData || !cartData.items || cartData.items.length === 0) {
        cartItemsContainer.innerHTML = `
            <tr>
                <td colspan="3" class="empty-cart">Your cart is empty</td>
            </tr>
        `;
        document.getElementById('cart-subtotal').textContent = 'RM 0.00';
        document.getElementById('cart-tax').textContent = 'RM 0.00';
        document.getElementById('cart-total').textContent = 'RM 0.00';
        return;
    }
    
    let cartHTML = '';
    let subtotal = 0;
    
    cartData.items.forEach((item, index) => {
        const itemTotal = item.price * item.quantity;
        subtotal += itemTotal;
        
        cartHTML += `
            <tr>
                <td>
                    <div class="cart-info">
                        <div>
                            <p>${item.name}</p>
                            <small>Price: RM ${item.price.toFixed(2)}</small>
                            <br>                            
                        </div>
                    </div>
                </td>
                <td>
                    <input type="number" value="${item.quantity}" min="1" 
                           onchange="updateQuantity(${index}, this.value)">
                </td>
                <td>RM ${itemTotal.toFixed(2)}</td>
                <td><span class="remove-btn" onclick="removeItem(${index})">Remove</span></td>
            </tr>
        `;
    });
    
    cartItemsContainer.innerHTML = cartHTML;
    
    // Calculate and display totals
    const tax = subtotal * 0.06; // 6% tax
    const total = subtotal + tax;
    
    document.getElementById('cart-subtotal').textContent = `RM ${subtotal.toFixed(2)}`;
    document.getElementById('cart-tax').textContent = `RM ${tax.toFixed(2)}`;
    document.getElementById('cart-total').textContent = `RM ${total.toFixed(2)}`;
}

// Remove item from cart
function removeItem(index) {
    const cartData = JSON.parse(localStorage.getItem('foodCart'));
    
    if (cartData && cartData.items) {
        cartData.items.splice(index, 1);
        
        // Recalculate total
        cartData.totalPrice = cartData.items.reduce((total, item) => {
            return total + (item.price * item.quantity);
        }, 0);
        
        localStorage.setItem('foodCart', JSON.stringify(cartData));
        updateCartCount();
        displayCartItems();
    }
}

// Update item quantity
function updateQuantity(index, quantity) {
    const cartData = JSON.parse(localStorage.getItem('foodCart'));
    
    if (cartData && cartData.items) {
        cartData.items[index].quantity = parseInt(quantity);
        
        // Recalculate total
        cartData.totalPrice = cartData.items.reduce((total, item) => {
            return total + (item.price * item.quantity);
        }, 0);
        
        localStorage.setItem('foodCart', JSON.stringify(cartData));
        updateCartCount();
        displayCartItems();
    }
}

// Add to cart function for the Food Menu page
function addToCart(productId) {
    const product = products.find(p => p.id === productId);
    const quantity = parseInt(document.getElementById(`qty-${productId}`).value);
    
    if (product && quantity > 0) {
        addItemToCart(product, quantity);
    }
}

// Add to cart function for the All Products page
function addItemToCart(product, quantity = 1) {
    const cartData = JSON.parse(localStorage.getItem('foodCart')) || {
        items: [],
        totalPrice: 0
    };
    
    const existingItemIndex = cartData.items.findIndex(item => item.id === product.id);
    
    if (existingItemIndex >= 0) {
        cartData.items[existingItemIndex].quantity += quantity;
    } else {
        cartData.items.push({
            id: product.id,
            name: product.name,
            price: product.price,
            quantity: quantity
        });
    }
    
    cartData.totalPrice = cartData.items.reduce((total, item) => total + (item.price * item.quantity), 0);
    
    localStorage.setItem('foodCart', JSON.stringify(cartData));
    updateCartCount();
    alert(`Added ${quantity} ${product.name} to cart`);
}

// Checkout button functionality
document.addEventListener('DOMContentLoaded', function() {
    const checkoutBtn = document.getElementById('checkout-btn');
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', function() {
            const cartData = JSON.parse(localStorage.getItem('foodCart'));
            if (!cartData || !cartData.items || cartData.items.length === 0) {
                alert('Your cart is empty. Please add items before checkout.');
            } else {
                alert('Proceeding to checkout...');
                // Redirect to checkout page or handle further actions
                // window.location.href = 'checkout.php';
            }
        });
    }
});

// Toggle menu function (for mobile)
function menutoggle() {
    var MenuItems = document.getElementById("MenuItems");
    if (MenuItems.style.maxHeight == "0px") {
        MenuItems.style.maxHeight = "200px";
    } else {
        MenuItems.style.maxHeight = "0px";
    }
}
