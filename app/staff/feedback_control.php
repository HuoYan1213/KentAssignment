<?php
require '_base.php';
require '_pager.php';

$f_id = $_GET['f_id'] ?? '';
$id = $_GET['id'] ?? '';
$message = $_GET['message'] ?? '';
$status = $_GET['status'] ?? '';
$page = $_GET['page'] ?? 1;
$sort_by = $_GET['sort_by'] ?? 'f_id';
$sort_order = $_GET['sort_order'] ?? 'ASC';

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $_db->prepare('DELETE FROM feedback WHERE f_id = ?')->execute([$delete_id]);
    header('Location: feedback_control.php?action=deleted');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id'])) {
    $edit_id = $_POST['edit_id'];
    $new_status = $_POST['new_status'];
    $_db->prepare('UPDATE feedback SET status = ? WHERE f_id = ?')->execute([$new_status, $edit_id]);
    header('Location: feedback_control.php?action=updated');
    exit;
}

$sql = "SELECT * FROM feedback WHERE 1";
$params = [];


if ($f_id !== '') {
  $sql .= " AND f_id LIKE ?";
  $params[] = "%$f_id%";
}
if ($id !== '') {
  $sql .= " AND id LIKE ?";
  $params[] = "%$id%";
}
if ($status !== '' && $status !== 'All') {
  $sql .= " AND status = ?";
  $params[] = $status;
}

$sql .= " ORDER BY $sort_by $sort_order";

$pager = new pager($sql, $params, 5, $page);
?>

<?php require '_head.php'; ?>

<style>
.feedback-page {
    max-width: 1400px;
    margin: 40px auto;
    padding: 0 20px;
}

.feedback-page h1 {
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
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
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
    font-family: 'Inter', sans-serif;
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

.feedback-table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    margin-bottom: 24px;
}

.feedback-table th {
    background: #034c75;
    color: white;
    padding: 16px;
    text-align: left;
    font-weight: 600;
    font-size: 13px;
    letter-spacing: 1px;
}

.feedback-table td {
    padding: 14px 16px;
    border-bottom: 1px solid #e6eef3;
    color: #0b2c3d;
    font-size: 14px;
}

.feedback-table tbody tr:last-child td {
    border-bottom: none;
}

.feedback-table tbody tr:hover {
    background: #f8fbfc;
}

.status-badge {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
}

.status-pending {
    background: #fef3c7;
    color: #b45309;
}

.status-reviewed {
    background: #dbeafe;
    color: #1e40af;
}

.status-resolved {
    background: #dcfce7;
    color: #047857;
}

.status-form {
    display: flex;
    gap: 8px;
    align-items: center;
}

.status-form select {
    padding: 8px 12px;
    border: 1px solid #e6eef3;
    border-radius: 6px;
    font-size: 13px;
    font-family: 'Inter', sans-serif;
}

.status-form button {
    background: #0566a0;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.2s;
}

.status-form button:hover {
    background: #034c75;
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

.btn-delete {
    background: #ef4444;
    color: white;
}

.btn-delete:hover {
    background: #dc2626;
}

.message-cell {
    max-width: 300px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

@media(max-width: 1024px) {
    .filter-form {
        grid-template-columns: 1fr;
    }
    
    .feedback-table {
        font-size: 12px;
    }
}

@media(max-width: 768px) {
    .feedback-page {
        margin: 20px auto;
    }
    
    .feedback-table th,
    .feedback-table td {
        padding: 10px 8px;
        font-size: 12px;
    }
    
    .status-form {
        flex-direction: column;
    }
    
    .status-form select {
        width: 100%;
    }
}
</style>

<div class="feedback-page">
    <h1>Feedback Management</h1>

    <?php if (isset($_GET['action'])): ?>
        <div class="success-msg">
            <?php
            if ($_GET['action'] == 'updated') echo '✓ Feedback status updated successfully!';
            if ($_GET['action'] == 'deleted') echo '✓ Feedback deleted successfully!';
            ?>
        </div>
    <?php endif; ?>

    <div class="filter-section">
        <form method="get" class="filter-form">
            <input type="text" name="f_id" placeholder="Search feedback ID..." value="<?= htmlspecialchars($f_id) ?>">
            <input type="text" name="id" placeholder="Search member ID..." value="<?= htmlspecialchars($id) ?>">
            <select name="status">
                <option value="All" <?= $status == 'All' ? 'selected' : '' ?>>All Status</option>
                <option value="Pending" <?= $status == 'Pending' ? 'selected' : '' ?>>Pending</option>
                <option value="Reviewed" <?= $status == 'Reviewed' ? 'selected' : '' ?>>Reviewed</option>
                <option value="Resolved" <?= $status == 'Resolved' ? 'selected' : '' ?>>Resolved</option>
            </select>
            <button type="submit">Search</button>
        </form>

        <p class="record-count">📊 <?= $pager->item_count ?> record(s) found</p>

        <div class="sort-buttons">
            <a href="?<?= http_build_query(array_merge($_GET, ['sort_by' => 'f_id', 'sort_order' => $sort_order == 'ASC' ? 'DESC' : 'ASC', 'page' => 1])) ?>" class="sort-btn">↕ Feedback ID</a>
            <a href="?<?= http_build_query(array_merge($_GET, ['sort_by' => 'id', 'sort_order' => $sort_order == 'ASC' ? 'DESC' : 'ASC', 'page' => 1])) ?>" class="sort-btn">↕ Member ID</a>
        </div>
    </div>

    <table class="feedback-table">
        <thead>
            <tr>
                <th>FEEDBACK ID</th>
                <th>MEMBER ID</th>
                <th>MESSAGE</th>
                <th>DATE TIME</th>
                <th>STATUS</th>
                <th>ACTION</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pager->result as $s): ?>
            <tr>
                <td><?= htmlspecialchars($s->f_id) ?></td>
                <td><?= htmlspecialchars($s->id) ?></td>
                <td class="message-cell" title="<?= htmlspecialchars($s->message) ?>"><?= htmlspecialchars(substr($s->message, 0, 50)) ?><?= strlen($s->message) > 50 ? '...' : '' ?></td>
                <td><?= htmlspecialchars($s->created_at) ?></td>
                <td>
                    <form method="post" class="status-form">
                        <input type="hidden" name="edit_id" value="<?= htmlspecialchars($s->f_id) ?>">
                        <select name="new_status" onchange="this.form.submit()">
                            <option value="Pending" <?= $s->status == 'Pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="Reviewed" <?= $s->status == 'Reviewed' ? 'selected' : '' ?>>Reviewed</option>
                            <option value="Resolved" <?= $s->status == 'Resolved' ? 'selected' : '' ?>>Resolved</option>
                        </select>
                    </form>
                </td>
                <td>
                    <a href="feedback_control.php?<?= http_build_query(array_merge($_GET, ['delete_id' => $s->f_id])) ?>" 
                       class="action-btn btn-delete" 
                       onclick="return confirm('Are you sure you want to delete this feedback?')">Delete</a>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <?php
    $query = $_GET;
    unset($query['page'], $query['delete_id'], $query['action']);
    $href = http_build_query($query);
    $pager->html($href);
    ?>
</div>

<?php include '../footer.php'; ?>