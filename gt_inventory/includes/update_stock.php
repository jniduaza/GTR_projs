<?php include 'auth.php'; requireRole(['owner','manager']); include 'db.php';
$id=$_GET['id'];
if($_POST){
$conn->query("UPDATE inventory SET quantity=".$_POST['qty']." WHERE id=$id");
header("Location:index.php");
}
$r=$conn->query("SELECT * FROM inventory WHERE id=$id")->fetch_assoc();
?>
<form method="POST">
<input type="number" name="qty" value="<?= $r['quantity'] ?>">
<button>Update</button>
</form>
