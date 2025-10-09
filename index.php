<?php
session_start();
require_once 'config/database.php';
$conn = getDBConnection();
$products = $conn->query('SELECT * FROM products');
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Delicious Bakery sand- Home</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <nav class="navbar">
    <div class="container">
      <div class="logo">
        <h2>🥖 Delicious Bakery</h2>
      </div>
      <ul class="nav-menu">
        <li><a href="index.php">Home</a></li>
        <li><a href="products.php">Products</a></li>
        <li><a href="cart.php">Cart <span id="cartCount"><?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?></span></a></li>
        <li><a href="admin/login.php">Admin</a></li>
      </ul>
    </div>
  </nav>
  <main class="container">
    <h1>Welcome to Delicious Bakery </h1>
    <section class="products">
      <?php while ($p = $products->fetch_assoc()): ?>
        <div class="card">
          <h3><?php echo htmlspecialchars($p['name']); ?></h3>
          <p><?php echo htmlspecialchars($p['description']); ?></p>
          <p><strong>$<?php echo number_format($p['price'], 2); ?></strong></p>
          <form method="POST" action="cart.php">
            <input type="hidden" name="product_id" value="<?php echo $p['id']; ?>">
            <button type="submit" name="add">Add to cart</button>
          </form>
        </div>
      <?php endwhile; ?>
    </section>
  </main>
</body>

</html>