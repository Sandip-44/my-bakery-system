<?php
session_start();
require_once 'config/database.php';
$conn = getDBConnection();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Delicious Bakery - Fresh Baked Daily</title>
  <link rel="stylesheet" href="css/style.css" />
  <style>
    /* ===== Reset ===== */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: "Poppins", sans-serif;
      background: #f5ebe0;
      color: #3c2f2f;
      line-height: 1.6;
    }

    /* ===== Navbar ===== */
    .navbar {
      background: #6f4e37;
      padding: 1rem 0;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
    }

    .nav-container {
      width: 90%;
      margin: 0 auto;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo h2 {
      color: #f5ebe0;
    }

    .nav-menu {
      display: flex;
      list-style: none;
      gap: 20px;
    }

    .nav-menu a {
      color: #f5ebe0;
      text-decoration: none;
      font-weight: 600;
      transition: 0.3s;
    }

    .nav-menu a:hover,
    .nav-menu .active {
      color: #d4a373;
    }

    .cart-count {
      background: #d4a373;
      border-radius: 50%;
      padding: 2px 6px;
      color: #fff;
      font-size: 0.8rem;
    }

    /* ===== Hero Section ===== */
    .hero {
      position: relative;
      background: url("/img.png") center/cover no-repeat;
      height: 80vh;
      display: flex;
      justify-content: center;
      align-items: center;
      color: #fff;
      text-align: center;
    }

    .hero-overlay {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0, 0, 0, 0.45);
    }

    .hero-content {
      position: relative;
      z-index: 2;
    }

    .hero-content h1 {
      font-size: 3rem;
      margin-bottom: 10px;
    }

    .hero-content p {
      font-size: 1.2rem;
      margin-bottom: 20px;
    }

    .btn {
      background: #d4a373;
      color: #fff;
      padding: 10px 25px;
      border-radius: 25px;
      text-decoration: none;
      font-weight: 600;
      border: none;
      cursor: pointer;
      transition: 0.3s;
    }

    .btn:hover {
      background: #b97b50;
    }

    /* ===== Features ===== */
    .features {
      background: #fff;
      padding: 60px 0;
    }

    .section-title {
      text-align: center;
      font-size: 2rem;
      margin-bottom: 40px;
      color: #6f4e37;
    }

    .feature-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 25px;
      width: 90%;
      margin: 0 auto;
    }

    .feature-card {
      background: #f8f1e7;
      border-radius: 12px;
      padding: 25px;
      text-align: center;
      transition: 0.3s;
    }

    .feature-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .feature-icon {
      font-size: 2.5rem;
      margin-bottom: 10px;
    }

    /* ===== Products ===== */
    .product-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 25px;
      margin: 40px auto;
      width: 90%;
    }

    .product-card {
      background: #fff;
      border-radius: 10px;
      overflow: hidden;
      text-align: center;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
    }

    .product-card img {
      width: 100%;
      height: 220px;
      object-fit: cover;
    }

    .product-card h3 {
      margin: 15px 0 5px;
    }

    .product-card p {
      color: #666;
      font-size: 0.9rem;
      padding: 0 10px;
    }

    .price {
      display: block;
      color: #6f4e37;
      font-weight: bold;
      margin: 10px 0;
    }

    /* ===== Footer ===== */
    .footer {
      background: #6f4e37;
      color: #f5ebe0;
      text-align: center;
      padding: 20px 0;
      margin-top: 40px;
    }
  </style>
</head>

<body>
  <!-- Navigation -->
  <nav class="navbar">
    <div class="container nav-container">
      <div class="logo">
        <h2>🥐 Delicious Bakery</h2>
      </div>
      <!-- <ul class="nav-menu">
        <li><a href="index.php" class="active">Home</a></li>
        <li><a href="products.php">Products</a></li>
        <li>
          <a href="cart.php">Cart <span class="cart-count" id="cartCount">
              <?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>
            </span></a>
        </li>
        <li><a href="admin/register.php">Register</a></li>

        <li><a href="admin/login.php">Admin</a></li>
      </ul> -->
      <ul class="nav-menu">
        <li><a href="index.php" class="active">Home</a></li>
        <li><a href="products.php">Products</a></li>
        <li><a href="cart.php">Cart</a></li>
        <?php if (isset($_SESSION['user_logged_in'])): ?>
          <li><a href="users/logout.php">Logout (<?= $_SESSION['user_name']; ?>)</a></li>
        <?php else: ?>
          <li><a href="users/login.php">Login</a></li>
          <li><a href="users/register.php">Register</a></li>
        <?php endif; ?>
      </ul>

    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-overlay"></div>
    <div class="hero-content">
      <h1>Freshly Baked Every Morning</h1>
      <p>Experience the warmth of handmade breads and pastries</p>
      <a href="products.php" class="btn btn-primary">Explore Menu</a>
    </div>
  </section>

  <!-- Features -->
  <section class="features">
    <div class="container">
      <h2 class="section-title">Why Choose Us</h2>
      <div class="feature-grid">
        <div class="feature-card">
          <div class="feature-icon">🍞</div>
          <h3>Fresh & Warm</h3>
          <p>All our breads are baked daily using traditional recipes.</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">☕</div>
          <h3>Perfect Pair</h3>
          <p>Enjoy your favorite pastry with freshly brewed coffee.</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">🚚</div>
          <h3>Quick Delivery</h3>
          <p>Order online and get warm bakery items delivered fast.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <p>&copy; 2025 Delicious Bakery. All rights reserved.</p>
    </div>
  </footer>
</body>

</html>