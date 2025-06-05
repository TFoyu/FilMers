<?php
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nama  = $_POST['nama'];
  $email = $_POST['email'];
  $pesan = $_POST['pesan'];

  $stmt = $koneksi->prepare("INSERT INTO contacts (nama, email, pesan) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $nama, $email, $pesan);

  if ($stmt->execute()) {
    echo "<script>alert('Pesan berhasil dikirim!');</script>";
  } else {
    echo "<script>alert('Gagal mengirim pesan.');</script>";
  }

  $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Kontak - FilMers</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <?php include "layout/header.php" ?>

  <main class="container">
    <h2>Hubungi Kami</h2>
    <form action="kontak.php" method="POST">
      <label for="nama">Nama:</label>
      <input type="text" id="nama" name="nama" required><br>
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required><br>
      <label for="pesan">Pesan:</label>
      <textarea id="pesan" name="pesan" rows="5" required></textarea><br>
      <button type="submit">Kirim</button>
    </form>
  </main>

  <?php include "layout/footer.html" ?>

</body>
</html>
