<?php
require 'config.php';
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Ambil data user dari database
$user_id = $_SESSION["user_id"];
$stmt = $pdo->prepare("SELECT username, email, created_at FROM users WHERE id = :id");
$stmt->execute([':id' => $user_id]);
$user = $stmt->fetch();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
        .container { max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 10px; }
        h2 { color: #333; }
        a.button {
            display: inline-block;
            margin: 5px 10px 0 0;
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        a.button.logout { background-color: #f44336; }
        a.button.delete { background-color: #9c27b0; }
    </style>
</head>
<body>

<div class="container">
    <h2>Selamat datang, <?= htmlspecialchars($user["username"]) ?>!</h2>
    <p><strong>Email:</strong> <?= htmlspecialchars($user["email"]) ?></p>
    <p><strong>Terdaftar Sejak:</strong> <?= htmlspecialchars($user["created_at"]) ?></p>

    <div>
        <a href="edit_profile.php" class="button">Edit Profil</a>
        <a href="logout.php" class="button logout">Logout</a>
        <a href="delete_account.php" class="button delete" onclick="return confirm('Yakin ingin menghapus akun?')">Hapus Akun</a>
    </div>
</div>

</body>
</html>
