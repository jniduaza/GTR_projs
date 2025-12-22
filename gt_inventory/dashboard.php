<?php include 'includes/auth.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<!-- TOP BAR -->
<header class="topbar">
    <div class="logo">🍽 Restaurant Inventory</div>
    <div class="profile">
        <span class="username"><?= $_SESSION['user']['username'] ?></span>
        <span class="role">(<?= $_SESSION['user']['role'] ?>)</span>
        <a href="logout.php" class="logout-link">Logout</a>
    </div>
</header>

<!-- SIDEBAR -->
<aside class="sidebar">
    <a href="dashboard.php" class="active">🏠 Dashboard</a>
    <a href="index.php">📦 Inventory</a>

    <?php if ($_SESSION['user']['role'] == 'owner'): ?>
        <a href="users.php">👥 User Management</a>
    <?php endif; ?>

    <a href="#">📊 Reports</a>
</aside>

<!-- MAIN CONTENT -->
<main class="content">
    <h1>Dashboard</h1>

    <div class="cards">
        <div class="info-card">
            <h3>Inventory</h3>
            <p>Manage restaurant stock and supplies</p>
            <a href="index.php">Go to Inventory →</a>
        </div>

        <?php if ($_SESSION['user']['role'] == 'owner'): ?>
        <div class="info-card">
            <h3>User Management</h3>
            <p>Control system users and roles</p>
            <a href="users.php">Manage Users →</a>
        </div>
        <?php endif; ?>

        <div class="info-card">
            <h3>Reports</h3>
            <p>Sales and inventory analytics</p>
        </div>
    </div>
</main>

</body>
</html>
