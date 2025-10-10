<?php
session_start();
require_once 'config/database.php';
$conn = getDBConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
  $pid = intval($_POST['product_id']);
  if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
  if (!isset($_SESSION['cart'][$pid])) $_SESSION['cart'][$pid] = 0;
  $_SESSION['cart'][$pid] += 1;
  header('Location: cart.php');
  exit;
}

if (isset($_GET['remove'])) {
  $rid = intval($_GET['remove']);
  if (isset($_SESSION['cart'][$rid])) {
    unset($_SESSION['cart'][$rid]);
  }
  header('Location: cart.php');
  exit;
}

$cart_items = [];
$total = 0;
if (!empty($_SESSION['cart'])) {
  $ids = array_keys($_SESSION['cart']);
  $in = implode(',', array_map('intval', $ids));
  $res = $conn->query("SELECT * FROM products WHERE id IN ($in)");
  while ($r = $res->fetch_assoc()) {
    $qty = $_SESSION['cart'][$r['id']];
    $r['qty'] = $qty;
    $r['subtotal'] = $qty * $r['price'];
    $total += $r['subtotal'];
    $cart_items[] = $r;
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>🛒 Your Cart - Delicious Bakery</title>
  <link rel="stylesheet" href="css/cart.css">
  <style>
    /* Reset and Base */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }

    body {
      background-color: #fffaf5;
      color: #333;
      line-height: 1.6;
    }

    /* Navbar */
    .navbar {
      background: #fff;
      border-bottom: 1px solid #eee;
      padding: 15px 0;
    }

    .navbar .container {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .navbar .logo h2 {
      font-size: 1.8rem;
      color: #c86b4a;
    }

    .navbar .nav-menu {
      list-style: none;
      display: flex;
      gap: 25px;
    }

    .navbar .nav-menu a {
      text-decoration: none;
      color: #444;
      font-weight: 500;
      transition: color 0.3s ease;
    }

    .navbar .nav-menu a:hover,
    .navbar .nav-menu .active {
      color: #c86b4a;
    }

    /* Page Header */
    .page-header {
      background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)),
        url("../images/bakery-banner.jpg") center/cover no-repeat;
      color: #fff;
      text-align: center;
      padding: 80px 20px;
    }

    .page-header h1 {
      font-size: 2.5rem;
      font-weight: 700;
    }

    /* Cart Container */
    .cart-container {
      max-width: 1100px;
      margin: 50px auto;
      background: #fff;
      border-radius: 15px;
      padding: 25px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
    }

    /* Empty Cart */
    .empty-cart {
      text-align: center;
      padding: 60px;
    }

    .empty-cart p {
      font-size: 1.2rem;
      color: #555;
      margin-bottom: 20px;
    }

    .empty-cart .btn-primary {
      background-color: #c86b4a;
      color: white;
      text-decoration: none;
      padding: 12px 25px;
      border-radius: 8px;
      transition: background 0.3s;
    }

    .empty-cart .btn-primary:hover {
      background-color: #a55435;
    }

    /* Cart Table */
    .cart-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 30px;
    }

    .cart-table th,
    .cart-table td {
      padding: 15px;
      text-align: center;
      border-bottom: 1px solid #eee;
    }

    .cart-table th {
      background-color: #f9f4ef;
      font-weight: 600;
      color: #5a4033;
    }

    .cart-table td {
      vertical-align: middle;
    }

    .cart-product {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .cart-product img {
      width: 60px;
      height: 60px;
      border-radius: 8px;
      object-fit: cover;
    }

    /* Remove Button */
    .remove-btn {
      color: #c86b4a;
      text-decoration: none;
      font-weight: 500;
      transition: color 0.3s ease;
    }

    .remove-btn:hover {
      color: #a55435;
    }

    /* Cart Summary */
    .cart-summary {
      text-align: right;
      margin-top: 20px;
    }

    .cart-summary h3 {
      color: #2f4f4f;
      margin-bottom: 15px;
    }

    .btn-checkout {
      background-color: #c86b4a;
      color: white;
      border: none;
      padding: 12px 25px;
      border-radius: 8px;
      font-size: 1rem;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .btn-checkout:hover {
      background-color: #a55435;
    }

    /* Footer */
    .footer {
      background: #fff;
      text-align: center;
      padding: 20px;
      color: #666;
      border-top: 1px solid #eee;
      margin-top: 50px;
    }
  </style>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar">
    <div class="container">
      <div class="logo">
        <h2>🥖 Delicious Bakery</h2>
      </div>
      <ul class="nav-menu">
        <li><a href="index.php">Home</a></li>
        <li><a href="products.php">Products</a></li>
        <li><a href="cart.php" class="active">Cart</a></li>
        <li><a href="admin/login.php">Admin</a></li>
      </ul>
    </div>
  </nav>

  <!-- Header -->
  <header class="page-header">
    <h1>Your Shopping Cart</h1>
    <p>Review your selections before checkout</p>
  </header>

  <!-- Cart Content -->
  <main class="container cart-container">
    <?php if (empty($cart_items)): ?>
      <div class="empty-cart">
        <p>Your cart is empty 😢</p>
        <a href="products.php" class="btn btn-primary">Go Shopping</a>
      </div>
    <?php else: ?>
      <table class="cart-table">
        <thead>
          <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Subtotal</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($cart_items as $it): ?>
            <tr>
              <td class="cart-product">
                <img src="uploads/<?php echo $it['image'] ?? 'default.jpg'; ?>" alt="">
                <span><?php echo htmlspecialchars($it['name']); ?></span>
              </td>
              <td>$<?php echo number_format($it['price'], 2); ?></td>
              <td><?php echo $it['qty']; ?></td>
              <td>$<?php echo number_format($it['subtotal'], 2); ?></td>
              <td><a href="cart.php?remove=<?php echo $it['id']; ?>" class="remove-btn">Remove</a></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <div class="cart-summary">
        <h3>Total: $<?php echo number_format($total, 2); ?></h3>
        <button class="btn btn-checkout" onclick="alert('Demo only: Checkout not implemented yet')">Proceed to Checkout</button>
      </div>
    <?php endif; ?>
  </main>

  <footer class="footer">
    <p>&copy; 2025 Delicious Bakery. All rights reserved.</p>
  </footer>
</body>

</html>