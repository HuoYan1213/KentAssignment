<?php
require 'base.php';
require 'head2.php';
?>

<div class="product-page">
    <!-- search bar -->
    <div class="product-search-container">
        <form method="GET" action="">
            <input type="text" name="product_search" placeholder="Search products..."
                   value="<?php echo isset($_GET['product_search']) ? htmlspecialchars($_GET['product_search']) : ''; ?>">
            <button type="submit">Search</button>
            <?php if(isset($_GET['product_search'])): ?>
                <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="product-clear-search">Clear</a>
            <?php endif; ?>
        </form>
    </div>   

    <div class="product-container">
        <?php
        require 'db.php';
        
        try {
            $product_sql = "SELECT * FROM product";
            $product_params = [];

            if(isset($_GET['product_search']) && !empty($_GET['product_search'])) {
                $searchTerm = $_GET['product_search'];
                $product_sql .= " WHERE p_name LIKE :search";
                $product_params[':search'] = "%$searchTerm%";
            }

            $product_stmt = $_db->prepare($product_sql);
            $product_stmt->execute($product_params);
            $product_items = $product_stmt->fetchAll();

            if(count($product_items) == 0) {
                echo "<div class='product-no-results'>No products found matching your search.</div>";
            }

            foreach ($product_items as $product_item) {                
                $product_outOfStock = $product_item->p_quantity <= 0;
                $product_disabledAttr = $product_outOfStock ? 'disabled' : '';
                $product_outLabel = $product_outOfStock ? "<span class='product-out-of-stock'>Out of Stock</span>" : "";

                $p_photo = file_exists("images_product/{$product_item->p_photo}") ? "images_product/{$product_item->p_photo}" : "images/photo.jpg";

                echo "
                <div class='product-item-row'>
                    <div class='product-item-image'>
                        <img src='$p_photo' alt='{$product_item->p_name}' />
                    </div>
                    <div class='product-item-text'>
                        <h3>{$product_item->p_name}</h3>
                        <p>{$product_item->p_description}</p>
                        <p><strong>Price:</strong> RM {$product_item->p_price}</p>
                        
                        {$product_outLabel}

                        <div class='product-quantity-control'>
                            <button onclick='productDecreaseQty(\"product-qty-{$product_item->p_id}\")' {$product_disabledAttr}>–</button>
                            <input type='number' id='product-qty-{$product_item->p_id}' value='1' min='1' class='product-quantity-input' {$product_disabledAttr}/>
                            <button onclick='productIncreaseQty(\"product-qty-{$product_item->p_id}\")' {$product_disabledAttr}>+</button>
                        </div>

                        <button class='product-small-btn' onclick='productAddToCart(\"{$product_item->p_name}\", {$product_item->p_price}, \"{$product_item->p_id}\")' {$product_disabledAttr}>
                            <span class='product-icon'>🛒</span> Add to Cart
                        </button>
                    </div>
                </div>";
            }
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        ?>
    </div>
</div>

<style>
.product-page .product-search-container {
    text-align: center;
    margin-top: 40px; 
    margin-bottom: 30px; 
}

.product-page .product-search-container input[type="text"] {
    padding: 10px 15px;
    width: 250px;
    border: 1px solid #90b4d8;
    border-radius: 8px;
    font-size: 16px;
}
.product-page .product-search-container button {
    padding: 10px 20px;
    background-color: #034c75;
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}
.product-page .product-search-container button:hover {
    background-color: #02344e;
}
.product-page .product-clear-search {
    margin-left: 10px;
    color: #02344e;
    text-decoration: none;
    font-size: 14px;
}
.product-page .product-clear-search:hover {
    text-decoration: underline;
}

.product-page .product-categories {
    text-align: center;
    margin-bottom: 30px;
}
.product-page .product-category-btn {
    padding: 12px 25px;
    background-color: #0566a0;
    color: white;
    border: none;
    border-radius: 20px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    margin: 5px;
    transition: 0.3s;
}
.product-page .product-category-btn:hover {
    background-color: #034c75;
    transform: translateY(-2px);
}

.product-page .product-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
}
.product-page .product-item-row {
    display: flex;
    flex-direction: column;
    background: #ffffff;
    border: 1px solid #90b4d8;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    padding: 20px;
    width: 250px;
    transition: transform 0.3s, box-shadow 0.3s;
}
.product-page .product-item-row:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}
.product-page .product-item-image img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-radius: 12px;
    margin-bottom: 15px;
}
.product-page .product-item-text h3 {
    margin: 0 0 8px;
    font-size: 20px;
    color: #0b2c3d;
}
.product-page .product-item-text p {
    margin: 4px 0;
    font-size: 14px;
    color: #0b2c3d;
}
.product-page .product-label {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: bold;
    color: white;
    margin-top: 5px;
    margin-bottom: 10px;
}
.product-page .product-label.halal { background-color: #2a7f4f; }
.product-page .product-label.non-halal { background-color: #d9534f; }
.product-page .product-out-of-stock {
    display: inline-block;
    background-color: #ccc;
    color: #fff;
    padding: 4px 10px;
    font-size: 12px;
    border-radius: 6px;
    margin-top: 5px;
}
.product-page .product-quantity-control {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin: 10px 0;
}
.product-page .product-quantity-control button {
    width: 30px;
    height: 30px;
    background-color: #034c75;
    color: white;
    border: none;
    border-radius: 50%;
    font-weight: bold;
    cursor: pointer;
    transition: 0.2s;
}
.product-page .product-quantity-control button:hover { background-color: #02344e; }
.product-page .product-quantity-input {
    width: 50px;
    text-align: center;
    border: 1px solid #90b4d8;
    border-radius: 6px;
}
.product-page .product-small-btn {
    background: linear-gradient(135deg, #0566a0, #034c75);
    color: white;
    border: none;
    padding: 10px 18px;
    border-radius: 999px;
    font-size: 14px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
    width: 100%;
    margin-top: 10px;
}
.product-page .product-small-btn:hover {
    background: linear-gradient(135deg, #034c75, #02344e);
}

@media(max-width:1024px) {
    .product-page .product-item-row { width: 45%; }
}
@media(max-width:768px) {
    .product-page .product-item-row { width: 90%; }
    .product-page .product-search-container input[type="text"] { width: 70%; }
}
</style>

<script src="js/cart.js"></script>

<script>
function productFilterCategory(category) {
    const allProducts = document.querySelectorAll('.product-page .product-item-row');
    allProducts.forEach(product => {
        product.style.display = (category === 'all' || product.classList.contains(category)) ? 'flex' : 'none';
    });
}

function productIncreaseQty(id) {
    const input = document.getElementById(id);
    input.value = parseInt(input.value) + 1;
}

function productDecreaseQty(id) {
    const input = document.getElementById(id);
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
    }
}

function productAddToCart(name, price, id) {
    const quantity = parseInt(document.getElementById('product-qty-' + id).value);
    const isConfirmed = window.confirm(`Are you sure you want to add ${quantity} ${name} to the cart for RM ${price * quantity}?`);
    if (isConfirmed) {
        const product = {id, name, price, quantity};
        addItemToCart(product, quantity);
        alert(`${quantity} ${name} has been added to your cart.`);
    }
}
</script>

<?php
require 'footer.php';
?>