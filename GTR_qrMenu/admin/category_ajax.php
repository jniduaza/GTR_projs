<?php
include '../config.php';

$action = $_POST['action'] ?? '';

if ($action === 'add') {
    $name = trim($_POST['name']);

    if ($name === '') {
        echo json_encode(['status' => 'error', 'message' => 'Category name required']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
    $stmt->bind_param("s", $name);
    $stmt->execute();

    echo json_encode(['status' => 'success']);
}

if ($action === 'edit') {
    $id = (int)$_POST['id'];
    $name = trim($_POST['name']);

    $stmt = $conn->prepare("UPDATE categories SET name=? WHERE id=?");
    $stmt->bind_param("si", $name, $id);
    $stmt->execute();

    echo json_encode(['status' => 'success']);
}

if ($action === 'delete') {
    $id = (int)$_POST['id'];

    // prevent delete if used
    $check = $conn->query("SELECT COUNT(*) AS total FROM menu WHERE category_id=$id");
    $row = $check->fetch_assoc();

    if ($row['total'] > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Category is in use']);
        exit;
    }

    $conn->query("DELETE FROM categories WHERE id=$id");
    echo json_encode(['status' => 'success']);
}
