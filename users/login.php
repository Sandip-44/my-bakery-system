<?php
session_start();
require_once '../config/database.php';
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $conn = getDBConnection();
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header('Location: ../index.php');
            exit;
        } else {
            $msg = "Invalid password.";
        }
    } else {
        $msg = "No account found with that email.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>User Login | Delicious Bakery</title>
    <link rel="stylesheet" href="../css/style.css" />
    <style>
        body {
            background: url('../images/admin-bg.jpg') center/cover no-repeat;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            backdrop-filter: blur(3px);
        }

        .form-card {
            background: rgba(255, 255, 255, 0.9);
            padding: 2rem 3rem;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        .form-card h2 {
            color: #6f4e37;
            margin-bottom: 1.5rem;
        }

        .form-group {
            text-align: left;
            margin-bottom: 1rem;
        }

        label {
            display: block;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            transition: border-color 0.2s;
        }

        input:focus {
            border-color: #d4a373;
        }

        button {
            width: 100%;
            background: #d4a373;
            color: #fff;
            font-weight: 600;
            padding: 10px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background: #b97b50;
        }

        .msg {
            background: #ffe3e3;
            color: #c0392b;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        p a {
            color: #6f4e37;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="form-card">
        <h2>🍪 User Login</h2>
        <?php if ($msg): ?><div class="msg"><?= $msg ?></div><?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <p>New user? <a href="register.php">Register here</a></p>
    </div>
</body>

</html>