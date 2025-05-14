<?php
require 'config.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    die("Silakan login terlebih dahulu.");
}

$user_id = $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
    $stmt->execute([':id' => $user_id]);

    session_unset();
    session_destroy();

    echo "Akun berhasil dihapus.";
}
?>

<form method="POST" onsubmit="return confirm('Yakin ingin menghapus akun ini?');">
    <button type="submit">Hapus Akun</button>
</form>
