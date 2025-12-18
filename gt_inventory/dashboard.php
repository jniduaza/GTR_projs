<?php include 'auth.php'; ?>
<h2>Dashboard</h2>
<p>Welcome <?= $_SESSION['user']['username'] ?> (<?= $_SESSION['user']['role'] ?>)</p>
<a href="index.php">Inventory</a><br>
<?php if ($_SESSION['user']['role']=='owner'): ?>
<a href="users.php">User Management</a><br>
<?php endif; ?>
<a href="logout.php">Logout</a>
