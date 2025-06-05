<?php
include "koneksi.php";

$films = []; // tampung hasil query di array

if (isset($_GET['q']) && !empty(trim($_GET['q']))) {
    $q = "%" . $_GET['q'] . "%";
    $stmt = $koneksi->prepare("SELECT * FROM films WHERE title LIKE ? OR genre LIKE ? OR deskripsi LIKE ?");
    $stmt->bind_param("sss", $q, $q, $q);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $koneksi->query("SELECT * FROM films");
}

// masukkan semua hasil query ke dalam array $films
while ($row = $result->fetch_assoc()) {
    $films[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Semua Film - FilMers</title>
  <link rel="stylesheet" href="style.css?v=2" />
</head>
<body>

  <?php include "layout/header.php" ?>

  <div class="filter-bar">
    <label for="genre-filter">Filter Genre:</label>
    <select id="genre-filter" onchange="filterGenre()">
      <option value="all">Semua</option>
      <option value="Petualangan">Petualangan</option>
      <option value="Romantis">Romantis</option>
      <option value="Sci-Fi">Sci-Fi</option>
      <option value="Misteri">Misteri</option>
    </select>
  </div>

  <?php if (isset($_GET['q']) && !empty(trim($_GET['q']))): ?>
    <h2>Hasil pencarian untuk: "<?= htmlspecialchars($_GET['q']) ?>"</h2>
  <?php endif; ?>

  <section class="film-list-vertikal" id="film-list">
    <?php foreach ($films as $film): ?>
      <div class="film-card" data-genre="<?= htmlspecialchars($film['genre']) ?>">
        <a href="film.php?title=<?= urlencode($film['title']) ?>">
          <img src="<?= htmlspecialchars($film['image']) ?>" alt="Poster <?= htmlspecialchars($film['title']) ?>" />
        </a>
        <div class="film-info">
          <h3><a href="film.php?title=<?= urlencode($film['title']) ?>"><?= htmlspecialchars($film['title']) ?></a></h3>
          <p>Genre: <?= htmlspecialchars($film['genre']) ?></p>
          <p>Rating: <?= htmlspecialchars($film['rating']) ?></p>
        </div>
      </div>
    <?php endforeach; ?>
  </section>

  <?php include "layout/footer.html" ?>

  <script src="script.js"></script>
</body>
</html>
