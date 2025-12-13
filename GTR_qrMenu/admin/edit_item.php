<?php
include '../config.php';

$id = $_GET['id'];
$item = $conn->query("SELECT * FROM menu WHERE id=$id")->fetch_assoc();
?>

<form method="POST">
    <input name="name" value="<?= $item['name'] ?>">
    <textarea name="description"><?= $item['description'] ?></textarea>
    <input name="price" value="<?= $item['price'] ?>">
    <label>
        <input type="checkbox" name="available"
        <?= $item['is_available'] ? 'checked' : '' ?>>
        Available
    </label>
    <button>Update</button>
</form>

<?php
if ($_POST) {
    $available = isset($_POST['available']) ? 1 : 0;

    $stmt = $conn->prepare(
        "UPDATE menu SET name=?, description=?, price=?, is_available=?
         WHERE id=?"
    );
    $stmt->bind_param(
        "ssdii",
        $_POST['name'],
        $_POST['description'],
        $_POST['price'],
        $available,
        $id
    );
    $stmt->execute();

    header("Location: dashboard.php");
}
?>
