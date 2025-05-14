<?php
require 'config.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    die("Silakan login terlebih dahulu.");
}

$user_id = $_SESSION["user_id"];

// Proses update profil
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_username = $_POST["username"];
    $new_email = $_POST["email"];

    $stmt = $pdo->prepare("UPDATE users SET username = :username, email = :email WHERE id = :id");
    $stmt->execute([
        ':username' => $new_username,
        ':email' => $new_email,
        ':id' => $user_id
    ]);

    echo "Profil berhasil diubah.";
}

// Tampilkan data user untuk diedit
$stmt = $pdo->prepare("SELECT username, email FROM users WHERE id = :id");
$stmt->execute([':id' => $user_id]);
$user = $stmt->fetch();
?>

<form method="POST">
    <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required><br>
    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required><br>
    <button type="submit">Simpan Perubahan</button>
</form>
