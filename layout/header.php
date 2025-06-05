<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
  <nav class="navbar">
    <div class="logo">
      <h1>FilMers</h1>
    </div>
    <ul class="menu">
      <li><a href="index.php">Beranda</a></li>
      <li><a href="semua-film.php">Semua Film</a></li>
      <li><a href="kontak.php">Kontak</a></li>
    </ul>

    <form class="search-form" action="semua-film.php" method="GET">
      <input type="text" name="q" placeholder="Cari film..." />
    </form>


    <?php if (isset($_SESSION['username'])): ?>
      <a href="#" class="user-button" title="Keluar" onclick="confirmLogout(event)">
        <img src="img/user-icon.png" alt="Logout" class="user-icon" />
      </a>
    <?php else: ?>
      <a href="login.php" class="user-button" title="Masuk">
        <img src="img/user-icon.png" alt="Login" class="user-icon" />
      </a>
    <?php endif; ?>

  </nav>
</header>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/script.js"></script>


