<?php require '_head.php'; ?>

<style>
.staff-page {
    max-width: 1200px;
    margin: 40px auto;
    padding: 0 20px;
}

.staff-page h1 {
    text-align: center;
    margin-bottom: 12px;
    font-size: 32px;
    color: #0b2c3d;
    font-weight: 600;
}

.staff-page .subtext {
    text-align: center;
    color: #6b7280;
    margin-bottom: 30px;
    font-size: 15px;
}

.info-box {
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    border-left: 4px solid #0566a0;
    padding: 16px;
    border-radius: 8px;
    margin-bottom: 30px;
    color: #0b2c3d;
}

.info-box p {
    margin: 0;
    font-size: 14px;
}

.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 24px;
    margin-bottom: 40px;
}

.management-card {
    background: #fff;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
    border: 1px solid #e6eef3;
}

.management-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.12);
    border-color: #0566a0;
}

.card-icon {
    font-size: 48px;
    margin-bottom: 16px;
}

.card-title {
    font-size: 18px;
    font-weight: 600;
    color: #0b2c3d;
    margin: 0 0 8px 0;
}

.card-description {
    font-size: 14px;
    color: #6b7280;
    margin: 0;
}

.card-action {
    margin-top: 16px;
    padding-top: 16px;
    border-top: 1px solid #e6eef3;
    color: #0566a0;
    font-weight: 600;
    font-size: 13px;
    transition: 0.2s;
}

.management-card:hover .card-action {
    color: #034c75;
}

@media(max-width: 768px) {
    .staff-page {
        margin: 20px auto;
    }
    
    .dashboard-grid {
        grid-template-columns: 1fr;
        gap: 16px;
    }
    
    .staff-page h1 {
        font-size: 24px;
    }
}
</style>

<div class="staff-page">
    <h1>Admin Dashboard</h1>
    <p class="subtext">Efficiently manage products, orders, and user accounts from a centralized platform.</p>

    <div class="info-box">
        <p><strong>💡 Tip:</strong> Use the sections below to maintain an organized and up-to-date store.</p>
    </div>

    <div class="dashboard-grid">
        <a href="order.php" class="management-card">
            <div class="card-icon">🧾</div>
            <h3 class="card-title">Order Management</h3>
            <p class="card-description">Review, update, or remove customer orders.</p>
            <div class="card-action">Manage Orders →</div>
        </a>

        <a href="product.php" class="management-card">
            <div class="card-icon">📦</div>
            <h3 class="card-title">Product Management</h3>
            <p class="card-description">Add, edit, or adjust product listings and inventory.</p>
            <div class="card-action">Manage Products →</div>
        </a>

        <a href="user.php" class="management-card">
            <div class="card-icon">👤</div>
            <h3 class="card-title">User Management</h3>
            <p class="card-description">Manage admin and customer profiles securely.</p>
            <div class="card-action">Manage Users →</div>
        </a>

        <a href="feedback_control.php" class="management-card">
            <div class="card-icon">💬</div>
            <h3 class="card-title">Feedback Maintenance</h3>
            <p class="card-description">Review and manage customer feedback and comments.</p>
            <div class="card-action">View Feedback →</div>
        </a>
    </div>
</div>

<?php include '../footer.php'; ?>