<?php
include __DIR__ . '/../koneksi/koneksi.php';

if (!function_exists('h')) {
  function h($s){
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
  }
}

$idGangguan = isset($_GET['id_gangguan']) ? (int)$_GET['id_gangguan'] : 0;
$kategori   = isset($_GET['kategori']) ? trim($_GET['kategori']) : '';

if ($idGangguan <= 0) {
  echo 'Data solusi tidak ditemukan.';
  exit;
}

/* validasi kategori biar aman */
$kategoriValid = ['Ringan','Sedang','Berat'];
if (!in_array($kategori, $kategoriValid, true)) {
  // kalau kategori tidak dikirim / tidak valid, kita tampilkan semua solusi gangguan tsb
  $kategori = '';
}

/* ambil nama gangguan dari jenis_gangguan */
$qNama = mysqli_query($conn, "SELECT nama_gangguan FROM jenis_gangguan WHERE id_gangguan=$idGangguan LIMIT 1");
$dNama = mysqli_fetch_assoc($qNama);
$namaGangguan = $dNama ? $dNama['nama_gangguan'] : 'Gangguan';

/* query solusi */
if ($kategori !== '') {
  $stmt = mysqli_prepare($conn, "SELECT id_solusi, kategori, deskripsi_solusi FROM solusi WHERE id_gangguan=? AND kategori=? ORDER BY id_solusi ASC");
  mysqli_stmt_bind_param($stmt, "is", $idGangguan, $kategori);
} else {
  $stmt = mysqli_prepare($conn, "SELECT id_solusi, kategori, deskripsi_solusi FROM solusi WHERE id_gangguan=? ORDER BY kategori ASC, id_solusi ASC");
  mysqli_stmt_bind_param($stmt, "i", $idGangguan);
}

mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

$rows = [];
while($r = mysqli_fetch_assoc($res)) $rows[] = $r;

if (!$rows) {
  echo 'Solusi belum tersedia untuk gangguan ini.';
  exit;
}

/* =========================
   MODE AJAX (UNTUK MODAL)
   ========================= */
if (isset($_GET['ajax']) && $_GET['ajax'] == '1') {

  echo '<div style="font-weight:900;margin-bottom:6px;">'
       . h($namaGangguan) .
       ($kategori !== '' ? ' - ' . h($kategori) : '') .
       '</div>';

  echo '<div style="font-size:13px;line-height:1.6;">';
  echo '<ol style="padding-left:18px;margin:0;">';
  foreach ($rows as $r) {
    echo '<li style="margin-bottom:6px;">' . nl2br(h($r['deskripsi_solusi'])) . '</li>';
  }
  echo '</ol>';
  echo '</div>';

  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Solusi</title>
  <style>
    *{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}
    body{background:#fff;padding:16px;}
    .kotak{
      max-width:780px;margin:0 auto;
      border:2px solid #111;background:#fff;
      padding:14px;border-radius:12px;
    }
    .judul{font-weight:900;font-size:16px;margin-bottom:8px;}
    .sub{font-weight:800;font-size:13px;margin-bottom:10px;}
    .isi{font-size:13px;line-height:1.6;}
    .isi ol{padding-left:18px;}
    .isi li{margin-bottom:6px;}
    .kembali{
      display:inline-block;margin-top:12px;
      padding:8px 14px;border:2px solid #111;
      border-radius:10px;text-decoration:none;
      color:#111;font-weight:900;background:#fff;
    }
  </style>
</head>
<body>
  <div class="kotak">
    <div class="judul"><?= h($namaGangguan) ?></div>
    <?php if ($kategori !== ''): ?>
      <div class="sub">Kategori: <?= h($kategori) ?></div>
    <?php endif; ?>

    <div class="isi">
      <ol>
        <?php foreach($rows as $r): ?>
          <li><?= nl2br(h($r['deskripsi_solusi'])) ?></li>
        <?php endforeach; ?>
      </ol>
    </div>

    <a class="kembali" href="javascript:history.back()">Kembali</a>
  </div>
</body>
</html>
