<?php include 'auth.php'; requireRole(['owner','manager']); include 'db.php';
$conn->query("DELETE FROM inventory WHERE id=".$_GET['id']);
header("Location:index.php");
