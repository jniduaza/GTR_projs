<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>GoodTaste Menu</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>GoodTaste Menu</header>

<div class="container">

<?php
$categories = $conn->query("SELECT * FROM categories");

while ($cat = $categories->fetch_assoc()) {
    echo "<h2>{$cat['name']}</h2><div class='grid'>";

    $items = $conn->query(
        "SELECT * FROM menu WHERE category_id={$cat['id']}"
    );

    while ($item = $items->fetch_assoc()) {

        $soldOut = $item['is_available'] == 0;

        echo "
        <div class='card " . ($soldOut ? "sold" : "") . "'>
            <img src='images/{$item['image']}'>
            " . ($soldOut ? "<span class='badge'>SOLD OUT</span>" : "") . "
            <h3>{$item['name']}</h3>
            <p>{$item['description']}</p>
            <div class='price'>₱{$item['price']}</div>
        </div>
        ";
    }

    echo "</div>";
}
?>

</div>

</body>
</html>
