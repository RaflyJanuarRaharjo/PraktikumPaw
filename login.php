<?php
require 'config.php';
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Ambil user berdasarkan email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user["password"])) {
        // Simpan session dan arahkan ke dashboard
        $_SESSION["user_id"] = $user["id"];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Email atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body { font-family: Arial; background-color: #f4f4f4; padding: 50px; }
        .form-container { width: 400px; margin: auto; background: #fff; padding: 20px; border-radius: 10px; }
        input[type=email], input[type=password] {
            width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ccc; border-radius: 5px;
        }
        input[type=submit] {
            background-color: #4CAF50; color: white; padding: 10px 15px; border: none; border-radius: 5px;
        }
        .error { color: red; }
        a { text-decoration: none; color: #4CAF50; }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Login</h2>

    <?php if ($error): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Email</label><br>
        <input type="email" name="email" required><br>

        <label>Password</label><br>
        <input type="password" name="password" required><br>

        <input type="submit" value="Login">
    </form>

    <p>Belum punya akun? <a href="index.php">Daftar di sini</a></p>
</div>

</body>
</html>
