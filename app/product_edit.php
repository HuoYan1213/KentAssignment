<?php
require 'base.php';

$edit_id = $_GET['edit_id'] ?? null;
$product = null;

if ($edit_id) {
    $stm = $_db->prepare('SELECT * FROM product WHERE p_id = ?');
    $stm->execute([$edit_id]);
    $product = $stm->fetch();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['p_name'];    
    $price = $_POST['p_price'];
    $quantity = $_POST['p_quantity'];
    $description = $_POST['p_description'];

    $p_photo = $product ? $product->p_photo : 'default.jpg';

    $f = get_file('p_photo');
    if ($f) {
        $upload_dir = 'images_product';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        $p_photo = save_photo($f, $upload_dir);
    }

    if ($edit_id) {
        $_db->prepare('UPDATE product SET p_name = ?, p_price = ?, p_quantity = ?, p_description = ?, p_photo = ? WHERE p_id = ?')
            ->execute([$name, $price, $quantity, $description, $p_photo, $edit_id]);
        header('Location: product.php?action=edited');
        exit;
    } else {
        $_db->prepare('INSERT INTO product (p_name, p_price, p_quantity, p_description, p_photo) VALUES (?, ?, ?, ?, ?)')
            ->execute([$name, $price, $quantity, $description, $p_photo]);
        header('Location: product.php?action=added');
        exit;
    }
}
require 'head2.php';
?>

<style>
.product-edit-page {
    max-width: 700px;
    margin: 40px auto;
    padding: 0 20px;
}

.product-edit-page h1 {
    text-align: center;
    margin-bottom: 30px;
    font-size: 32px;
    color: #0b2c3d;
    font-weight: 600;
}

.form-card {
    background: #fff;
    padding: 32px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.form-group {
    margin-bottom: 24px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #0b2c3d;
    font-size: 14px;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 12px 14px;
    border: 1px solid #e6eef3;
    border-radius: 8px;
    font-size: 14px;
    font-family: 'Inter', sans-serif;
    box-sizing: border-box;
    transition: 0.2s;
}

.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #0566a0;
    box-shadow: 0 0 0 3px rgba(5, 102, 160, 0.1);
}

.form-group textarea {
    resize: vertical;
    min-height: 120px;
}

.info-group {
    background: #f8fbfc;
    border-left: 4px solid #0566a0;
    padding: 16px;
    border-radius: 6px;
    margin-bottom: 24px;
}

.info-group .label {
    font-weight: 600;
    color: #0b2c3d;
    font-size: 13px;
    margin-bottom: 4px;
}

.info-group .value {
    color: #6b7280;
    font-size: 14px;
}

.photo-preview {
    margin-top: 12px;
    text-align: center;
}

.photo-preview img {
    max-width: 100%;
    height: 150px;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.button-group {
    display: flex;
    gap: 12px;
    margin-top: 32px;
    justify-content: center;
}

.btn-submit {
    background: linear-gradient(135deg, #0566a0, #034c75);
    color: white;
    border: none;
    padding: 12px 40px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
}

.btn-submit:hover {
    background: linear-gradient(135deg, #034c75, #02344e);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(3, 76, 117, 0.25);
}

.btn-cancel {
    background: #e5e7eb;
    color: #6b7280;
    border: none;
    padding: 12px 40px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: 0.2s;
    display: inline-block;
}

.btn-cancel:hover {
    background: #d1d5db;
    color: #4b5563;
}

@media(max-width: 768px) {
    .product-edit-page {
        margin: 20px auto;
    }

    .form-card {
        padding: 20px;
    }

    .button-group {
        flex-direction: column;
    }

    .btn-submit,
    .btn-cancel {
        width: 100%;
    }
}
</style>

<div class="product-edit-page">
    <h1><?= $edit_id ? 'Edit Product' : 'Add New Product' ?></h1>

    <div class="form-card">
        <?php if ($edit_id): ?>
            <div class="info-group">
                <div class="label">Product ID</div>
                <div class="value"><?= htmlspecialchars($edit_id) ?></div>
            </div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="p_name">Product Name *</label>
                <input type="text" id="p_name" name="p_name" value="<?= $product ? htmlspecialchars($product->p_name) : '' ?>" required>
            </div>

            <div class="form-group">
                <label for="p_price">Price (RM) *</label>
                <input type="number" id="p_price" name="p_price" step="0.01" value="<?= $product ? htmlspecialchars($product->p_price) : '' ?>" required>
            </div>

            <div class="form-group">
                <label for="p_quantity">Quantity *</label>
                <input type="number" id="p_quantity" name="p_quantity" value="<?= $product ? htmlspecialchars($product->p_quantity) : '' ?>" required>
            </div>

            <div class="form-group">
                <label for="p_description">Description *</label>
                <textarea id="p_description" name="p_description" required><?= $product ? htmlspecialchars($product->p_description) : '' ?></textarea>
            </div>

            <div class="form-group">
                <label for="p_photo">Product Photo</label>
                <input type="file" id="p_photo" name="p_photo" accept="image/*">
                <?php if (isset($product) && !empty($product->p_photo)): ?>
                    <div class="photo-preview">
                        <img src="<?= file_exists("images_product/$product->p_photo") ? "images_product/" . htmlspecialchars($product->p_photo) : "images/photo.jpg" ?>" alt="<?= htmlspecialchars($product->p_name) ?>">
                        <p style="color: #6b7280; font-size: 12px; margin-top: 8px;">Current photo</p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="button-group">
                <button type="submit" class="btn-submit"><?= $edit_id ? '✓ Update Product' : '✓ Add Product' ?></button>
                <a href="product.php" class="btn-cancel">✕ Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>