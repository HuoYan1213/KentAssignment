<?php
require 'base.php';
require 'head2.php';
require '_pager.php';

$id = $_GET['id'] ?? '';
$role = $_GET['role'] ?? '';
$searchName = $_GET['name'] ?? '';
$page = $_GET['page'] ?? 1;
$sort_by = $_GET['sort_by'] ?? 'name';
$sort_order = $_GET['sort_order'] ?? 'ASC';

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $_db->prepare('DELETE FROM user WHERE id = ?')->execute([$delete_id]);
    header('Location: user.php?action=deleted');
    exit;
}

$sql = 'SELECT * FROM user WHERE 1';
$params = [];

if ($role) {
    $sql = 'SELECT * FROM user WHERE 1';
    $params = [];

    if ($role && $role != 'All') {
        $sql .= ' AND role = ?';
        $params[] = $role;
    }

    if ($id !== '') {
        $sql .= ' AND id = ?';
        $params[] = $id;
    }

    if ($searchName) {
        $sql .= ' AND name LIKE ?';
        $params[] = "%$searchName%";
    }

    $sql .= " ORDER BY $sort_by $sort_order";

    $pager = new pager($sql, $params, 5, $page);
    
}
?>

<style>
.user-page {
    max-width: 1400px;
    margin: 40px auto;
    padding: 0 20px;
}

.user-page h1 {
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

.role-selector {
    display: flex;
    gap: 12px;
    margin-bottom: 24px;
    justify-content: center;
    flex-wrap: wrap;
}

.role-btn {
    padding: 10px 24px;
    border: 2px solid #e5e7eb;
    background: #fff;
    color: #6b7280;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    font-size: 14px;
    text-decoration: none;
    transition: 0.2s;
}

.role-btn:hover {
    border-color: #0566a0;
    color: #0566a0;
}

.role-btn.active {
    background: #0566a0;
    color: white;
    border-color: #0566a0;
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

.filter-form input {
    padding: 10px 14px;
    border: 1px solid #e6eef3;
    border-radius: 8px;
    font-size: 14px;
}

.filter-form input:focus {
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

.user-table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    margin-bottom: 24px;
}

.user-table th {
    background: #034c75;
    color: white;
    padding: 16px;
    text-align: left;
    font-weight: 600;
    font-size: 13px;
    letter-spacing: 1px;
}

.user-table td {
    padding: 14px 16px;
    border-bottom: 1px solid #e6eef3;
    color: #0b2c3d;
    font-size: 14px;
}

.user-table tbody tr:last-child td {
    border-bottom: none;
}

.user-table tbody tr:hover {
    background: #f8fbfc;
}

.user-photo {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 6px;
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

.no-role-msg {
    background: #f3f4f6;
    padding: 40px;
    text-align: center;
    border-radius: 8px;
    color: #6b7280;
    font-size: 16px;
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
    
    .user-table {
        font-size: 12px;
    }
}

@media(max-width: 768px) {
    .user-page {
        margin: 20px auto;
    }
    
    .user-table th,
    .user-table td {
        padding: 10px 8px;
        font-size: 12px;
    }
}
</style>

<div class="user-page">
    <h1>User Management</h1>

    <?php if (isset($_GET['action'])): ?>
      <div class="success-msg">
        <?php
        if ($_GET['action'] == 'added') echo '✓ User added successfully!';
        if ($_GET['action'] == 'edited') echo '✓ User updated successfully!';
        if ($_GET['action'] == 'deleted') echo '✓ User deleted successfully!';
        ?>
      </div>
    <?php endif; ?>

    <div class="role-selector">
        <a href="user.php?role=admin" class="role-btn <?= $role == 'admin' ? 'active' : '' ?>">👤 Admin</a>
        <a href="user.php?role=member" class="role-btn <?= $role == 'member' ? 'active' : '' ?>">👥 Member</a>
    </div>

    <?php if ($role): ?>
    <div class="filter-section">
        <form method="get" class="filter-form">
            <input type="hidden" name="role" value="<?= htmlspecialchars($role) ?>">
            <input type="text" name="id" placeholder="Search user ID..." value="<?= htmlspecialchars($id) ?>">
            <input type="text" name="name" placeholder="Search by name..." value="<?= htmlspecialchars($searchName) ?>">
            <button type="submit">Search</button>
        </form>

        <p class="record-count">📊 <?= $pager->item_count ?> record(s) found</p>

        <div class="sort-buttons">
            <a href="?<?= http_build_query(array_merge($_GET, ['sort_by' => 'id', 'sort_order' => $sort_order == 'ASC' ? 'DESC' : 'ASC', 'page' => 1])) ?>" class="sort-btn">↕ ID</a>
            <a href="?<?= http_build_query(array_merge($_GET, ['sort_by' => 'name', 'sort_order' => $sort_order == 'ASC' ? 'DESC' : 'ASC', 'page' => 1])) ?>" class="sort-btn">↕ Name</a>
            <a href="?<?= http_build_query(array_merge($_GET, ['sort_by' => 'email', 'sort_order' => $sort_order == 'ASC' ? 'DESC' : 'ASC', 'page' => 1])) ?>" class="sort-btn">↕ Email</a>
        </div>
    </div>

    <table class="user-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>EMAIL</th>
                <th>ROLE</th>
                <th>PHOTO</th>
                <th>ACTION</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pager->result as $s): ?>
            <tr>
                <td><?= htmlspecialchars($s->id) ?></td>
                <td><?= htmlspecialchars($s->name) ?></td>
                <td><?= htmlspecialchars($s->email) ?></td>
                <td><span style="background: <?= $s->role == 'admin' ? '#fef3c7' : '#dbeafe' ?>; color: <?= $s->role == 'admin' ? '#b45309' : '#1e40af' ?>; padding: 4px 12px; border-radius: 6px; font-size: 12px; font-weight: 600;"><?= htmlspecialchars($s->role) ?></span></td>
                <td><img src="images_user/<?= htmlspecialchars($s->photo) ?>" class="user-photo" alt="<?= htmlspecialchars($s->name) ?>"></td>
                <td>
                    <a href="user_edit.php?edit_id=<?= urlencode($s->id) ?>" class="action-btn btn-edit">Edit</a> 
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

    <?php else: ?>
    <div class="no-role-msg">
        <p>👆 Please select a role filter (Admin or Member) to view users</p>
    </div>
    <?php endif; ?>

    <a href="user_edit.php" class="add-button">+ Add New User</a>
</div>

<?php include 'footer.php'; ?>