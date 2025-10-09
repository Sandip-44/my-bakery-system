<?php
    session_start();
    require_once '../config/database.php';
    $error='';
    if($_SERVER['REQUEST_METHOD']==='POST'){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $conn = getDBConnection();
        $stmt = $conn->prepare('SELECT * FROM admin_users WHERE username=? LIMIT 1');
        $stmt->bind_param('s',$username);
        $stmt->execute();
        $res = $stmt->get_result();
        if($res->num_rows){
            $user = $res->fetch_assoc();
            if(password_verify($password, $user['password'])){
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_username'] = $user['username'];
                header('Location: dashboard.php'); exit;
            }
        }
        $error = 'Invalid username or password';
    }
    ?>
    <!doctype html><html><head><meta charset="utf-8"><title>Admin Login</title><link rel="stylesheet" href="../css/style.css"></head><body>
    <nav class="navbar"><div class="container"><div class="logo"><h2>🥖 Delicious Bakery</h2></div>
    <ul class="nav-menu"><li><a href="../index.php">Home</a></li><li><a href="../products.php">Products</a></li><li><a href="../cart.php">Cart</a></li><li><a href="login.php" class="active">Admin</a></li></ul></div></nav>
    <div class="login-container"><form method="POST" class="login-form"><h2>Admin Login</h2><?php if($error): ?><div class="alert alert-error"><?php echo $error; ?></div><?php endif; ?>
    <div class="form-group"><label>Username</label><input type="text" name="username" required></div>
    <div class="form-group"><label>Password</label><input type="password" name="password" required></div>
    <button type="submit">Login</button>
    <p style="text-align:center; margin-top:8px;">Default: admin / admin123</p>
    </form></div></body></html>