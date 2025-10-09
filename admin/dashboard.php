<?php
    session_start();
    require_once '../config/database.php';
    if(!isset($_SESSION['admin_logged_in'])){
        header('Location: login.php'); exit;
    }
    $conn = getDBConnection();
    $products = $conn->query('SELECT * FROM products');
    ?>
    <!doctype html><html><head><meta charset="utf-8"><title>Admin Dashboard</title><link rel="stylesheet" href="../css/style.css"></head><body>
    <nav class="navbar"><div class="container"><div class="logo"><h2>🥖 Delicious Bakery (Admin)</h2></div>
    <ul class="nav-menu"><li><a href="dashboard.php">Dashboard</a></li><li><a href="logout.php">Logout</a></li></ul></div></nav>
    <main class="container"><h2>Products</h2>
    <a href="add_product.php">Add Product</a>
    <table class="admin-table"><tr><th>ID</th><th>Name</th><th>Price</th><th>Action</th></tr>
    <?php while($p = $products->fetch_assoc()): ?>
      <tr>
        <td><?php echo $p['id']; ?></td>
        <td><?php echo htmlspecialchars($p['name']); ?></td>
        <td>$<?php echo number_format($p['price'],2); ?></td>
        <td><a href="edit_product.php?id=<?php echo $p['id']; ?>">Edit</a> | <a href="delete_product.php?id=<?php echo $p['id']; ?>">Delete</a></td>
      </tr>
    <?php endwhile; ?>
    </table></main></body></html>