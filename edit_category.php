<?php

declare(strict_types=1);

require_once '../config.php';
require_once '../category_validation.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit();
}

$user_id = (int) $_SESSION['user_id'];
$errors  = [];

/* Get the category (only if it belongs to this user and is not deleted) */

$id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);

$stmt = $conn->prepare("
    SELECT category_id, category_name, monthly_limit
    FROM categories
    WHERE category_id = ?
    AND user_id = ?
    AND is_deleted = 0
");
$stmt->execute([$id, $user_id]);
$category = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$category) {
    header("Location: index.php");
    exit();
}

/* Save changes */

if (isset($_POST['update'])) {

    $name  = trim($_POST['name'] ?? '');
    $limit = (float) ($_POST['monthly_limit'] ?? 0);

    $errors = validateCategory($name, $limit);

    if (empty($errors)) {

        $update = $conn->prepare("
            UPDATE categories
            SET category_name = ?, monthly_limit = ?
            WHERE category_id = ?
            AND user_id = ?
        ");
        $update->execute([$name, $limit, $id, $user_id]);

        header("Location: index.php");
        exit();
    }

    // Keep what the user typed so the form is not reset
    $category['category_name'] = $name;
    $category['monthly_limit'] = $limit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <link rel="icon" type="image/x-icon" href="../logo/logo.png">
    <link rel="stylesheet" href="../style.css">
    <style>
        .container{ padding:20px; }
        .form-box{ background:#1e293b; padding:20px; border-radius:10px; max-width:500px; }
        .form-box form{ display:flex; flex-direction:column; gap:12px; }
        .form-box input{ padding:12px; border:none; border-radius:8px; }
        .form-box button, .form-box a{
            padding:12px 20px; border:none; border-radius:8px; color:white;
            cursor:pointer; text-decoration:none; text-align:center;
        }
        .save-btn{ background:#3b82f6; }
        .cancel-btn{ background:#64748b; }
        .error{ color:#ef4444; }
    </style>
</head>
<body>
<div class="wrapper">

    <div class="sidebar">
        <a href="../dashboard.php">Dashboard</a>
        <a href="../expense_module/view_expense.php">Expenses</a>
        <a href="../transaction_module/view_transaction.php">Transactions</a>
        <a href="../report/report.php">Reports</a>
        <a href="index.php">Category</a>
        <a href="../profile/show_profile.php">Profile</a>
        <a href="../login/logout.php">Logout</a>
    </div>

    <div class="main">
        <div class="container">

            <h1>Edit Category</h1>

            <div class="form-box">

                <?php foreach ($errors as $error): ?>
                    <p class="error"><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>

                <form method="POST">

                    <input type="hidden" name="id"
                           value="<?= (int) $category['category_id'] ?>">

                    <input type="text" name="name" required
                           value="<?= htmlspecialchars((string) $category['category_name']) ?>">

                    <input type="number" step="0.01" name="monthly_limit" required
                           value="<?= htmlspecialchars((string) $category['monthly_limit']) ?>">

                    <button type="submit" name="update" class="save-btn">Save Changes</button>
                    <a href="index.php" class="cancel-btn">Cancel</a>

                </form>

            </div>
        </div>
    </div>
</div>
</body>
</html>
