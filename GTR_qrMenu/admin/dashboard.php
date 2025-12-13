<?php include '../config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>

<h1>Admin Dashboard</h1>
<a href="add_item.php">➕ Add New Item</a>

<table>
<tr>
    <th>Name</th>
    <th>Price</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php
$result = $conn->query("SELECT * FROM menu");

while ($row = $result->fetch_assoc()) {
    echo "
    <tr>
        <td>{$row['name']}</td>
        <td>₱{$row['price']}</td>
        <td>" . ($row['is_available'] ? 'Available' : 'Sold Out') . "</td>
        <td><a href='edit_item.php?id={$row['id']}'>Edit</a></td>
    </tr>";
}
?>
</table>

</body>
</html>
