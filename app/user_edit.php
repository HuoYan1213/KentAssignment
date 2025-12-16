<?php
require 'base.php';
require 'head2.php';

$edit_id = $_GET['edit_id'] ?? null;
$user = null;
$_err = [];

if ($edit_id) {
    $stm = $_db->prepare('SELECT * FROM user WHERE id = ?');
    $stm->execute([$edit_id]);
    $user = $stm->fetch();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = $_POST['password'];

    if (!$edit_id || $password !== '') {
        if ($password == '') {
            $_err['password'] = 'Required';
        } else if (strlen($password) < 5 || strlen($password) > 100) {
            $_err['password'] = 'Between 5-100 characters';
        }
    }

    $check = $_db->prepare("SELECT COUNT(*) FROM user WHERE email = ? AND id != ?");
    $check->execute([$email, $edit_id ?? 0]);
    if ($check->fetchColumn() > 0) {
        die("This email is already registered by another user.");
    }
  
    $photo = $user ? $user->photo : 'default.jpg';
    if (!empty($_FILES['photo']['name'])) {
        $photo = $_FILES['photo']['name'];
        $upload_dir = 'images_user/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        move_uploaded_file($_FILES['photo']['tmp_name'], $upload_dir . $photo);
    }

    if (empty($_err)) {
        if ($edit_id) {
            if ($password !== '') {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $_db->prepare('UPDATE user SET name = ?, email = ?, role = ?, photo = ?, password = ? WHERE id = ?')
                    ->execute([$name, $email, $role, $photo, $hashed_password, $edit_id]);
            } else {
                $_db->prepare('UPDATE user SET name = ?, email = ?, role = ?, photo = ? WHERE id = ?')
                    ->execute([$name, $email, $role, $photo, $edit_id]);
            }
            header('Location: user.php?action=edited');
            exit;
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $_db->prepare('INSERT INTO user (name, email, role, photo, password) VALUES (?, ?, ?, ?, ?)')
                 ->execute([$name, $email, $role, $photo, $hashed_password]);
            header('Location: user.php?action=added');
            exit;
        }
    }
}
?>

<style>
.user-edit-page {
    max-width: 700px;
    margin: 40px auto;
    padding: 0 20px;
}

.user-edit-page h1 {
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
.form-group select {
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
.form-group select:focus {
    outline: none;
    border-color: #0566a0;
    box-shadow: 0 0 0 3px rgba(5, 102, 160, 0.1);
}

.form-hint {
    color: #6b7280;
    font-size: 12px;
    margin-top: 4px;
}

.form-error {
    color: #dc2626;
    font-size: 13px;
    margin-top: 4px;
    font-weight: 500;
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
    .user-edit-page {
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

<div class="user-edit-page">
    <h1><?= $edit_id ? 'Edit User' : 'Add New User' ?></h1>

    <div class="form-card">
        <?php if ($edit_id): ?>
            <div class="info-group">
                <div class="label">User ID</div>
                <div class="value"><?= htmlspecialchars($edit_id) ?></div>
            </div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Name *</label>
                <input type="text" id="name" name="name" value="<?= $user ? htmlspecialchars($user->name) : '' ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Password *</label>
                <input type="password" id="password" name="password" value="">
                <?php if ($edit_id): ?>
                    <div class="form-hint">Leave blank to keep current password</div>
                <?php endif; ?>
                <?php if (!empty($_err['password'])): ?>
                    <div class="form-error">✕ <?= htmlspecialchars($_err['password']) ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? ($user->email ?? '')) ?>" required>
                <?php if (!empty($_err['email'])): ?>
                    <div class="form-error">✕ <?= htmlspecialchars($_err['email']) ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="role">Role *</label>
                <select id="role" name="role" required>
                    <option value="admin" <?= $user && $user->role == 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="member" <?= $user && $user->role == 'member' ? 'selected' : '' ?>>Member</option>
                </select>
            </div>

            <div class="form-group">
                <label for="photo">Profile Photo</label>
                <input type="file" id="photo" name="photo" accept="image/*">
                <?php if ($user && !empty($user->photo)): ?>
                    <div class="photo-preview">
                        <img src="images_user/<?= htmlspecialchars($user->photo) ?>" alt="<?= htmlspecialchars($user->name) ?>">
                        <p style="color: #6b7280; font-size: 12px; margin-top: 8px;">Current photo</p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="button-group">
                <button type="submit" class="btn-submit"><?= $edit_id ? '✓ Update User' : '✓ Add User' ?></button>
                <a href="user.php" class="btn-cancel">✕ Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>