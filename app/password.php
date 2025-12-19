<?php
require 'base.php';

$_title = 'User | Password';

// Authenticated users
auth();
if (is_post()) {
    $password     = req('password');
    $new_password = req('new_password');
    $confirm      = req('confirm');

    // Validate: password
    if ($password == '') {
        $_err['password'] = 'Required';
    }
    else if (strlen($password) < 5 || strlen($password) > 100) {
        $_err['password'] = 'Between 5-100 characters';
    }
    else {
        $stm = $_db->prepare('
            SELECT COUNT(*) FROM user
            WHERE password = SHA1(?) AND id =?
        ');
        $stm->execute([$password, $_user->id]);
        
        if ($stm->fetchColumn() == 0) {
            $_err['password'] = 'Not matched';
        }
    }

    // Validate: new_password
    if ($new_password == '') {
        $_err['new_password'] = 'Required';
    }
    else if (strlen($new_password) < 5 || strlen($new_password) > 100) {
        $_err['new_password'] = 'Between 5-100 characters';
    }

    // Validate: confirm
    if (!$confirm) {
        $_err['confirm'] = 'Required';
    }
    else if (strlen($confirm) < 5 || strlen($confirm) > 100) {
        $_err['confirm'] = 'Between 5-100 characters';
    }
    else if ($confirm != $new_password) {
        $_err['confirm'] = 'Not matched';
    }

    // DB operation
    if (!$_err) {

        // Update user (password)
        $stm = $_db->prepare('
            UPDATE user
            SET password = SHA1(?)
            WHERE id = ?
        ');
        $stm->execute([$new_password, $_user->id]);

        temp('info', 'Record updated');
        redirect('main.php');
    }
}
require 'head2.php';
?>

<div class="password-page">
    <h2 class="section-title">Change Password</h2>

    <div class="password-grid">
        <div class="password-card">
            <form method="post">
                <div class="form-field">
                    <label for="password">Current Password</label>
                    <?= html_password('password', 'maxlength="100" required') ?>
                    <span class="toggle-password" onclick="togglePassword('password')">Show</span>
                    <div class="err"><?= err('password') ?></div>
                </div>

                <div class="form-field">
                    <label for="new_password">New Password</label>
                    <?= html_password('new_password', 'maxlength="100" required onkeyup="checkPasswordStrength(this.value)"') ?>
                    <span class="toggle-password" onclick="togglePassword('new_password')">Show</span>
                    <div class="password-strength">
                        <div id="strength-meter"></div>
                    </div>
                    <div class="password-requirements">
                        Must be at least 8 characters with uppercase, lowercase, numbers, and symbols
                    </div>
                    <div class="err"><?= err('new_password') ?></div>
                </div>

                <div class="form-field">
                    <label for="confirm">Confirm New Password</label>
                    <?= html_password('confirm', 'maxlength="100" required') ?>
                    <span class="toggle-password" onclick="togglePassword('confirm')">Show</span>
                    <div class="err"><?= err('confirm') ?></div>
                </div>

                <div class="buttons">
                    <button type="submit" class="btn-update">Update Password</button>
                    <button type="reset" class="btn-cancel">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* ================= BLUEWAVE PASSWORD PAGE (Order History 风格) ================= */

body {
    margin: 0;
    font-family: 'Inter', sans-serif;
    background: #f6f8fa;
    color: #0b2c3d;
}

.password-page {
    max-width: 1000px;
    margin: 50px auto;
    padding: 0 30px;
}

.section-title {
    text-align: center;
    font-size: 36px;
    font-weight: 500;
    color: #0b2c3d;
    margin-bottom: 50px;
    letter-spacing: 1px;
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

.password-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 30px;
}

.password-card {
    background: #ffffff;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.06);
    display: flex;
    flex-direction: column;
    transition: transform 0.3s, box-shadow 0.3s;
}

.password-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 40px rgba(0,0,0,0.08);
}

.form-field {
    position: relative;
    margin-bottom: 25px;
}

.form-field label {
    display: block;
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 8px;
    color: #1e3a8a;
}

.form-field input {
    max-width: 1000px; 
    width: 100%;
    padding: 12px 14px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    font-size: 14px;
    box-sizing: border-box;
}

.form-field input:focus {
    border-color: #1e40af;
    outline: none;
    box-shadow: 0 0 10px rgba(30,64,175,0.1);
}

.toggle-password {
    margin-left: 10px;
    cursor: pointer;
    color: #1e40af; 
    font-weight: 500;
    font-size: 13px;
    user-select: none;
    transition: color 0.3s;
}

.toggle-password:hover {
    color: #2563eb;  
}

.password-strength {
    height: 6px;
    background: #e2e8f0;
    border-radius: 4px;
    margin-top: 6px;
    overflow: hidden;
}

#strength-meter {
    height: 100%;
    width: 0%;
    border-radius: 4px;
    transition: 0.3s;
}

#strength-meter.strength-weak {
    background: #f87171;
}

#strength-meter.strength-medium {
    background: #fbbf24;
}

#strength-meter.strength-strong {
    background: #34d399;
}

.password-requirements {
    font-size: 12px;
    color: #64748b;
    margin-top: 4px;
}

.err {
    font-size: 12px;
    color: #dc2626;
    margin-top: 4px;
}

.buttons {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 20px;
}

.btn-update {
    padding: 10px 20px;
    background-color: #1e3a8a;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-weight: 500;
    transition: 0.3s;
}

.btn-update:hover {
    background-color: #1e40af;
}

.btn-cancel {
    padding: 10px 20px;
    background-color: #e5e7eb;
    color: #475569;
    border: none;
    border-radius: 8px;
    transition: 0.3s;
}

.btn-cancel:hover {
    background-color: #cbd5e1;
}

@media(max-width: 768px) {
    .password-page {
        padding: 0 20px;
    }
}
</style>


<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const button = field.nextElementSibling;
        
        if (field.type === "password") {
            field.type = "text";
            button.textContent = "Hide";
        } else {
            field.type = "password";
            button.textContent = "Show";
        }
    }

    function checkPasswordStrength(password) {
        const meter = document.getElementById('strength-meter');
        
        // Remove existing classes
        meter.className = '';
        
        if (!password) {
            meter.style.width = '0%';
            return;
        }
        
        // Simple strength calculation
        let strength = 0;
        if (password.length >= 8) strength += 25;
        if (password.match(/[A-Z]/)) strength += 25;
        if (password.match(/[0-9]/)) strength += 25;
        if (password.match(/[^A-Za-z0-9]/)) strength += 25;
        
        meter.style.width = strength + '%';
        
        if (strength < 50) {
            meter.classList.add('strength-weak');
        } else if (strength < 75) {
            meter.classList.add('strength-medium');
        } else {
            meter.classList.add('strength-strong');
        }
    }
</script>

<?php include 'footer.php'; ?>