<?php
require "base.php";
include "head2.php";

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user']->id;

$error = null;
$success = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $userId; 
    $message = trim($_POST['message'] ?? '');
    $rating = $_POST['rating'] ?? '';

    if ($message !== '' && $rating !== '') {
        $stm = $_db->prepare(
            'INSERT INTO feedback (id, message, rating, status)
             VALUES (?, ?, ?, ?)'
        );
        $stm->execute([$id, $message, $rating, 'Pending']);
        $success = 'Feedback submitted successfully.';
    } else {
        $error = 'All fields are required.';
    }
}

?>
    <style>
        /* ===== Global Reset ===== */
        * {
            box-sizing: border-box;
            font-family: 'Inter', 'Segoe UI', sans-serif;
        }
        body {
            margin: 0;
            background: #f1f5f9;
            color: #0f172a;
        }

        /* ===== Page Header ===== */
        .fxfb-topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 26px 64px;
            background: linear-gradient(90deg, #0f172a, #1e293b);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        .fxfb-topbar h1 {
            font-size: 32px;
            font-weight: 600;
            color: #f8fafc;
            letter-spacing: 1.2px;
        }
        .fxfb-backlink {
            text-decoration: none;
            color: #0f172a;
            background: #f8fafc;
            padding: 10px 26px;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .fxfb-backlink:hover {
            background: #e2e8f0;
        }

        /* ===== Main Container ===== */
        .fxfb-wrapper {
            max-width: 980px;
            margin: 70px auto;
            padding: 0 32px;
        }
        .fxfb-panel {
            background: #ffffff;
            border-radius: 22px;
            padding: 50px 56px;
            box-shadow: 0 30px 80px rgba(15,23,42,0.12);
            border: 1px solid #e2e8f0;
        }
        .fxfb-panel h2 {
            font-size: 30px;
            font-weight: 600;
            margin-bottom: 36px;
            color: #0f172a;
            letter-spacing: 0.6px;
        }

        /* ===== Status Messages ===== */
        .fxfb-alert-error {
            background: #fee2e2;
            color: #7f1d1d;
            padding: 14px 20px;
            border-radius: 10px;
            margin-bottom: 24px;
            font-weight: 500;
            border: 1px solid #fecaca;
        }
        .fxfb-alert-success {
            background: #dcfce7;
            color: #14532d;
            padding: 14px 20px;
            border-radius: 10px;
            margin-bottom: 24px;
            font-weight: 500;
            border: 1px solid #bbf7d0;
        }

        /* ===== Form Layout ===== */
        .fxfb-form {
            display: grid;
            grid-template-columns: 1fr;
            gap: 28px;
        }
        .fxfb-field {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .fxfb-field label {
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 1px;
            color: #334155;
        }
        .fxfb-input,
        .fxfb-select,
        .fxfb-textarea {
            width: 100%;
            padding: 14px 16px;
            border-radius: 12px;
            border: 1px solid #cbd5f5;
            font-size: 15px;
            transition: all 0.25s ease;
            background: #f8fafc;
            color: #0f172a;
        }
        .fxfb-textarea {
            min-height: 160px;
            resize: vertical;
            line-height: 1.7;
        }
        .fxfb-input:focus,
        .fxfb-select:focus,
        .fxfb-textarea:focus {
            outline: none;
            border-color: #1e3a8a;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(30,58,138,0.15);
        }

        /* ===== Action Area ===== */
        .fxfb-actions {
            display: flex;
            justify-content: flex-end;
            gap: 16px;
            margin-top: 20px;
        }

        .fxfb-submit {
            background: #1e3a8a;
            color: #ffffff;
            border: none;
            padding: 14px 44px;
            font-size: 15px;
            font-weight: 600;
            border-radius: 14px;
            cursor: pointer;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }
        .fxfb-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 40px rgba(15,23,42,0.25);
        }

        .fxfb-cancel {
            display: inline-block;
            text-decoration: none;
            padding: 14px 44px;
            border-radius: 14px;
            font-size: 15px;
            font-weight: 600;
            letter-spacing: 1px;
            color: #1e293b;
            background: #e5e7eb;
            border: 1px solid #cbd5e1;
            transition: all 0.3s ease;
        }

        .fxfb-cancel:hover {
            background: #cbd5e1;
            color: #0f172a;
        }

        /* ===== Responsive ===== */
        @media (max-width: 768px) {
            .fxfb-topbar {
                flex-direction: column;
                gap: 14px;
                padding: 28px;
            }
            .fxfb-panel {
                padding: 36px 26px;
            }
        }
    </style>
</head>

<link rel="stylesheet" href="css/aboutUs.css">

<body>
<main class="fxfb-wrapper">
    <section class="fxfb-panel">
        <h2>Submit Your Feedback</h2>

        <?php if ($error): ?>
            <div class="fxfb-alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="fxfb-alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="post" class="fxfb-form">
            <div class="fxfb-field">
                <label for="message">FEEDBACK MESSAGE</label>
                <textarea
                    id="message"
                    name="message"
                    class="fxfb-textarea"
                    placeholder="Write your feedback clearly and professionally"
                    required
                ></textarea>
            </div>

            <div class="fxfb-field">
                <label for="rating">RATING</label>
                <select id="rating" name="rating" class="fxfb-select" required>
                    <option value="">Select rating</option>
                    <option value="5">★★★★★ – Excellent</option>
                    <option value="4">★★★★☆ – Very Good</option>
                    <option value="3">★★★☆☆ – Average</option>
                    <option value="2">★★☆☆☆ – Poor</option>
                    <option value="1">★☆☆☆☆ – Very Poor</option>
                </select>
            </div>

            <div class="fxfb-actions">
                <a href="feedback_view.php" class="fxfb-cancel">CANCEL</a>
                <button type="submit" class="fxfb-submit">SUBMIT</button>
            </div>
        </form>
    </section>
</main>

</body>
</html>
<?php include 'footer.php'; ?>