<?php
session_start();
require_once '../config/database.php';
if (!isset($_SESSION['admin_logged_in'])) {
  header('Location: login.php');
  exit;
}
$conn = getDBConnection();
$products = $conn->query('SELECT * FROM products');
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Admin Dashboard | Delicious Bakery</title>
  <link rel="stylesheet" href="../css/style.css">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: #fff8f0;
      color: #333;
    }

    /* Navbar */
    .navbar {
      background: #e67e22;
      color: white;
      padding: 1rem 0;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .navbar .container {
      width: 90%;
      max-width: 1100px;
      margin: auto;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .navbar .logo h2 {
      margin: 0;
      font-weight: 700;
      letter-spacing: 0.5px;
    }

    .nav-menu {
      list-style: none;
      display: flex;
      gap: 1.5rem;
      margin: 0;
      padding: 0;
    }

    .nav-menu a {
      color: white;
      text-decoration: none;
      font-weight: 500;
      transition: opacity 0.2s;
    }

    .nav-menu a:hover {
      opacity: 0.8;
    }

    /* Container */
    .container {
      width: 90%;
      max-width: 1100px;
      margin: 2rem auto;
    }

    h2 {
      color: #d35400;
      text-align: left;
      margin-bottom: 1rem;
    }

    /* Add product link */
    a.add-product-btn {
      display: inline-block;
      background: #27ae60;
      color: white;
      padding: 8px 14px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: 600;
      transition: background 0.3s;
      margin-bottom: 1rem;
    }

    a.add-product-btn:hover {
      background: #1e8449;
    }

    /* Table styling */
    .admin-table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }

    .admin-table th,
    .admin-table td {
      padding: 12px 15px;
      text-align: left;
    }

    .admin-table th {
      background: #f4a261;
      color: white;
      font-weight: 600;
    }

    .admin-table tr:nth-child(even) {
      background: #f9f9f9;
    }

    .admin-table tr:hover {
      background: #fff3e0;
    }

    .admin-table a {
      color: #e67e22;
      text-decoration: none;
      font-weight: 500;
    }

    .admin-table a:hover {
      text-decoration: underline;
    }

    /* Footer (optional) */
    footer {
      text-align: center;
      padding: 1rem;
      background: #f4a261;
      color: white;
      margin-top: 2rem;
    }
  </style>
</head>

<body>
  <nav class="navbar">
    <div class="container">
      <div class="logo">
        <h2>🥖 Delicious Bakery (Admin)</h2>
      </div>
      <ul class="nav-menu">
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </div>
  </nav>

  <main class="container">
    <h2>Product Management</h2>
    <a href="add_product.php" class="add-product-btn">➕ Add Product</a>

    <table class="admin-table">
      <tr>
        <th>ID</th>
        <th>Product Name</th>
        <th>Price</th>
        <th>Action</th>
      </tr>
      <?php while ($p = $products->fetch_assoc()): ?>
        <tr>
          <td><?php echo $p['id']; ?></td>
          <td><?php echo htmlspecialchars($p['name']); ?></td>
          <td>$<?php echo number_format($p['price'], 2); ?></td>
          <td>
            <a href="edit_product.php?id=<?php echo $p['id']; ?>">Edit</a> |
            <a href="delete_product.php?id=<?php echo $p['id']; ?>"
              onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </table>
  </main>

  <footer>
    <p>© <?php echo date('Y'); ?> Delicious Bakery Admin Panel</p>
  </footer>
</body>

</html>