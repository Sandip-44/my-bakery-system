<?php
session_start();
require_once 'config/database.php';
$conn = getDBConnection();

// Handle Add to Cart
if (isset($_POST['add'])) {
    $id = $_POST['product_id'];
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    if (!in_array($id, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $id;
    }
}

$products = $conn->query('SELECT * FROM products');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Delicious Bakery</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* General Reset */
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

        /* Navbar (same as homepage) */
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

        .navbar .nav-menu a:hover {
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

        /* Products Section */
        .products-section {
            padding: 50px 20px;
            max-width: 1200px;
            margin: auto;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
        }

        .product-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .product-details {
            padding: 20px;
            flex: 1;
        }

        .product-details h3 {
            font-size: 1.3rem;
            color: #c86b4a;
            margin-bottom: 8px;
        }

        .product-details p {
            font-size: 0.95rem;
            color: #666;
            margin-bottom: 10px;
        }

        .product-details .price {
            font-weight: bold;
            color: #2f4f4f;
            font-size: 1.1rem;
        }

        /* Add to Cart Button */
        .product-card form {
            text-align: center;
            padding: 15px;
        }

        .product-card button {
            background-color: #c86b4a;
            color: white;
            border: none;
            padding: 10px 25px;
            font-size: 0.95rem;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .product-card button:hover {
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
    <nav class="navbar">
        <div class="container nav-container">
            <div class="logo">
                <h2>🥐 Delicious Bakery</h2>
            </div>
            <!-- <ul class="nav-menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="products.php" class="active">Products</a></li>
                <li>
                    <a href="cart.php">Cart <span class="cart-count">
                            
                        </span></a>
                </li>
                <li><a href="admin/login.php">Admin</a></li>
            </ul> -->
            <ul class="nav-menu">
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="cart.php">Cart
                        <?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>
                    </a></li>
                <?php if (isset($_SESSION['user_logged_in'])): ?>
                    <li><a href="users/logout.php">Logout (<?= $_SESSION['user_name']; ?>)</a></li>
                <?php else: ?>
                    <li><a href="users/login.php">Login</a></li>
                    <li><a href="users/register.php">Register</a></li>
                <?php endif; ?>
            </ul>

        </div>
    </nav>

    <main class="container">
        <h1 class="section-title">Our Products</h1>
        <div class="product-grid">
            <?php while ($p = $products->fetch_assoc()): ?>
                <div class="product-card">

                    <p><?php echo htmlspecialchars($p['description']); ?></p>
                    <span class="price">$<?php echo number_format($p['price'], 2); ?></span>
                    <form method="POST" action="products.php">
                        <input type="hidden" name="product_id" value="<?php echo $p['id']; ?>">
                        <button type="submit" name="add" class="btn btn-primary">Add to Cart</button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2025 Delicious Bakery. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>