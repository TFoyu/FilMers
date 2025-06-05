<?php
session_start(); // Tambahkan untuk mengakses $_SESSION
include "koneksi.php";

// Ambil judul film dari URL
$title = isset($_GET['title']) ? urldecode($_GET['title']) : '';

// Cek film di database
$stmt = $koneksi->prepare("SELECT * FROM films WHERE title = ?");
$stmt->bind_param("s", $title);
$stmt->execute();
$result = $stmt->get_result();
$film = $result->fetch_assoc();

if (!$film) {
    die("Film tidak ditemukan.");
}

$film_id = $film['id'];

// Ambil komentar film
$komentar_stmt = $koneksi->prepare("
  SELECT r.rating, r.comment, r.created_at, u.username
  FROM reviews r
  JOIN users u ON r.user_id = u.id
  WHERE r.film_id = ?
  ORDER BY r.created_at DESC
");
$komentar_stmt->bind_param("i", $film_id);
$komentar_stmt->execute();
$komentar_result = $komentar_stmt->get_result();

$komentar_data = [];
while ($row = $komentar_result->fetch_assoc()) {
    $komentar_data[] = $row;
}

// Handle form kirim komentar dan rating
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $rating = $_POST['rating'];
    $komentar = $_POST['comment'];
    $user_id = $_SESSION['user_id'];
    $nama = $_SESSION['username']; // Atau $_SESSION['nama'] jika kamu menyimpannya sebagai 'nama'

    // Simpan komentar ke database
    $stmt = $koneksi->prepare("INSERT INTO reviews (film_id, user_id, rating, comment) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $film_id, $user_id, $rating, $komentar);

    $stmt->execute();

    // Redirect agar komentar muncul setelah refresh
    header("Location: film.php?title=" . urlencode($title));
    exit();
}
?>



<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Detail Film - FilMers</title>
  <link rel="stylesheet" href="style.css?v=2" />
</head>
<body>
  <?php include "layout/header.php" ?>

  <main class="container">
    <section id="film-detail">
      <h2 id="judul-film"><?= htmlspecialchars($film['title']) ?></h2>
      <img id="poster-film" src="<?= htmlspecialchars($film['image']) ?>" alt="Poster <?= htmlspecialchars($film['title']) ?>" />
      <p><strong>Genre:</strong> <span id="genre-film"><?= htmlspecialchars($film['genre']) ?></span></p>
      <p><strong>Rating:</strong> <span id="rating-film"><?= htmlspecialchars($film['rating']) ?></span></p>
      <p id="deskripsi-film">Film ini belum memiliki deskripsi lengkap.</p>


      <hr />

      <?php if (isset($_SESSION['user_id'])): ?>
        <form method="POST">
          <input type="hidden" name="film_id" value="<?= $film['id'] ?>">
          
          <p><strong>Nama:</strong> <?= htmlspecialchars($_SESSION['username']) ?></p>

          <label for="rating">Rating:</label>
          <select name="rating" required>
            <option value="">Pilih rating</option>
            <option value="1">★☆☆☆☆</option>
            <option value="2">★★☆☆☆</option>
            <option value="3">★★★☆☆</option>
            <option value="4">★★★★☆</option>
            <option value="5">★★★★★</option>
          </select>

          <textarea name="comment" placeholder="Tulis komentar..." required></textarea>
          <button type="submit">Kirim Komentar</button>
        </form>
      <?php else: ?>
        <p>Silakan <a href="login.php" onclick="openLogin()">login</a> untuk memberi komentar dan rating.</p>
      <?php endif; ?>



      <div id="list-komentar">
        <?php if (count($komentar_data) === 0): ?>
          <p>Belum ada komentar.</p>
        <?php else: ?>
          <ul>
            <?php foreach ($komentar_data as $k): ?>
              <li>
                <strong><?= htmlspecialchars($k['username']) ?>:</strong><br>
                <?= str_repeat("★", $k['rating']) . str_repeat("☆", 5 - $k['rating']) ?><br>
                <?= nl2br(htmlspecialchars($k['comment'])) ?>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>
    </section>
  </main>

  <?php include "layout/footer.html" ?>

  <script src="script.js"></script>
</body>
</html>
