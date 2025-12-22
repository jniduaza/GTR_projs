<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND password=?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user) {
        $_SESSION['user'] = $user;

        if ($user['role'] == 'owner') {
            header("Location: dashboard.php");
        } elseif ($user['role'] == 'manager') {
            header("Location: index.php");
        } else {
            header("Location: index.php");
        }
        exit;
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Restaurant Inventory Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<div class="login-container">
    <div class="login-card">
        <h2>GoodTaste Restaurant</h2>
        <p class="subtitle">Login to continue</p>

        <form method="POST">
            <div class="form-group">
                <input type="text" name="username" placeholder="Username" required>
            </div>

            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <button type="submit">Login</button>
        </form>

        <?php if (!empty($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
