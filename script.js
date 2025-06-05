// ==== Logout dengan SweetAlert ====
function confirmLogout(event) {
  event.preventDefault();

  Swal.fire({
    title: 'Yakin ingin logout?',
    text: "Kamu akan keluar dari akun FilMers.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Ya, logout!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = 'logout.php';
    }
  });
}

// ==== Filter Genre pada semua-film.php ====
function filterGenre() {
  const genre = document.getElementById("genre-filter").value;
  const films = document.querySelectorAll(".film-list-vertikal .film-card");

  films.forEach(film => {
    const filmGenre = film.getAttribute("data-genre");
    film.style.display = (genre === "all" || filmGenre === genre) ? "flex" : "none";
  });
}

// ==== Pencarian Film dari Navbar ====
function searchFilm() {
  const keyword = document.getElementById("search").value.trim();
  if (!keyword) {
    alert("Masukkan kata kunci pencarian!");
    return;
  }

  window.location.href = "semua-film.php?search=" + encodeURIComponent(keyword);
}
