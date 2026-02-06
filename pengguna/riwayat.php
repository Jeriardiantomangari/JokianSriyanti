<?php
session_start();
include __DIR__ . '/../koneksi/koneksi.php';

function h($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

if (empty($_SESSION['id_pengguna'])) {
 header("Location: data_pengguna.php");
  exit;
}

$idp = mysqli_real_escape_string($conn, (string)$_SESSION['id_pengguna']);

/* =========================
   HAPUS RIWAYAT (PER USER)
   ========================= */
if (isset($_GET['hapus'])) {
  $id_konsultasi = (int)$_GET['hapus'];

  // Hapus tabel anak (aman walau FK tidak cascade)
  mysqli_query($conn, "DELETE FROM detail_konsultasi WHERE id_konsultasi = $id_konsultasi");
  mysqli_query($conn, "DELETE FROM cf_gangguan      WHERE id_konsultasi = $id_konsultasi");

  // Hapus konsultasi (hanya milik user login)
  mysqli_query($conn, "
    DELETE FROM konsultasi
    WHERE id_konsultasi = $id_konsultasi
      AND id_pengguna = '$idp'
  ");

  header("Location: riwayat.php");
  exit;
}

/* =========================
   AMBIL DATA RIWAYAT
   ========================= */
$list = [];
$q = mysqli_query($conn, "
  SELECT
    k.id_konsultasi,
    k.tanggal_konsultasi,
    j.nama_gangguan,
    k.persentase_tertinggi,
    k.kategori
  FROM konsultasi k
  LEFT JOIN jenis_gangguan j ON j.id_gangguan = k.id_gangguan
  WHERE k.id_pengguna = '$idp'
  ORDER BY k.tanggal_konsultasi DESC
");

if ($q) {
  while ($r = mysqli_fetch_assoc($q)) $list[] = $r;
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Riwayat Diagnosa</title>

  <style>
    *{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}
    body{background:#fff;}

    /* MENU ATAS */
    .menu-atas{
      position:fixed;top:0;left:0;right:0;height:70px;
      background:#fff;display:flex;align-items:center;
      justify-content:space-between;padding:0 16px;
      box-shadow:0 2px 8px rgba(0,0,0,.25);
      z-index:9999;
    }
    .kiri-menu-atas{display:flex;gap:10px;}
    .logo-navbar{width:45px;height:45px;object-fit:cover;}
    .tengah-menu-atas{font-size:20px;font-weight:900;color:#333;}

    /* PEMBUNGKUS */
    .pembungkus-halaman{padding-top:70px;min-height:100vh;}

    /* LATAR 2 WARNA */
    .area-dua-warna{
      position:relative;
      width:100%;
      min-height:calc(100vh - 70px);
      display:flex;
    }
    .latar-biru{flex:1;background:#b3ebf2;}
    .latar-merah{flex:1;background:#f5a3a3;}

    /* KOTAK PUTIH */
    .kotak{
      position:absolute;
      left:50%;
      top:50%;
      transform:translate(-50%,-50%);
      width:min(980px, calc(100% - 40px));
      border:2px solid #111;
      background:#fff;
    }

    /* JUDUL (GARIS BAWAH DIHAPUS) */
    .atas{
      padding:14px;
      /* border-bottom:2px solid #111;  <-- DIHAPUS sesuai permintaan */
      font-weight:900;
    }

    .tengah{padding:14px;}

    /* TABEL DESKTOP */
    table{width:100%;border-collapse:collapse;font-size:12px;}
    th, td{border:2px solid #111;padding:8px;text-align:left;}
    th{background:#fff;font-weight:900;}
    td.center{text-align:center;}

    /* TOMBOL AKSI */
    .btn-aksi{
      display:inline-flex;
      align-items:center;
      justify-content:center;
      padding:4px 8px;
      border:2px solid #111;
      border-radius:8px;
      text-decoration:none;
      color:#111;
      font-weight:900;
      background:#fff;
      cursor:pointer;
      margin:2px;
      font-size:11px;
      gap:4px;
      white-space:nowrap;
    }

    /* BAGIAN BAWAH (GARIS ATAS DIHAPUS) */
    .bawah{
      /* border-top:2px solid #111; <-- DIHAPUS sesuai permintaan */
      padding:10px 14px;
      display:flex;
      gap:10px;
      justify-content:center;
      flex-wrap:wrap;
      margin-bottom:10px;
    }
    .btn{
      border:2px solid #111;
      background:#fff;
      padding:7px 14px;
      border-radius:10px;
      font-weight:900;
      text-decoration:none;
      color:#111;
      box-shadow:0 2px 0 rgba(0,0,0,.25);
      font-size:12px;
    }

    /* =========================
       RESPONSIVE MOBILE: TABEL JADI CARD
       ========================= */
    @media(max-width:768px){
      .tengah-menu-atas{display:none;}
      .latar-biru,.latar-merah{display:none;}

      .kotak{
        position:static;
        transform:none;
        width:calc(100% - 24px);
        margin:12px auto;
        border:2px solid #111;
      }

      table, thead, tbody, th, td, tr{
        display:block;
        width:100%;
      }
      thead{display:none;}

      tr{
        border:2px solid #111;
        border-radius:12px;
        padding:10px;
        margin-bottom:10px;
        background:#fff;
      }

      td{
        border:none;
        padding:6px 0;
        display:flex;
        justify-content:space-between;
        gap:12px;
        align-items:flex-start;
      }

      td::before{
        content: attr(data-label);
        font-weight:900;
        flex:0 0 120px;
      }

      /* BARIS AKSI: label kiri, tombol rata kanan */
      td[data-label="Aksi"]{
        display:flex;
        justify-content:space-between;
        align-items:flex-start;
      }
      .aksi-kanan{
        display:flex;
        gap:8px;
        justify-content:flex-end;
        flex-wrap:wrap;
      }
       .kotak{
      border:2px solid #ffffffff;
  
    }
    }
  </style>
</head>

<body>

  <!-- MENU ATAS -->
  <div class="menu-atas">
    <div class="kiri-menu-atas">
      <img src="../gambar/mental.png" class="logo-navbar" alt="">
      <img src="../gambar/love.png" class="logo-navbar" alt="">
    </div>
    <div class="tengah-menu-atas">Sistem Pakar Diagnosa Gangguan Kesehatan Mental Pada Remaja</div>
    <div></div>
  </div>

  <div class="pembungkus-halaman">
    <div class="area-dua-warna">
      <div class="latar-biru"></div>
      <div class="latar-merah"></div>

      <div class="kotak">
        <div class="atas">RIWAYAT DIAGNOSA</div>

        <div class="tengah">
          <?php if (empty($list)): ?>
            <div style="border:2px solid #111;padding:12px;font-weight:700;background:#fff;">
              Belum ada riwayat diagnosa.
            </div>
          <?php else: ?>
            <table>
              <thead>
                <tr>
                  <th style="width:220px;">Tanggal</th>
                  <th>Nama Gangguan</th>
                  <th style="width:120px;">Persentase</th>
                  <th style="width:140px;">Kategori</th>
                  <th style="width:160px;" class="center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($list as $r): ?>
                  <tr>
                    <td data-label="Tanggal"><?= h($r['tanggal_konsultasi']) ?></td>
                    <td data-label="Nama Gangguan"><?= h($r['nama_gangguan'] ?? '-') ?></td>
                    <td data-label="Persentase"><?= h(number_format((float)$r['persentase_tertinggi'], 0)) ?>%</td>
                    <td data-label="Kategori"><?= h($r['kategori'] ?? '-') ?></td>
                    <td data-label="Aksi">
                      <div class="aksi-kanan">
                        <a class="btn-aksi" href="riwayat_detail.php?id=<?= (int)$r['id_konsultasi'] ?>">
                          ✎ Detail
                        </a>
                        <a class="btn-aksi"
                           href="riwayat.php?hapus=<?= (int)$r['id_konsultasi'] ?>"
                           onclick="return confirm('Yakin ingin menghapus riwayat ini?')">
                          🗑 Hapus
                        </a>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          <?php endif; ?>
        </div>

        <div class="bawah">
         <a class="btn" href="pertanyaan.php">MULAI TES</a>
          <a class="btn" href="../index.php">KELUAR</a>
        </div>

      </div>
    </div>
  </div>

</body>
</html>
