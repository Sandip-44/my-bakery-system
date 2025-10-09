<?php
    session_start();
    require_once 'config/database.php';
    $conn = getDBConnection();

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])){
        $pid = intval($_POST['product_id']);
        if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
        if(!isset($_SESSION['cart'][$pid])) $_SESSION['cart'][$pid] = 0;
        $_SESSION['cart'][$pid] += 1;
        header('Location: cart.php'); exit;
    }

    if(isset($_GET['remove'])){
        $rid = intval($_GET['remove']);
        if(isset($_SESSION['cart'][$rid])){
            unset($_SESSION['cart'][$rid]);
        }
        header('Location: cart.php'); exit;
    }

    $cart_items = [];
    $total = 0;
    if(!empty($_SESSION['cart'])){
        $ids = array_keys($_SESSION['cart']);
        $in = implode(',', array_map('intval',$ids));
        $res = $conn->query("SELECT * FROM products WHERE id IN ($in)");
        while($r = $res->fetch_assoc()){
            $qty = $_SESSION['cart'][$r['id']];
            $r['qty'] = $qty;
            $r['subtotal'] = $qty * $r['price'];
            $total += $r['subtotal'];
            $cart_items[] = $r;
        }
    }
    ?>
    <!doctype html>
    <html>
    <head><meta charset="utf-8"><title>Cart</title><link rel="stylesheet" href="css/style.css"></head>
    <body>
    <nav class="navbar"><div class="container"><div class="logo"><h2>🥖 Delicious Bakery</h2></div>
    <ul class="nav-menu"><li><a href="index.php">Home</a></li><li><a href="products.php">Products</a></li><li><a href="cart.php">Cart</a></li><li><a href="admin/login.php">Admin</a></li></ul></div></nav>
    <main class="container"><h2>Your Cart</h2>
    <?php if(empty($cart_items)): ?>
      <p>Your cart is empty. <a href="index.php">Go shopping</a></p>
    <?php else: ?>
      <table class="cart-table"><tr><th>Product</th><th>Price</th><th>Qty</th><th>Subtotal</th><th>Action</th></tr>
      <?php foreach($cart_items as $it): ?>
        <tr>
          <td><?php echo htmlspecialchars($it['name']); ?></td>
          <td>$<?php echo number_format($it['price'],2); ?></td>
          <td><?php echo $it['qty']; ?></td>
          <td>$<?php echo number_format($it['subtotal'],2); ?></td>
          <td><a href="cart.php?remove=<?php echo $it['id']; ?>">Remove</a></td>
        </tr>
      <?php endforeach; ?>
      </table>
      <p><strong>Total: $<?php echo number_format($total,2); ?></strong></p>
      <form method="POST" action="">
        <button type="button" onclick="alert('Demo: no checkout implemented')">Checkout (demo)</button>
      </form>
    <?php endif; ?>
    </main></body></html>