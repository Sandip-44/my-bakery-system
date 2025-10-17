<?php
session_start();
require_once '../config/database.php';
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$id = intval($_GET['id'] ?? 0);
$conn = getDBConnection();

// Verify product exists
$stmt = $conn->prepare('SELECT id FROM products WHERE id=?');
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    die('Product not found.');
}

// Delete the product
$delete = $conn->prepare('DELETE FROM products WHERE id=?');
$delete->bind_param('i', $id);
$delete->execute();

header('Location: dashboard.php');
exit;
