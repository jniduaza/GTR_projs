<?php include 'auth.php'; include 'db.php'; ?>
<h2>Inventory</h2>
<?php if ($_SESSION['user']['role']!='staff'): ?>
<a href="add_item.php">Add Item</a>
<?php endif; ?>
<table>
<tr><th>Item</th><th>Qty</th><th>Unit</th><th>Action</th></tr>
<?php
$res = $conn->query("SELECT * FROM inventory");
while($r=$res->fetch_assoc()):
?>
<tr>
<td><?= $r['item_name'] ?></td>
<td><?= $r['quantity'] ?></td>
<td><?= $r['unit'] ?></td>
<td>
<?php if ($_SESSION['user']['role']!='staff'): ?>
<a href="update_stock.php?id=<?= $r['id'] ?>">Update</a>
<a href="delete_item.php?id=<?= $r['id'] ?>">Delete</a>
<?php endif; ?>
</td>
</tr>
<?php endwhile; ?>
</table>
<a href="dashboard.php">Back</a>
