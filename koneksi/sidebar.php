<?php 
session_start();
$halaman = basename($_SERVER['PHP_SELF']); 

// Cek apakah sudah login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../../index.php");
    exit;
}

// Foto admin
$fotoAdmin = !empty($_SESSION['foto']) 
    ? "../../foto_admin/" . $_SESSION['foto']
    : "../../gambar/mental.png";
?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistem Pakar</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
* {
  margin: 0; padding: 0; box-sizing: border-box;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

body {
  display: flex;
  min-height: 100vh;
  background: #ffffffff;
  overflow-x: hidden;
}

.menu-samping {
  width: 250px;
  background:  #b3ebf2;
  display: flex;
  flex-direction: column;
  padding: 30px 0;
  position: fixed;
  top: 0; bottom: 0; left: 0;
  z-index: 200;
  transition: transform .3s ease;
  box-shadow: 0 2px 8px rgba(0,0,0,.25);
}

.daftar-menu {
  display: flex;
  flex-direction: column;
  width: 100%;
  padding-left: 20px;
  margin-top: 70px;
}

.daftar-menu a {
  display: flex;
  align-items: center;
  text-decoration: none;
  color: #222222ff;
  font-weight: bold;
  font-size: 17px;
  padding: 10px 0;
  transition: .3s ease;
}
.daftar-menu a i { 
  margin-right: 10px;
}

.daftar-menu a:hover,
.daftar-menu a.active {
  color: #000000ff; 
  background: rgba(255, 255, 255, 0.6); 
  padding-left: 18px; 
}

.menu-atas {
  position: fixed;
  top: 0; left: 0; right: 0;
  height: 70px;
  background: #ffffffff;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0 15px;
  z-index: 250;
  box-shadow: 0 2px 8px rgba(0,0,0,.25);
}

.kiri-menu-atas {
  display: flex; align-items: center; gap: 10px;
}

.logo-navbar {
  width: 50px; height: 50px;
  object-fit: cover;
}

.tengah-menu-atas {
  position: absolute;
  left: 50%; transform: translateX(-50%);
}
.teks-selamat {
  font-size: 20px;
  font-weight: bold;
  color: #333;
}

.kanan-menu-atas {
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 16px;
  font-weight: bold;
  color: #333;
  cursor: pointer;
}
.kanan-menu-atas .foto-admin {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  object-fit: cover;
  border: 1px solid #00AEEF;
  cursor: pointer;
}

.tombol-menu {
  display: none;
  font-size: 25px;
  cursor: pointer;
  margin-right: 12px;
}

.modal {
  display: none;
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(0,0,0,0.5);
  justify-content: center;
  align-items: center;
  z-index: 500;
}

.modal-content {
  background: #fff;
  width: 400px;
  padding: 20px;
  border-radius: 12px;
  box-shadow: 0 0 10px rgba(0,0,0,.3);
}

.close {
  float: right;
  font-size: 22px;
  cursor: pointer;
}

.modal-content input {
  width: 100%;
  padding: 10px;
  border: 1px solid #aaa;
  border-radius: 7px;
  margin-bottom: 12px;
}

.tombol-simpan {
  width: 100%;
  padding: 10px;
  border: none;
  background: #00AEEF;
  color: white;
  border-radius: 7px;
  font-weight: bold;
  cursor: pointer;
}

.pembungkus_pasword {
  position: relative;
  width: 100%;
}

.pembungkus_pasword input {
  width: 100%;
  padding-right: 40px;
}

.pembungkus_pasword .toggle-eye {
  position: absolute;
  right: 10px;
  top: 40%;
  transform: translateY(-50%);
  cursor: pointer;
  color: #555;
}


@media (max-width: 768px) {
  .menu-samping { 
    transform: translateX(-100%);
    width:230px;
  }
  .daftar-menu { margin-top: 50px; }
  .menu-samping.show { transform: translateX(0); }
  .tombol-menu { display: block; }
  .tengah-menu-atas { display: none; }
  .menu-atas { height:50px; }
  .kiri-menu-atas {
    display: flex; align-items: center; gap: 10px;
    margin-left:-130px;
  }
  .logo-navbar {
    width: 30px; height: 30px;
    object-fit: cover;
  }
  .kanan-menu-atas .foto-admin {
  width: 30px;
  height: 30px;
}
}
  </style>
</head>

<body>

<div class="menu-samping" id="menuSamping">
  <div class="daftar-menu">

    <a href="../halaman_utama/halaman_utama.php" class="<?= $halaman == 'halaman_utama.php' ? 'active' : '' ?>">
      <i class="fa-solid fa-house"></i> Halaman Utama
    </a>

    <a href="../gangguan/gangguan.php" class="<?= $halaman == 'gangguan.php' ? 'active' : '' ?>">
      <i class="fa-solid fa-triangle-exclamation"></i> Data Gangguan
    </a>

    <a href="../gejala/gejala.php" class="<?= $halaman == 'gejala.php' ? 'active' : '' ?>">
      <i class="fa-solid fa-notes-medical"></i> Data Gejala
    </a>

    <a href="../aturan/aturan.php" class="<?= $halaman == 'aturan.php' ? 'active' : '' ?>">
      <i class="fa-solid fa-gears"></i> Data Aturan
    </a>

    <a href="../solusi/solusi.php" class="<?= $halaman == 'solusi.php' ? 'active' : '' ?>">
      <i class="fa-solid fa-lightbulb"></i> Data Solusi
    </a>

    <a href="../laporan/laporan.php" class="<?= $halaman == 'laporan.php' ? 'active' : '' ?>">
      <i class="fa-solid fa-file-lines"></i> Laporan
    </a>

    <a id="keluar" style="cursor:pointer;">
      <i class="fa-solid fa-right-from-bracket"></i> Keluar
    </a>
  </div>
</div>

<div class="menu-atas">
  <i class="fa-solid fa-bars tombol-menu" id="tombolMenu"></i>

  <div class="kiri-menu-atas">
    <img src="../../gambar/mental.png" class="logo-navbar">
    <img src="../../gambar/love.png" class="logo-navbar">
  </div>

  <div class="tengah-menu-atas">
    <span class="teks-selamat">Sistem Pakar Diagnosa Gangguan Kesehatan Mental Pada Remaja</span>
  </div>

  <div class="kanan-menu-atas" onclick="openModal()">
    <span class="nama-admin"><?= $_SESSION['nama']; ?></span>

    <img src="<?= $fotoAdmin ?>" class="foto-admin">
  </div>
</div>

<!-- MODAL -->
<div id="modalProfile" class="modal">
  <div class="modal-content">

    <span class="close" onclick="closeModal()">&times;</span>
    <h2>Edit Profil Admin</h2>
<form id="formProfile"
      action="../../koneksi/update_profile.php" 
      method="POST" 
      enctype="multipart/form-data" 
      onsubmit="return cekPassword()">


      <label>Nama</label>
      <input type="text" name="nama" value="<?= $_SESSION['nama']; ?>" required>

      <label>Username</label>
      <input type="text" name="username" value="<?= $_SESSION['username']; ?>" required>

    <label>Password Saat Ini</label>
<div class="pembungkus_pasword">
  <input type="password" name="password_lama" id="password_lama" placeholder="Masukkan password saat ini">
  <i class="fa-solid fa-eye toggle-eye" onclick="togglePassword('password_lama', this)"></i>
</div>

<label>Password Baru</label>
<div class="pembungkus_pasword">
  <input type="password" name="password_baru" id="password_baru" placeholder="Kosongkan jika tidak ingin mengganti password">
  <i class="fa-solid fa-eye toggle-eye" onclick="togglePassword('password_baru', this)"></i>
</div>

<label>Konfirmasi Password Baru</label>
<div class="pembungkus_pasword">
  <input type="password" name="konfirmasi_password" id="konfirmasi_password" placeholder="Ulangi password baru">
  <i class="fa-solid fa-eye toggle-eye" onclick="togglePassword('konfirmasi_password', this)"></i>
</div>


      <label>Foto Baru</label>
      <input type="file" name="foto">

      <button type="submit" class="tombol-simpan">Simpan Perubahan</button>

    </form>
  </div>
</div>




<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
// Menu Samping Responsive
const tombolMenu  = document.getElementById("tombolMenu");
const menuSamping = document.getElementById("menuSamping");

tombolMenu.addEventListener("click", () => {
  menuSamping.classList.toggle("show");
});

function cekUkuran() {
  if (window.innerWidth <= 768) {
    tombolMenu.style.display = "block";
  } else {
    tombolMenu.style.display = "none";
    menuSamping.classList.remove("show");
  }
}
cekUkuran();
window.addEventListener("resize", cekUkuran);



// Modal Profil 
function openModal() {
  document.getElementById("modalProfile").style.display = "flex";
}

function closeModal() {
  document.getElementById("modalProfile").style.display = "none";
}

// Validasi Password (Frontend)
function cekPassword() {
  let lama       = document.getElementById("password_lama").value.trim();
  let baru       = document.getElementById("password_baru").value.trim();
  let konfirmasi = document.getElementById("konfirmasi_password").value.trim();

  // Jika password baru diisi, wajib cek yang lain
  if (baru !== "" || konfirmasi !== "") {

    if (lama === "") {
      alert("Harap masukkan password saat ini!");
      return false;
    }

    if (baru !== konfirmasi) {
      alert("Password baru dan konfirmasi tidak sama!");
      return false;
    }

    if (baru.length < 6) {
      alert("Password baru minimal 6 karakter!");
      return false;
    }
  }

  return true;
}


// Icon Menampilkan / Menyembunyikan Password
function togglePassword(id, icon) {
  let input = document.getElementById(id);

  if (input.type === "password") {
    input.type = "text";
    icon.classList.remove("fa-eye");
    icon.classList.add("fa-eye-slash");
  } else {
    input.type = "password";
    icon.classList.remove("fa-eye-slash");
    icon.classList.add("fa-eye");
  }
}

// AJAX Simpan Profil
$(document).ready(function () {

  $("#formProfile").on("submit", function (e) {
    e.preventDefault();

    if (!cekPassword()) {
      return false;
    }

    let formData = new FormData(this);

    $.ajax({
      url: $(this).attr("action"),
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,

      success: function (res) {
        res = res.trim();

        // ========== Cek respon dari PHP ==========
        if (res === "PASSWORD_SALAH") {
          alert("Password aktif saat ini salah!");
          return;
        }

        if (res === "PASSWORD_LAMA_KOSONG") {
          alert("Password saat ini harus diisi!");
          return;
        }

        if (res === "KONFIRMASI_TIDAK_SAMA") {
          alert("Password baru dan konfirmasi tidak sama!");
          return;
        }

        if (res === "SESSION_EXPIRED") {
          alert("Sesi login berakhir, silakan login kembali!");
          window.location.href = "../../login.php";
          return;
        }

        if (res.startsWith("SQL_ERROR")) {
          alert("Terjadi kesalahan database:\n" + res);
          return;
        }

        if (res === "BERHASIL") {
          alert("Profil berhasil diperbarui!");
          location.reload();
          return;
        }

        alert("Respon tidak dikenal dari server: " + res);
      },

      error: function (xhr, status, error) {
        console.log(xhr.responseText);
        alert("Terjadi kesalahan saat menyimpan data!");
      }
    });
  });

});


// Tombol Logout
document.getElementById("keluar").addEventListener("click", function () {
  if (confirm("Apakah Anda yakin ingin Keluar?")) {
    window.location.href = "../../logout.php";
  }
});
</script>
</body>
</html>
