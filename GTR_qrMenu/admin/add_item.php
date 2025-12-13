<?php include '../config.php'; ?>

<form method="POST">
    <input name="name" placeholder="Name" required>
    <textarea name="description" placeholder="Description"></textarea>
    <input type="number" step="0.01" name="price" placeholder="Price" required>
    <input name="image" placeholder="Image filename">
    <select name="category_id">
        <?php
        $cats = $conn->query("SELECT * FROM categories");
        while ($c = $cats->fetch_assoc()) {
            echo "<option value='{$c['id']}'>{$c['name']}</option>";
        }
        ?>
    </select>
    <button>Add</button>
</form>

<?php
if ($_POST) {
    $stmt = $conn->prepare(
        "INSERT INTO menu (name, description, price, image, category_id)
         VALUES (?, ?, ?, ?, ?)"
    );
    $stmt->bind_param(
        "ssdsi",
        $_POST['name'],
        $_POST['description'],
        $_POST['price'],
        $_POST['image'],
        $_POST['category_id']
    );
    $stmt->execute();

    header("Location: dashboard.php");
}
?>
