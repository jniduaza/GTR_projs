<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>GoodTaste Menu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="bg-light">

    <!-- Floating Search and Category (Hidden by default: will be shown is user scrolls down) -->
    <div id="floatingHeader" class="floating-header">
        <div class="d-flex align-items-center gap-2 px-3 py-2">
            <button class="back-btn d-md-none" onclick="history.back()">←</button>
            <input type="text" id="floatingSearch" class="form-control" placeholder="Looking for something tasty?">
        </div>

        <!-- Category Tabs -->
        <div class="category-tabs px-3 pb-2">
            <button class="tab active" data-category="all">All</button>
            <?php
            $cats = $conn->query("SELECT * FROM categories");
            while ($c = $cats->fetch_assoc()) {
                echo "<button class='tab' data-category='{$c['id']}'>{$c['name']}</button>";
            }
            ?>
        </div>
    </div>

    <!-- Header/Banner upon landing (Customer view) -->
    <header class="bg-dark text-white text-center py-3">
        <h4 class="mb-0">GoodTaste Menu</h4>
    </header>

    <!-- Fixed Search and Category (Shown upon landing on the page) -->
    <div class="container my-3">
        <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search menu...">
        <div class="category-tabs mb-3">
            <button class="tab active" data-category="all">All</button>
            <?php
            $cats = $conn->query("SELECT * FROM categories");
            while ($c = $cats->fetch_assoc()) {
                echo "<button class='tab' data-category='{$c['id']}'>{$c['name']}</button>";
            }
            ?>
        </div>

        <!-- Menu Grid: shows menu items -->
        <div class="row g-3" id="menuGrid">
            <?php
            $items = $conn->query("
            SELECT menu.*, categories.name AS category_name
            FROM menu
            JOIN categories ON categories.id = menu.category_id
        ");
            while ($item = $items->fetch_assoc()) {
                $sold = $item['is_available'] == 0;
                ?>
                <div class="col-6 col-md-4 col-lg-3 menu-item" data-name="<?= strtolower($item['name']) ?>"
                    data-category="<?= $item['category_id'] ?>"
                    data-description="<?= htmlspecialchars($item['description']) ?>" data-price="<?= $item['price'] ?>"
                    data-image="images/<?= $item['image'] ?>" data-available="<?= $item['is_available'] ?>">

                    <div class="card h-100 <?= $sold ? 'sold-out' : '' ?>" <?= $sold ? '' : 'onclick="openModal(this)"' ?>>
                        <img src="images/<?= $item['image'] ?>" class="card-img-top">

                        <?php if ($sold): ?>
                            <span class="badge bg-danger sold-badge">SOLD OUT</span>
                        <?php endif; ?>

                        <div class="card-body p-2">
                            <h6 class="card-title mb-1"><?= $item['name'] ?></h6>
                            <small class="text-muted"><?= $item['category_name'] ?></small>
                            <div class="fw-bold mt-1">₱<?= number_format($item['price'], 2) ?></div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- Modal:  -->
    <div class="modal fade" id="itemModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <img id="modalImage" class="w-100 zoomable">
                    <div class="p-3">
                        <h5 id="modalTitle"></h5>
                        <p id="modalDescription" class="text-muted"></p>
                        <h6 id="modalPrice"></h6>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Menu JS -->
    <script src="js/menu.js"></script>
</body>

</html>