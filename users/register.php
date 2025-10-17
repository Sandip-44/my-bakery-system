<?php
session_start();
require_once '../config/database.php';
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $conn = getDBConnection();
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);

    if ($stmt->execute()) {
        $_SESSION['user_logged_in'] = true;
        $_SESSION['user_name'] = $name;
        $_SESSION['user_id'] = $stmt->insert_id;
        header('Location: ../index.php');
        exit;
    } else {
        $msg = "Email already exists or registration failed.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>User Registration | Delicious Bakery</title>
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
        <h2>🧁 Create Account</h2>
        <?php if ($msg): ?><div class="msg"><?= $msg ?></div><?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>

</html>