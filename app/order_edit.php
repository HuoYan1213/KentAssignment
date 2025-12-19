<?php
require 'base.php';

$edit_id = $_GET['edit_id'] ?? null;
$order = null;
$error = null; 

if ($edit_id) {
    $stm = $_db->prepare('SELECT * FROM orders WHERE o_id = ?');
    $stm->execute([$edit_id]);
    $order = $stm->fetch();
    if (!$order) {
        die('Order not found.');
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = $_POST['status'];

    if ($edit_id) {
        $_db->prepare('UPDATE orders SET status = ? WHERE o_id = ?')
             ->execute([$status, $edit_id]);

        header('Location: order.php?action=edited');
        exit;
    } else {
        $id = $_POST['id'];
        $total_amount = $_POST['total_amount'];
    
        $stm = $_db->prepare('SELECT * FROM user WHERE id = ?');
        $stm->execute([$id]);
        $user = $stm->fetch();
    
        if ($user) {
          $_db->prepare('INSERT INTO orders (id, total_amount, status) VALUES (?, ?, ?)')
              ->execute([$id, $total_amount, $status]);
          header('Location: order.php?action=added');
          exit;
        } else {
          $error = "Invalid User ID. Please enter a valid user.";
        }
    }
}
require 'head2.php';
?>

<style>
.edit-page {
    max-width: 600px;
    margin: 40px auto;
    padding: 0 20px;
}

.edit-page h1 {
    text-align: center;
    margin-bottom: 30px;
    font-size: 32px;
    color: #0b2c3d;
    font-weight: 600;
}

.error-msg {
    background: linear-gradient(135deg, #fee2e2, #fecaca);
    border-left: 4px solid #ef4444;
    color: #dc2626;
    padding: 16px;
    border-radius: 8px;
    margin-bottom: 20px;
    font-weight: 600;
}

.form-card {
    background: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-weight: 600;
    color: #0b2c3d;
    margin-bottom: 8px;
    font-size: 14px;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 12px 14px;
    border: 1px solid #e6eef3;
    border-radius: 8px;
    font-size: 14px;
    font-family: inherit;
}

.form-group input:focus,
.form-group select:focus {
    outline: none;
    border-color: #0566a0;
    box-shadow: 0 0 0 3px rgba(5, 102, 160, 0.1);
}

.info-group {
    background: #f8fbfc;
    padding: 16px;
    border-radius: 8px;
    margin-bottom: 20px;
    border-left: 4px solid #0566a0;
}

.info-group p {
    margin: 8px 0;
    color: #0b2c3d;
    font-size: 14px;
}

.info-group strong {
    color: #034c75;
    font-weight: 600;
}

.button-group {
    display: flex;
    gap: 12px;
    margin-top: 24px;
}

.btn-submit {
    flex: 1;
    background: linear-gradient(135deg, #0566a0, #034c75);
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 999px;
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
    flex: 1;
    background: #6b7280;
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 999px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
    text-decoration: none;
    text-align: center;
}

.btn-cancel:hover {
    background: #4b5563;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(75, 85, 99, 0.25);
}

@media(max-width: 768px) {
    .edit-page {
        margin: 20px auto;
    }
    
    .form-card {
        padding: 20px;
    }
    
    .button-group {
        flex-direction: column;
    }
}
</style>

<div class="edit-page">
    <h1><?= $edit_id ? '📝 Edit Order' : '➕ Add New Order' ?></h1>

    <?php if ($error): ?>
        <div class="error-msg">⚠️ <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="form-card">
        <form method="post">
            <?php if ($edit_id): ?>
                <div class="info-group">
                    <p><strong>Order ID:</strong> <?= htmlspecialchars($order->o_id) ?></p>
                    <p><strong>Member ID:</strong> <?= htmlspecialchars($order->id) ?></p>
                    <p><strong>Total Amount:</strong> RM <?= htmlspecialchars(number_format($order->total_amount, 2)) ?></p>
                </div>
            <?php else: ?>
                <div class="form-group">
                    <label for="id">User ID *</label>
                    <input type="number" id="id" name="id" placeholder="Enter user ID" required>
                </div>

                <div class="form-group">
                    <label for="total_amount">Total Amount (RM) *</label>
                    <input type="number" id="total_amount" name="total_amount" step="0.01" placeholder="0.00" required>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label for="status">Order Status *</label>
                <select id="status" name="status" required>
                    <?php
                        $statuses = ['Pending', 'Paid', 'Shipped', 'Completed', 'Cancelled'];
                        $current = $order->status ?? 'Pending';
                        foreach ($statuses as $s) {
                           $selected = $current === $s ? 'selected' : '';
                            echo "<option value='" . htmlspecialchars($s) . "' $selected>" . htmlspecialchars($s) . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="button-group">
                <button type="submit" class="btn-submit"><?= $edit_id ? '✓ Update Status' : '✓ Add Order' ?></button>
                <a href="order.php" class="btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>