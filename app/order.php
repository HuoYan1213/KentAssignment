<?php
require 'base.php';
require 'head2.php';
require '_pager.php';

$o_id = $_GET['o_id'] ?? '';
$id = $_GET['id'] ?? '';
$status = $_GET['status'] ?? 'All';
$page = $_GET['page'] ?? 1;
$sort_by = $_GET['sort_by'] ?? 'o_id';
$sort_order = $_GET['sort_order'] ?? 'ASC';

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    
    $_db->prepare('DELETE FROM order_items WHERE o_id = ?')->execute([$delete_id]);

    
    $_db->prepare('DELETE FROM orders WHERE o_id = ?')->execute([$delete_id]);

    header('Location: order.php?action=deleted');
    exit;
}


$sql = 'SELECT * FROM orders WHERE 1';
$params = [];

if ($o_id !== '') {
    $sql .= ' AND o_id = ?';
    $params[] = $o_id;
}


if ($id !== '') {
    $sql .= ' AND id = ?';
    $params[] = $id;
}

if ($status !== 'All') {
    $sql .= ' AND status = ?';
    $params[] = $status;
}

$sql .= " ORDER BY $sort_by $sort_order";

$pager = new pager($sql, $params, 5, $page);
?>

<style>
.order-page {
    max-width: 1400px;
    margin: 40px auto;
    padding: 0 20px;
}

.order-page h1 {
    text-align: center;
    margin-bottom: 30px;
    font-size: 32px;
    color: #0b2c3d;
    font-weight: 600;
}

.success-msg {
    background: linear-gradient(135deg, #dcfce7, #bbf7d0);
    border-left: 4px solid #10b981;
    color: #047857;
    padding: 16px;
    border-radius: 8px;
    margin-bottom: 20px;
    font-weight: 600;
}

.filter-section {
    background: #fff;
    padding: 24px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    margin-bottom: 24px;
}

.filter-form {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 12px;
    margin-bottom: 16px;
    align-items: end;
}

.filter-form input,
.filter-form select {
    padding: 10px 14px;
    border: 1px solid #e6eef3;
    border-radius: 8px;
    font-size: 14px;
}

.filter-form input:focus,
.filter-form select:focus {
    outline: none;
    border-color: #0566a0;
    box-shadow: 0 0 0 3px rgba(5, 102, 160, 0.1);
}

.filter-form button {
    background: #0566a0;
    color: white;
    border: none;
    padding: 10px 24px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    transition: 0.2s;
}

.filter-form button:hover {
    background: #034c75;
}

.record-count {
    color: #6b7280;
    font-size: 14px;
    margin-bottom: 16px;
}

.sort-buttons {
    display: flex;
    gap: 8px;
    margin-bottom: 24px;
    flex-wrap: wrap;
}

.sort-btn {
    background: #f3f4f6;
    color: #034c75;
    border: 1px solid #e5e7eb;
    padding: 8px 16px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 13px;
    font-weight: 600;
    transition: 0.2s;
    text-decoration: none;
}

.sort-btn:hover {
    background: #e5e7eb;
    border-color: #034c75;
}

.order-table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    margin-bottom: 24px;
}

.order-table th {
    background: #034c75;
    color: white;
    padding: 16px;
    text-align: left;
    font-weight: 600;
    font-size: 13px;
    letter-spacing: 1px;
}

.order-table td {
    padding: 14px 16px;
    border-bottom: 1px solid #e6eef3;
    color: #0b2c3d;
    font-size: 14px;
}

.order-table tbody tr:last-child td {
    border-bottom: none;
}

.order-table tbody tr:hover {
    background: #f8fbfc;
}

.action-btn {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    margin-right: 6px;
    text-decoration: none;
    transition: 0.2s;
}

.btn-edit {
    background: #3b82f6;
    color: white;
}

.btn-edit:hover {
    background: #2563eb;
}

.btn-delete {
    background: #ef4444;
    color: white;
}

.btn-delete:hover {
    background: #dc2626;
}

.add-button {
    background: linear-gradient(135deg, #0566a0, #034c75);
    color: white;
    border: none;
    padding: 12px 32px;
    border-radius: 999px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    transition: 0.3s;
}

.add-button:hover {
    background: linear-gradient(135deg, #034c75, #02344e);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(3, 76, 117, 0.25);
}

@media(max-width: 1024px) {
    .filter-form {
        grid-template-columns: 1fr;
    }
}

@media(max-width: 768px) {
    .order-page {
        margin: 20px auto;
    }
    
    .order-table {
        font-size: 12px;
    }
    
    .order-table th,
    .order-table td {
        padding: 10px 8px;
    }
}
</style>

<div class="order-page">
    <h1>Order Management</h1>

    <?php if (isset($_GET['action'])): ?>
      <div class="success-msg">
        <?php
        if ($_GET['action'] == 'added') echo '✓ Order added successfully!';
        if ($_GET['action'] == 'edited') echo '✓ Order updated successfully!';
        if ($_GET['action'] == 'deleted') echo '✓ Order deleted successfully!';
        ?>
      </div>
    <?php endif; ?>

    <div class="filter-section">
        <form method="get" class="filter-form">
            <input type="text" name="o_id" placeholder="Search order ID..." value="<?= htmlspecialchars($o_id) ?>">
            <input type="text" name="id" placeholder="Search member ID..." value="<?= htmlspecialchars($id) ?>">
            <select name="status">
                <option value="All" <?= $status == 'All' ? 'selected' : '' ?>>All Status</option>
                <option value="Pending" <?= $status == 'Pending' ? 'selected' : '' ?>>Pending</option>
                <option value="Paid" <?= $status == 'Paid' ? 'selected' : '' ?>>Paid</option>
                <option value="Shipped" <?= $status == 'Shipped' ? 'selected' : '' ?>>Shipped</option>
                <option value="Completed" <?= $status == 'Completed' ? 'selected' : '' ?>>Completed</option>
                <option value="Cancelled" <?= $status == 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
            </select>
            <button type="submit">Search</button>
        </form>

        <p class="record-count">📊 <?= $pager->item_count ?> record(s) found</p>

        <div class="sort-buttons">
            <a href="?<?= http_build_query(array_merge($_GET, ['sort_by' => 'o_id', 'sort_order' => $sort_order == 'ASC' ? 'DESC' : 'ASC', 'page' => 1])) ?>" class="sort-btn">↕ Order ID</a>
            <a href="?<?= http_build_query(array_merge($_GET, ['sort_by' => 'id', 'sort_order' => $sort_order == 'ASC' ? 'DESC' : 'ASC', 'page' => 1])) ?>" class="sort-btn">↕ Member ID</a>
            <a href="?<?= http_build_query(array_merge($_GET, ['sort_by' => 'total_amount', 'sort_order' => $sort_order == 'ASC' ? 'DESC' : 'ASC', 'page' => 1])) ?>" class="sort-btn">↕ Total Amount</a>
        </div>
    </div>

    <table class="order-table">
        <thead>
            <tr>
                <th>ORDER ID</th>
                <th>MEMBER ID</th>
                <th>TOTAL AMOUNT</th>
                <th>STATUS</th>
                <th>ACTION</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pager->result as $s): ?>
            <tr>
                <td><?= htmlspecialchars($s->o_id) ?></td>
                <td><?= htmlspecialchars($s->id) ?></td>
                <td>RM <?= htmlspecialchars(number_format($s->total_amount, 2)) ?></td>
                <td><?= htmlspecialchars($s->status) ?></td>
                <td>
                    <a href="order_edit.php?edit_id=<?= urlencode($s->o_id) ?>" class="action-btn btn-edit">Edit</a>
                    <a href="?delete_id=<?= urlencode($s->o_id) ?>" class="action-btn btn-delete" onclick="return confirm('Are you sure you want to delete this order?')">Delete</a>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <?php
    $query = $_GET;
    unset($query['page'], $query['delete_id']);
    $href = http_build_query($query);
    $pager->html($href);
    ?>

</div>

<?php include 'footer.php'; ?>