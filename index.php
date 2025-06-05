<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Review Film - FilMers</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <?php include "layout/header.php" ?>

  <!-- Hero Section -->
  <main>
    <section id="home" class="hero">
      <div class="hero-overlay">
        <h1>Selamat Datang di <span>FilMers</span></h1>
        <p>Temukan review film terbaik untukmu</p>
        <a href="#film-list" class="btn">Mulai Jelajahi</a>
      </div>
    </section>


    <!-- Daftar Film -->
    <section id="film-list" class="film-list container">
      <?php
        include "koneksi.php";
        $sql = "SELECT * FROM films";
        $result = $koneksi->query($sql);

        if ($result->num_rows > 0) {
          while ($film = $result->fetch_assoc()) {
            $title = htmlspecialchars($film['title']);
            $genre = htmlspecialchars($film['genre']);
            $image = htmlspecialchars($film['image']);
            $rating = round($film['rating']);

            // Tampilkan bintang rating
            $stars = str_repeat("★", $rating) . str_repeat("☆", 5 - $rating);

            echo "
            <div class='film-card'>
              <img src='$image' alt='Poster $title' onclick=\"openFilmDetail('$title')\" style='cursor:pointer;' />
              <h3><a href='film.php?title=" . urlencode($title) . "'>$title</a></h3>
              <p>Genre: $genre</p>
              <p>$stars</p>
            </div>
            ";
          }
        } else {
          echo "<p>Tidak ada film yang tersedia.</p>";
        }
      ?>
    </section>

  </main>

  <?php include "layout/footer.html" ?>

  <!-- Modal Login -->
  <div id="login-modal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeLogin()">&times;</span>
      <h2>Login</h2>
      <form action="#" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required /><br />
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required /><br />
        <button type="submit">Masuk</button>
      </form>
    </div>
  </div>

  <script src="script.js"></script>
  <!-- Modal Detail Film -->
<div id="film-detail-modal" class="modal">
  <div class="modal-content film-detail-content">
    <span class="close" onclick="closeFilmDetail()">&times;</span>
    <img id="modal-poster" src="" alt="Poster Film" class="film-poster" />
    <h2 id="modal-title"></h2>

    <!-- Rating display -->
    <div id="modal-rating">
      <p>Rating:</p>
      <div id="stars-container">
        <!-- Bintang rating akan dimunculkan di sini -->
      </div>
    </div>

    <!-- Komentar -->
    <section class="komentar-section">
      <h3>Komentar</h3>
      <ul id="komentar-list" class="komentar-list">
        <!-- List komentar muncul di sini -->
      </ul>

      <form id="komentar-form" class="komentar-form" onsubmit="tambahKomentar(event)">
        <textarea id="input-komentar" rows="3" placeholder="Tulis komentar..." required></textarea>
        <button type="submit">Kirim Komentar</button>
      </form>
    </section>
  </div>
</div>

</body>
</html>
