<?php
    session_start();
    require_once '../config/database.php';
    if(!isset($_SESSION['admin_logged_in'])){ header('Location: login.php'); exit; }
    $msg='';
    if($_SERVER['REQUEST_METHOD']==='POST'){
        $name = $_POST['name']; $desc = $_POST['description']; $price = floatval($_POST['price']);
        $conn = getDBConnection();
        $stmt = $conn->prepare('INSERT INTO products (name, description, price) VALUES (?,?,?)');
        $stmt->bind_param('ssd',$name,$desc,$price);
        $stmt->execute();
        header('Location: dashboard.php'); exit;
    }
    ?>
    <!doctype html><html><head><meta charset="utf-8"><title>Add Product</title><link rel="stylesheet" href="../css/style.css"></head><body>
    <main class="container"><h2>Add Product</h2>
    <form method="POST"><label>Name</label><input name="name" required><label>Description</label><textarea name="description"></textarea><label>Price</label><input name="price" type="number" step="0.01" required><button type="submit">Save</button></form>
    </main></body></html>