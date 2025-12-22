<?php include 'auth.php';
requireRole(['owner', 'manager']);
include 'db.php';
if ($_POST) {
    $stmt = $conn->prepare("INSERT INTO inventory(item_name,quantity,unit)VALUES(?,?,?)");
    $stmt->bind_param("sis", $_POST['name'], $_POST['qty'], $_POST['unit']);
    $stmt->execute();
    header("Location:index.php");
}
?>
<form method="POST">
    <input name="name" placeholder="Item">
    <input type="number" name="qty">
    <input name="unit">
    <button>Add</button>
</form>