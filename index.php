<?php
require 'config.php';
session_start();

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Validasi sederhana
    if (empty($username) || empty($email) || empty($password)) {
        $error = "Semua field wajib diisi.";
    } elseif ($password !== $confirm_password) {
        $error = "Password tidak cocok.";
    } else {
        // Cek apakah email sudah terdaftar
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);

        if ($stmt->rowCount() > 0) {
            $error = "Email sudah terdaftar.";
        } else {
            // Simpan user baru
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
            $stmt->execute([
                ':username' => $username,
                ':email' => $email,
                ':password' => $hashedPassword
            ]);

            // Redirect ke login setelah registrasi sukses
            header("Location: login.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registrasi</title>
    <style>
        body { font-family: Arial; background-color: #f4f4f4; padding: 50px; }
        .form-container { width: 400px; margin: auto; background: #fff; padding: 20px; border-radius: 10px; }
        input[type=text], input[type=email], input[type=password] {
            width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ccc; border-radius: 5px;
        }
        input[type=submit] {
            background-color: #007BFF; color: white; padding: 10px 15px; border: none; border-radius: 5px;
        }
        .error { color: red; }
        .success { color: green; }
        a { text-decoration: none; color: #007BFF; }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Registrasi</h2>

    <?php if ($error): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Username</label><br>
        <input type="text" name="username" required><br>

        <label>Email</label><br>
        <input type="email" name="email" required><br>

        <label>Password</label><br>
        <input type="password" name="password" required><br>

        <label>Konfirmasi Password</label><br>
        <input type="password" name="confirm_password" required><br>

        <input type="submit" value="Daftar">
    </form>

    <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
</div>

</body>
</html>
