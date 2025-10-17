<?php
session_start();
require_once '../config/database.php';
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$conn = getDBConnection();
$id = intval($_GET['id'] ?? 0);

// Fetch existing product
$stmt = $conn->prepare('SELECT * FROM products WHERE id=? LIMIT 1');
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    die('Product not found');
}

$product = $res->fetch_assoc();

// Update on POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = floatval($_POST['price']);

    $update = $conn->prepare('UPDATE products SET name=?, description=?, price=? WHERE id=?');
    $update->bind_param('ssdi', $name, $desc, $price, $id);
    $update->execute();

    header('Location: dashboard.php');
    exit;
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Edit Product | Delicious Bakery</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: #fff8f0;
            color: #333;
        }

        .navbar {
            background: #e67e22;
            /* color: white; */
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
        }

        .nav-menu {
            list-style: none;
            display: flex;
            gap: 1.5rem;
            margin: 0;
            padding: 0;
        }

        .nav-menu a {
            /* color: white; */
            text-decoration: none;
            font-weight: 500;
        }

        .nav-menu a:hover {
            opacity: 0.8;
        }

        .container {
            width: 90%;
            max-width: 600px;
            margin: 2rem auto;
            /* background: white; */
            padding: 2rem 2.5rem;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        h2 {
            color: #d35400;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        label {
            font-weight: 600;
            color: #444;
        }

        input,
        textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            outline: none;
            font-size: 15px;
            transition: border-color 0.2s;
            font-family: inherit;
        }

        input:focus,
        textarea:focus {
            border-color: #e67e22;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        button {
            background: #e67e22;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background: #d35400;
        }

        .back-link {
            display: inline-block;
            margin-top: 1.5rem;
            text-align: center;
            width: 100%;
            color: #e67e22;
            text-decoration: none;
            font-weight: 500;
        }

        .back-link:hover {
            text-decoration: underline;
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
        <h2>✏️ Edit Product</h2>
        <form method="POST">
            <label for="name">Product Name</label>
            <input id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>

            <label for="description">Description</label>
            <textarea id="description" name="description"><?php echo htmlspecialchars($product['description']); ?></textarea>

            <label for="price">Price ($)</label>
            <input id="price" name="price" type="number" step="0.01" value="<?php echo htmlspecialchars($product['price']); ?>" required>

            <button type="submit">Update Product</button>
        </form>

        <a href="dashboard.php" class="back-link">← Back to Dashboard</a>
    </main>
</body>

</html>