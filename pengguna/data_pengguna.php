<?php
session_start();
require_once __DIR__ . '/../koneksi/koneksi.php'; 

if (!isset($conn) || !$conn) {
  die("Koneksi database tidak tersedia.");
}

mysqli_set_charset($conn, "utf8mb4");

function h($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

function generateIdPengguna($conn): string {
  $sql = "SELECT MAX(id_pengguna) AS max_id FROM pengguna";
  $res = mysqli_query($conn, $sql);
  if (!$res) return "P0001";

  $row = mysqli_fetch_assoc($res);
  $maxId = (!empty($row['max_id'])) ? $row['max_id'] : null;

  if (!$maxId) return "P0001";

  $num = (int)preg_replace('/\D/', '', $maxId);
  $num++;
  return "P" . str_pad((string)$num, 4, "0", STR_PAD_LEFT);
}

$saved = false;
$data = [
  "nama_pengguna" => "",
  "jenis_kelamin" => "",
  "usia" => "",
  "alamat" => ""
];

$pesan = "";

/* =========================
   LOAD DATA DARI SESSION
   ========================= */
if (!empty($_SESSION['id_pengguna'])) {
  $sql = "SELECT nama_pengguna, jenis_kelamin, usia, alamat
          FROM pengguna WHERE id_pengguna=? LIMIT 1";
  $stmt = mysqli_prepare($conn, $sql);

  if (!$stmt) {
    $pesan = "Prepare gagal: " . mysqli_error($conn);
  } else {
    mysqli_stmt_bind_param($stmt, "s", $_SESSION['id_pengguna']);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    if ($res && mysqli_num_rows($res) > 0) {
      $data = mysqli_fetch_assoc($res);
      $saved = true;
    } else {
      unset($_SESSION['id_pengguna']);
      $saved = false;
    }
    mysqli_stmt_close($stmt);
  }
}

/* =========================
   SIMPAN / UPDATE
   ========================= */
if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST["aksi"] ?? "") === "simpan") {
  $nama   = trim($_POST["nama_pengguna"] ?? "");
  $jk     = trim($_POST["jenis_kelamin"] ?? "");
  $usia   = (int)($_POST["usia"] ?? 0);
  $alamat = trim($_POST["alamat"] ?? "");

  if ($nama === "" || $jk === "" || $usia <= 0 || $alamat === "") {
    $pesan = "Semua field wajib diisi.";
  } else {

    // INSERT (kalau belum punya session id)
    if (empty($_SESSION['id_pengguna'])) {
      $id = generateIdPengguna($conn);

      $sql = "INSERT INTO pengguna
              (id_pengguna, nama_pengguna, jenis_kelamin, usia, alamat, tanggal_daftar)
              VALUES (?, ?, ?, ?, ?, CURDATE())";

      $stmt = mysqli_prepare($conn, $sql);
      if (!$stmt) {
        $pesan = "Prepare INSERT gagal: " . mysqli_error($conn);
      } else {
        mysqli_stmt_bind_param($stmt, "sssis", $id, $nama, $jk, $usia, $alamat);

        if (mysqli_stmt_execute($stmt)) {
          @mysqli_commit($conn);

          $_SESSION['id_pengguna'] = $id;

          mysqli_stmt_close($stmt);
          header("Location: data_pengguna.php?sukses=1");

          exit;
        } else {
          $pesan = "Gagal menyimpan data: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
      }

    // UPDATE (kalau sudah punya id)
    } else {
      $sql = "UPDATE pengguna
              SET nama_pengguna=?, jenis_kelamin=?, usia=?, alamat=?
              WHERE id_pengguna=?";

      $stmt = mysqli_prepare($conn, $sql);
      if (!$stmt) {
        $pesan = "Prepare UPDATE gagal: " . mysqli_error($conn);
      } else {
        mysqli_stmt_bind_param($stmt, "ssiss", $nama, $jk, $usia, $alamat, $_SESSION['id_pengguna']);

        if (mysqli_stmt_execute($stmt)) {
          @mysqli_commit($conn);

          mysqli_stmt_close($stmt);
          header("Location: data_pengguna.php?sukses=1");
          exit;
        } else {
          $pesan = "Gagal memperbarui data: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Data Diri Pengguna</title>

<style>
:root{ --nav-h:70px; --border:#111; }
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}
body{background:#fff;}
.menu-atas{
  position:fixed;top:0;left:0;right:0;height:var(--nav-h);
  background:#fff;display:flex;align-items:center;
  justify-content:space-between;padding:0 16px;
  box-shadow:0 2px 8px rgba(0,0,0,.25);
  z-index:9999;
}
.kiri-menu-atas{display:flex;gap:10px;}
.logo-navbar{width:45px;height:45px;object-fit:cover;}
.tengah-menu-atas{font-size:20px;font-weight:900;color:#333;}
.wrap{padding-top:var(--nav-h);}
.konten{
  display:grid;
  grid-template-columns:1fr 1fr;
  min-height:calc(100vh - var(--nav-h));
}
.kiri{
  background:#b3ebf2;
  display:flex;
  justify-content:center;
  align-items:center;
  padding:24px 16px;
}
.kanan{
  background:#fcb6d0;
  display:flex;
  justify-content:center;
  align-items:center;
  padding:24px 16px;
}
.card{
  width:min(520px,100%);
  background:#fff;
  border:2px solid var(--border);
  border-radius:12px;
  padding:16px;
}
.card h2{text-align:center;margin-bottom:14px;font-size:18px;}
.row{
  display:grid;
  grid-template-columns:120px 1fr;
  gap:10px;
  margin-bottom:12px;
  align-items:center;
}
label{font-weight:800;font-size:13px;}
input,select{
  width:100%;
  padding:10px;
  border:2px solid var(--border);
  border-radius:10px;
  outline:none;
  font-size:13px;
}
.pesan{
  background:#fff;
  border:2px solid var(--border);
  padding:10px;
  margin-bottom:12px;
  font-weight:700;
  border-radius:10px;
}
.aksi{
  display:flex;
  gap:10px;
  justify-content:flex-end;
  margin-top:10px;
  flex-wrap:wrap;
}
.btn{
  border:2px solid var(--border);
  background:#fff;
  padding:8px 14px;
  border-radius:10px;
  font-weight:900;
  text-decoration:none;
  color:#111;
  cursor:pointer;
  font-size:12px;
  box-shadow:0 2px 0 rgba(0,0,0,.25);
}
.panel-kanan{
  width:min(520px,100%);
  background:#fff;
  border:2px solid var(--border);
  border-radius:12px;
  padding:16px;
}
.panel-kanan h3{margin-bottom:8px;font-size:18px;}
.panel-kanan p{font-weight:700;line-height:1.5;font-size:13px;}

@media(max-width:768px){
  .tengah-menu-atas{display:none;}
  .konten{grid-template-columns:1fr; min-height:auto;}
  .kiri,.kanan{padding:14px 12px; align-items:flex-start;}
  .card,.panel-kanan{width:100%; max-width:520px;}
  .row{grid-template-columns:1fr; gap:6px;}
  .aksi{justify-content:stretch;}
  .aksi .btn{flex:1 1 auto;text-align:center;}
}
@media(max-width:420px){
  .logo-navbar{width:40px;height:40px;}
  .card{padding:14px;}
  input,select{padding:9px;}
}
</style>
</head>

<body>
<div class="menu-atas">
  <div class="kiri-menu-atas">
    <img src="../gambar/mental.png" class="logo-navbar" alt="">
    <img src="../gambar/love.png" class="logo-navbar" alt="">
  </div>
  <div class="tengah-menu-atas">Sistem Pakar Diagnosa Gangguan Kesehatan Mental Pada Remaja</div>
  <div></div>
</div>

<div class="wrap">
  <div class="konten">
    <div class="kiri">
      <div class="card">
        <h2>Masukkan Data Diri</h2>

        <?php if($pesan): ?>
          <div class="pesan"><?= h($pesan) ?></div>
        <?php elseif(isset($_GET['sukses']) && $saved): ?>
          <div class="pesan">Data berhasil disimpan</div>
        <?php endif; ?>

        <form method="post">
          <input type="hidden" name="aksi" value="simpan">

          <div class="row">
            <label>Nama</label>
            <input name="nama_pengguna" value="<?= h($data['nama_pengguna']) ?>" required>
          </div>

          <div class="row">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" required>
              <option value="">-- Pilih --</option>
              <option value="Laki-laki" <?= ($data['jenis_kelamin']=="Laki-laki")?"selected":"" ?>>Laki-laki</option>
              <option value="Perempuan" <?= ($data['jenis_kelamin']=="Perempuan")?"selected":"" ?>>Perempuan</option>
            </select>
          </div>

          <div class="row">
            <label>Umur</label>
            <input type="number" name="usia" value="<?= h((string)$data['usia']) ?>" required>
          </div>

          <div class="row">
            <label>Alamat</label>
            <input name="alamat" value="<?= h($data['alamat']) ?>" required>
          </div>

          <div class="aksi">
            <a href="../index.php" class="btn">KEMBALI</a>
            <button class="btn" type="submit">SIMPAN</button>
            <?php if($saved): ?>
              <a href="pertanyaan.php" class="btn">MULAI TES</a>
            <?php endif; ?>
          </div>
        </form>
      </div>
    </div>

    <div class="kanan">
      <div class="panel-kanan">
        <h3>Petunjuk</h3>

        <?php if(!$saved): ?>
          <p>
            Silakan isi <b>data diri</b> terlebih dahulu di sebelah kiri,
            lalu klik tombol <b>SIMPAN</b>.
            <br><br>
            Setelah data tersimpan, tombol <b>MULAI TES</b> akan muncul.
          </p>
        <?php else: ?>
          <p>
            Data diri sudah tersimpan. Kamu bisa mulai tes kapan saja dengan klik tombol <b>MULAI TES</b>.
            <br><br>
            Halo <b><?= h($data['nama_pengguna']) ?></b>
          </p>
        <?php endif; ?>

      </div>
    </div>
  </div>
</div>
</body>
</html>
