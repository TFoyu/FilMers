<?php
session_start(); // untuk menyimpan data user yang login
include "koneksi.php";

if (isset($_POST['masuk'])) {
    $email = $_POST['email'];
    $pw = $_POST['password'];

    // Ambil data user berdasarkan email
    $stmt = $koneksi->prepare("SELECT id, username, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($pw, $user['password'])) {
            // Simpan data ke sesi
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Arahkan ke halaman utama
            header("Location: index.php");
            exit;
        } else {
            echo "Password salah.";
        }
    } else {
        echo "Akun tidak ditemukan.";
    }

    $stmt->close();
    $koneksi->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - FilMers</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <?php include "layout/header.php" ?>

  <main class="container">
    <h2>Login ke FilMers</h2>
    <form action="login.php" method="POST">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" required /><br>

      <label for="password">Kata Sandi</label>
      <input type="password" id="password" name="password" required /><br>

      <button type="submit" name="masuk">Masuk</button>
    </form>
    <p style="text-align:center; margin-top:1rem;">
      Belum punya akun? <a href="register.php">Daftar di sini</a>
    </p>
  </main>
</body>
</html>
