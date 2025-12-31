<?php include '../config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>GoodTaste Menu Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optional Custom Admin CSS -->
    <link rel="stylesheet" href="../css/admin.css">
</head>

<body class="bg-light">

    <!-- TOP NAVBAR -->
    <nav class="navbar navbar-dark bg-dark px-3">
        <span class="navbar-brand mb-0 h1">GoodTaste Menu</span>
    </nav>

    <div class="container-fluid">
        <div class="row">

            <!-- SIDEBAR -->
            <aside class="col-md-3 col-lg-2 bg-white border-end min-vh-100 p-3">
                <h6 class="text-muted">ADMIN</h6>
                <ul class="nav flex-column gap-2">
                    <li class="nav-item">
                        <a class="nav-link active" href="admin.php">📋 Menu Items</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#categoriesSection">🗂 Categories</a>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#addItemModal">
                            ➕ Add New Item
                        </button>
                    </li>
                </ul>

            </aside>

            <!-- ADD ITEM MODAL -->
            <div class="modal fade" id="addItemModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">

                        <form id="addItemForm" enctype="multipart/form-data">

                            <div class="modal-header">
                                <h5 class="modal-title">Add Menu Item</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">

                                <div class="row g-3">

                                    <div class="col-md-6">
                                        <label class="form-label">Category</label>
                                        <select name="category_id" class="form-select" required>
                                            <option value="">Select Category</option>
                                            <?php
                                            $cats = $conn->query("SELECT * FROM categories");
                                            while ($c = $cats->fetch_assoc()) {
                                                echo "<option value='{$c['id']}'>{$c['name']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Item Name</label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Description</label>
                                        <textarea name="description" class="form-control" rows="3" required></textarea>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Price (₱)</label>
                                        <input type="number" step="0.01" name="price" class="form-control" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Image (required)</label>
                                        <input type="file" name="image" class="form-control" accept="image/*" required>
                                    </div>

                                </div>

                                <div id="addItemAlert" class="alert d-none mt-3"></div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Cancel
                                </button>
                                <button type="submit" class="btn btn-dark">
                                    Save Item
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

            <!-- ADD CATEGORY MODAL -->
            <div class="modal fade" id="addCategoryModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <form id="addCategoryForm">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Category</h5>
                                <button class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <input type="text" name="name" class="form-control" placeholder="Category name"
                                    required>
                                <div id="addCatAlert" class="alert d-none mt-3"></div>
                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn btn-dark">Save</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <!-- EDIT CATEGORY MODAL -->
            <div class="modal fade" id="editCategoryModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <form id="editCategoryForm">
                            <input type="hidden" name="id" id="editCatId">

                            <div class="modal-header">
                                <h5 class="modal-title">Edit Category</h5>
                                <button class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <input type="text" name="name" id="editCatName" class="form-control" required>
                                <div id="editCatAlert" class="alert d-none mt-3"></div>
                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn btn-dark">Update</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>




            <!-- MAIN CONTENT -->
            <main class="col-md-9 col-lg-10 p-4">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Menu Items</h4>
                </div>

                <!-- MENU TABLE -->
                <div class="card shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Item</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $result = $conn->query("
                                SELECT menu.*, categories.name AS category_name
                                FROM menu
                                LEFT JOIN categories ON categories.id = menu.category_id
                                ORDER BY menu.id DESC
                            ");

                                    while ($row = $result->fetch_assoc()):
                                        ?>
                                        <tr>
                                            <td>
                                                <strong><?= $row['name'] ?></strong><br>
                                                <small class="text-muted"><?= $row['category_name'] ?></small>
                                            </td>
                                            <td>₱<?= number_format($row['price'], 2) ?></td>
                                            <td>
                                                <?php if ($row['is_available']): ?>
                                                    <span class="badge bg-success">Available</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Sold Out</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-end">
                                                <a class="btn btn-sm btn-outline-dark">
                                                    Edit
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </main>
            <!--  -->
            <hr class="my-5" id="categoriesSection">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">Categories</h4>
                <button class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                    ➕ Add Category
                </button>
            </div>

            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <table class="table mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $cats = $conn->query("SELECT * FROM categories ORDER BY name ASC");
                            while ($cat = $cats->fetch_assoc()):
                                ?>
                                <tr>
                                    <td>
                                        <?= htmlspecialchars($cat['name']) ?>
                                    </td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-outline-dark"
                                            onclick="openEditCategory(<?= $cat['id'] ?>, '<?= htmlspecialchars($cat['name']) ?>')">
                                            Edit
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger"
                                            onclick="deleteCategory(<?= $cat['id'] ?>)">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- <script>
        document.getElementById('addItemForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const form = this;
            const alertBox = document.getElementById('addItemAlert');
            const formData = new FormData(form);

            fetch('add_item_ajax.php', {
                method: 'POST',
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        alertBox.className = 'alert alert-success';
                        alertBox.innerText = 'Item added successfully!';
                        alertBox.classList.remove('d-none');

                        setTimeout(() => {
                            location.reload();
                        }, 800);
                    } else {
                        alertBox.className = 'alert alert-danger';
                        alertBox.innerText = data.message;
                        alertBox.classList.remove('d-none');
                    }
                })
                .catch(() => {
                    alertBox.className = 'alert alert-danger';
                    alertBox.innerText = 'Something went wrong.';
                    alertBox.classList.remove('d-none');
                });
        });
    </script> -->
    <script>
        const addForm = document.getElementById('addCategoryForm');
        const editForm = document.getElementById('editCategoryForm');

        addForm?.addEventListener('submit', e => {
            e.preventDefault();
            fetch('category_ajax.php', {
                method: 'POST',
                body: new FormData(addForm).append('action', 'add')
            }).then(() => location.reload());
        });

        function openEditCategory(id, name) {
            document.getElementById('editCatId').value = id;
            document.getElementById('editCatName').value = name;
            new bootstrap.Modal('#editCategoryModal').show();
        }

        editForm?.addEventListener('submit', e => {
            e.preventDefault();
            const fd = new FormData(editForm);
            fd.append('action', 'edit');

            fetch('category_ajax.php', { method: 'POST', body: fd })
                .then(() => location.reload());
        });

        function deleteCategory(id) {
            if (!confirm('Delete this category?')) return;

            const fd = new FormData();
            fd.append('action', 'delete');
            fd.append('id', id);

            fetch('category_ajax.php', { method: 'POST', body: fd })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'error') alert(data.message);
                    else location.reload();
                });
        }
    </script>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>