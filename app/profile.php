<?php
require 'base.php';
require 'head2.php';

$_title = 'User | Profile';

auth();
if (is_get()) {
    $stm = $_db->prepare('SELECT * FROM user WHERE id = ?');
    $stm->execute([$_user->id]);
    $u = $stm->fetch();

    if (!$u) {
        redirect('main.php');
    }

    extract((array)$u);
    $_SESSION['photo'] = $u->photo;
}

if (is_post()) {
    $email = req('email');
    $name  = req('name');
    $photo = $_SESSION['photo'];
    $f = get_file('photo');

    // Validate: email
    if ($email == '') {
        $_err['email'] = 'Required';
    }
    else if (strlen($email) > 100) {
        $_err['email'] = 'Maximum 100 characters';
    }
    else if (!is_email($email)) {
        $_err['email'] = 'Invalid email';
    }
    else {
        $stm = $_db->prepare('
            SELECT COUNT(*) FROM user
            WHERE email = ? AND id != ?
        ');
        $stm->execute([$email, $_user->id]);

        if ($stm->fetchColumn() > 0) {
            $_err['email'] = 'Duplicated';
        }
    }

    // Validate: name
    if ($name == '') {
        $_err['name'] = 'Required';
    }
    else if (strlen($name) > 100) {
        $_err['name'] = 'Maximum 100 characters';
    }

    // Validate: photo (file) --> optional
    if ($f) {
        if (!str_starts_with($f->type, 'image/')) {
            $_err['photo'] = 'Must be image';
        }
        else if ($f->size > 1 * 1024 * 1024) {
            $_err['photo'] = 'Maximum 1MB';
        }
    }

    // DB operation
    if (!$_err) {

        // (1) Delete and save photo --> optional
        if ($f) {
            unlink("images_user/$photo");
            $photo = save_photo($f, 'images_user');
        }
        
        // (2) Update user (email, name, photo)
        $stm = $_db->prepare('
            UPDATE user
            SET email = ?, name = ?, photo = ?
            WHERE id = ?
        ');
        $stm->execute([$email, $name, $photo, $_user->id]);

        // (3) Update global user object
        $_user->email = $email;
        $_user->name = $name;
        $_user->photo = $photo;

        temp('info', 'Record updated');
        redirect('profile.php');
    }
}
?>

<div class="profile-page">
    <h2 class="section-title">My Profile</h2>

    <form class="profile-form" method="post" enctype="multipart/form-data">
        <div class="form-card">
            <div class="form-field">
                <label for="email">Email</label>
                <?= html_text('email', 'type="email"') ?>
                <div class="err"><?= err('email') ?></div>
            </div>

            <div class="form-field">
                <label for="name">Name</label>
                <?= html_text('name') ?>
                <div class="err"><?= err('name') ?></div>
            </div>

            <div class="form-field photo-field">
                <label for="photo">Profile Photo</label>
                <label class="upload-photo">
                    <?= html_file('photo', 'image/*', 'hidden') ?>
                    <img src="images_user/<?= $photo ?>" alt="Profile photo">
                </label>
                <span class="upload-hint">Click photo to change</span>
                <div class="err"><?= err('photo') ?></div>
            </div>

            <div class="form-buttons">
                <button type="submit">Save</button>
                <button type="reset" class="cancel-btn">Cancel</button>
            </div>
        </div>
    </form>
</div>

<style>
    body {
        margin: 0;
        font-family: 'Inter', sans-serif;
        background: #f6f8fa;
        color: #0b2c3d;
    }

    .profile-page {
        max-width: 800px;
        margin: 50px auto;
        padding: 0 20px;
    }

    .section-title {
        text-align: center;
        font-size: 36px;
        font-weight: 300;
        color: #0b2c3d;
        margin-bottom: 40px;
        letter-spacing: 2px;
    }

    .section-title::after {
        content: '';
        display: block;
        width: 80px;
        height: 3px;
        background: #1e40af;
        margin: 15px auto 0;
        border-radius: 2px;
    }

    /* Form card */
    .form-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.06);
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    /* Form fields */
    .form-field {
        display: flex;
        flex-direction: column;
    }

    .form-field label {
        font-weight: 500;
        margin-bottom: 8px;
        color: #0b2c3d;
    }

    .form-field input[type="text"],
    .form-field input[type="email"],
    .form-field input[type="file"] {
        padding: 10px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        font-size: 14px;
        transition: border-color 0.3s, box-shadow 0.3s;
    }

    .form-field input:focus {
        border-color: #1e40af;
        box-shadow: 0 0 0 3px rgba(30,64,175,0.15);
        outline: none;
    }

    /* Photo upload */
    .photo-field {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }

    .upload-photo img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        cursor: pointer;
        border: 2px solid #1e40af;
        transition: transform 0.3s, border-color 0.3s;
    }

    .upload-photo img:hover {
        transform: scale(1.05);
        border-color: #2563eb;
    }

    .upload-hint {
        font-size: 12px;
        color: #64748b;
    }

    /* Buttons */
    .form-buttons {
        display: flex;
        justify-content: center;
        gap: 12px;
    }

    .form-buttons button {
        padding: 12px 24px;
        border: none;
        border-radius: 10px;
        background-color: #1e3a8a;
        color: #ffffff;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.2s;
    }

    .form-buttons button:hover {
        background-color: #1e40af;
        transform: translateY(-2px);
    }

    .form-buttons .cancel-btn {
        background-color: #cbd5e1;
        color: #334155;
    }

    .form-buttons .cancel-btn:hover {
        background-color: #94a3b8;
    }

    /* Errors */
    .err {
        font-size: 12px;
        color: #dc2626;
        margin-top: 4px;
    }

    /* Responsive */
    @media(max-width: 600px) {
        .form-card {
            padding: 20px;
        }

        .form-buttons {
            flex-direction: column;
            align-items: center;
        }

        .form-buttons button {
            width: 100%;
        }
    }
</style>

<?php include 'footer.php'; ?>