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
<html>

<head>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h2>Restaurant Inventory Login</h2>
    <form method="POST">
        <input name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button>Login</button>
    </form>
    <?= $error ?? '' ?>
</body>

</html>