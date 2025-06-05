<?php
  include "koneksi.php";

  if(isset($_POST['daftar'])) {
    $user = $_POST['nama'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $konfirmasi = $_POST['konfirmasi'];

    if($pass !== $konfirmasi) {
      die('Kata sandi harus sama');
    }
    
      // Amankan password
      $hashed = password_hash($pass, PASSWORD_DEFAULT);

      // Gunakan prepared statement untuk keamanan
      $stmt = $koneksi->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
      $stmt->bind_param("sss", $user, $hashed, $email);

      if ($stmt->execute()) {
          echo "Registrasi berhasil!";
      } else {
          echo "Registrasi gagal: " . $stmt->error;
      }

      $stmt->close();
      $koneksi->close();
  }
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register - FilMers</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <?php include "layout/header.php" ?>

  <main class="container">
    <h2>Daftar Akun Baru</h2>
    <form action="register.php" method="POST">
      <label for="nama">Nama Lengkap</label>
      <input type="text" id="nama" name="nama" required />

      <label for="email">Email</label>
      <input type="email" id="email" name="email" required />

      <label for="password">Kata Sandi</label>
      <input type="password" id="password" name="password" required />

      <label for="konfirmasi">Konfirmasi Kata Sandi</label>
      <input type="password" id="konfirmasi" name="konfirmasi" required />

      <button type="submit" name="daftar">Daftar</button>
    </form>
    <p style="text-align:center; margin-top:1rem;">
      Sudah punya akun? <a href="login.php">Masuk di sini</a>
    </p>
  </main>
</body>
</html>
