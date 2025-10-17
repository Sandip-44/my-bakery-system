<?php
session_start();
require_once '../config/database.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    if ($password !== $confirm) {
        $message = 'Passwords do not match.';
    } else {
        $conn = getDBConnection();

        // Check if username already exists
        $stmt = $conn->prepare('SELECT id FROM admin_users WHERE username=?');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $message = 'Username already exists.';
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare('INSERT INTO admin_users (username, password) VALUES (?, ?)');
            $stmt->bind_param('ss', $username, $hashedPassword);
            if ($stmt->execute()) {
                $message = '✅ Registration successful! You can now log in.';
            } else {
                $message = '❌ Something went wrong. Try again.';
            }
        }
        $stmt->close();
        $conn->close();
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Admin Registration | Delicious Bakery</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            background: url('../images/admin-bg.jpg') no-repeat center center/cover;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            backdrop-filter: blur(3px);
        }

        .register-card {
            background: rgba(255, 255, 255, 0.9);
            padding: 2rem 3rem;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .register-card h2 {
            margin-bottom: 1.5rem;
            color: #333;
        }

        .form-group {
            margin-bottom: 1rem;
            text-align: left;
        }

        .form-group label {
            font-weight: 600;
            display: block;
            margin-bottom: 5px;
            color: #444;
        }

        .form-group input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            outline: none;
            transition: border-color 0.2s;
        }

        .form-group input:focus {
            border-color: #27ae60;
        }

        button {
            width: 100%;
            background: #27ae60;
            border: none;
            padding: 10px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background: #1e8449;
        }

        .alert {
            background: #e3fcef;
            color: #2e7d32;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-weight: 500;
        }

        .alert-error {
            background: #ffe3e3;
            color: #c0392b;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-weight: 500;
        }

        .register-card p {
            margin-top: 10px;
            color: #555;
            font-size: 14px;
        }

        a {
            color: #e67e22;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="register-card">
        <h2>📝 Admin Registration</h2>

        <?php if ($message): ?>
            <div class="<?php echo strpos($message, '✅') !== false ? 'alert' : 'alert-error'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm" required>
            </div>

            <button type="submit">Register</button>
        </form>

        <p>Already registered? <a href="login.php">Login here</a></p>
    </div>
</body>

</html>