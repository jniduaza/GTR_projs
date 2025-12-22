<?php include '../config.php'; ?>

<form method="POST" enctype="multipart/form-data">

    <input name="name" placeholder="Food name" required>

    <textarea name="description" placeholder="Description"></textarea>
    <input type="number" step="0.01" name="price" placeholder="Price" required>
    <select name="category_id">
        <?php
        $cats = $conn->query("SELECT * FROM categories");
        while ($c = $cats->fetch_assoc()) {
            echo "<option value='{$c['id']}'>{$c['name']}</option>";
        }
        ?>
    </select>

    <!-- IMAGE UPLOAD -->
    <label>Image</label>
    <input 
        type="file"
        name="image"
        id="imageInput"
        accept="image/*"
        required
    >

    <img id="preview" style="display:none; width:150px; margin-top:10px; border-radius:10px;">

    <button>Add Item</button>
</form>


<?php
if ($_POST) {

    $price = str_replace(',', '', $_POST['price']);

    // Image upload
    $imageName = time() . "_" . $_FILES['image']['name'];
    move_uploaded_file(
        $_FILES['image']['tmp_name'],
        "../images/" . $imageName
    );

    $stmt = $conn->prepare(
        "INSERT INTO menu (name, description, price, image, category_id)
         VALUES (?, ?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "ssdsi",
        $_POST['name'],
        $_POST['description'],
        $price,
        $imageName,
        $_POST['category_id']
    );

    $stmt->execute();
    header("Location: admin.php");
}
?>

