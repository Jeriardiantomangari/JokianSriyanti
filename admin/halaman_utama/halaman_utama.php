<?php
include '../../koneksi/sidebar.php';
include '../../koneksi/koneksi.php';

// Statistik ringkas
$totalPengguna   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM pengguna"))['total'];
$totalKonsultasi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM konsultasi"))['total'];
$totalGangguan   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM jenis_gangguan"))['total'];
$totalGejala     = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM gejala"))['total'];

// Konsultasi terbaru (ambil 5)
$qTerbaru = mysqli_query($conn, "
  SELECT k.id_konsultasi, k.tanggal_konsultasi, p.nama_pengguna,
         j.nama_gangguan, k.persentase_tertinggi, k.kategori
  FROM konsultasi k
  JOIN pengguna p ON p.id_pengguna = k.id_pengguna
  LEFT JOIN jenis_gangguan j ON j.id_gangguan = k.id_gangguan
  ORDER BY k.tanggal_konsultasi DESC
  LIMIT 5
");

// Top 7 gangguan
$qTop7 = mysqli_query($conn, "
  SELECT j.id_gangguan, j.nama_gangguan, COUNT(k.id_konsultasi) AS jumlah
  FROM jenis_gangguan j
  LEFT JOIN konsultasi k ON k.id_gangguan = j.id_gangguan
  GROUP BY j.id_gangguan, j.nama_gangguan
  ORDER BY jumlah DESC, j.nama_gangguan ASC
  LIMIT 7
");

// Siapkan data chart
$labelGangguan = [];
$jumlahGangguan = [];
$dataTop7 = [];

while($row = mysqli_fetch_assoc($qTop7)){
  $labelGangguan[] = $row['nama_gangguan'];
  $jumlahGangguan[] = (int)$row['jumlah'];
  $dataTop7[] = $row;
}
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
/* ======= Ikuti gaya acuan kamu ======= */
.konten-utama{
  margin-left:250px;
  margin-top:60px;
  padding:30px;
  min-height:calc(100vh - 60px);
  background:#ffffffff;
  font-family:Arial,sans-serif;
}

.judul-halaman{
  margin-bottom:18px;
  color:black;
  font-weight:700;
  letter-spacing:.5px;
  font-size:22px;
}

/* Kartu ringkasan */
.grid-kartu{
  display:grid;
  grid-template-columns: repeat(4, 1fr);
  gap:14px;
  margin-bottom:18px;
}

.kartu-ringkasan{
  background:white;
  border-radius:12px;
  box-shadow:0 3px 10px rgba(0,0,0,0.12);
  padding:16px;
  border-top:4px solid #b3ebf2;
}
.kartu-ringkasan .label{
  font-size:13px;
  color:#555;
  margin-bottom:8px;
}
.kartu-ringkasan .nilai{
  font-size:26px;
  font-weight:800;
  color:#111;
}

/* Kotak konten */
.kotak{
  background:white;
  border-radius:12px;
  box-shadow:0 3px 10px rgba(0,0,0,0.12);
  overflow:hidden;
  margin-bottom:14px;
}
.kotak .kepala-kotak{
  padding:12px 14px;
  background:#b3ebf2;
  font-weight:700;
  color:black;
}
.kotak .isi-kotak{
  padding:14px;
}

/* Layout chart + tabel top7 */
.grid-dua-kolom{
  display:grid;
  grid-template-columns: 1.4fr 1fr;
  gap:14px;
  align-items:start;
}

.bingkai-grafik{
  background:white;
  border-radius:12px;
  border:1px solid #e0e0e0;
  padding:12px;
  min-width: 520px; /* bantu supaya saat layar kecil bisa scroll */
}

.bingkai-tabel{
  background:white;
  border-radius:12px;
  border:1px solid #e0e0e0;
  overflow:hidden;
  min-width: 380px; /* bantu supaya saat layar kecil bisa scroll */
}

/* ===== Scroll horizontal untuk kotak gangguan ===== */
.scroll-horizontal{
  overflow-x:auto;
  -webkit-overflow-scrolling:touch;
  padding-bottom:8px;
}
.isi-scroll{
  min-width: 950px; /* lebar minimal konten dalam kotak agar bisa geser kiri-kanan */
}

/* scrollbar (opsional, biar rapi) */
.scroll-horizontal::-webkit-scrollbar{ height:8px; }
.scroll-horizontal::-webkit-scrollbar-thumb{
  background:#cfcfcf;
  border-radius:10px;
}
.scroll-horizontal::-webkit-scrollbar-track{
  background:#f5f5f5;
  border-radius:10px;
}

/* Tabel (gaya simpel, konsisten) */
.tabel-dashboard{
  width:100%;
  border-collapse:collapse;
}
.tabel-dashboard th{
  text-align:left;
  padding:12px 15px;
  font-weight:600;
  font-size:14px;
  border-bottom:1px solid #e0e0e0;
}
.tabel-dashboard td{
  padding:10px 15px;
  border-bottom:1px solid #e0e0e0;
  font-size:14px;
  color:#424242;
  word-wrap:break-word;
  overflow-wrap:break-word;
  white-space:normal;
}
.kosong{
  color:#888;
  font-style:italic;
}

/* Badge kategori */
.badge{
  padding:4px 10px;
  border-radius:999px;
  font-size:12px;
  display:inline-block;
  border:1px solid #00000022;
  color:black;
}
.badge.ringan{ background:#BFFCC6; }
.badge.sedang{ background:#FFEE93; }
.badge.berat{  background:#fcb6d0; }

/* ======= Responsif HP (<= 768px) ======= */
@media screen and (max-width: 768px){

  /* layout dasar */
  .konten-utama{
    margin-left:0;
    padding:20px;
    width:100%;
    background:#ffffff;
    text-align:left; /* ⬅️ jangan center semua */
  }

  /* yang boleh center hanya judul & kartu */
  .judul-halaman,
  .grid-kartu{
    text-align:center;
  }

  .grid-kartu{
    grid-template-columns: repeat(2, 1fr);
    gap:12px;
  }

  /* ===== Top 7: tetap tabel normal & rata kiri ===== */
  .bingkai-tabel table,
  .bingkai-tabel th,
  .bingkai-tabel td{
    text-align:left !important;
  }

  /* ===== Konsultasi Terbaru: jadi tampilan kartu ===== */
  .tabel-konsultasi,
  .tabel-konsultasi thead,
  .tabel-konsultasi tbody,
  .tabel-konsultasi th,
  .tabel-konsultasi td,
  .tabel-konsultasi tr{
    display:block;
  }

  .tabel-konsultasi thead tr{
    display:none;
  }

  .tabel-konsultasi tr{
    margin-bottom:15px;
    border-bottom:2px solid black;
    border-radius:10px;
    overflow:hidden;
    background:#ffffff;
    text-align:left;
  }

  .tabel-konsultasi td{
    text-align:right;
    padding-left:50%;
    position:relative;
    border-bottom:1px solid #000000ff;
  }

  .tabel-konsultasi td::before{
    content: attr(data-label);
    position:absolute;
    left:15px;
    width:45%;
    font-weight:600;
    text-align:left;
    color:black;
  }

}


</style>

<div class="konten-utama">
  <div class="judul-halaman">Dashboard Sistem Pakar</div>

  <!-- Kartu Ringkasan -->
  <div class="grid-kartu">
    <div class="kartu-ringkasan">
      <div class="label">Total Pengguna</div>
      <div class="nilai"><?= (int)$totalPengguna; ?></div>
    </div>
    <div class="kartu-ringkasan">
      <div class="label">Total Konsultasi</div>
      <div class="nilai"><?= (int)$totalKonsultasi; ?></div>
    </div>
    <div class="kartu-ringkasan">
      <div class="label">Total Jenis Gangguan</div>
      <div class="nilai"><?= (int)$totalGangguan; ?></div>
    </div>
    <div class="kartu-ringkasan">
      <div class="label">Total Gejala</div>
      <div class="nilai"><?= (int)$totalGejala; ?></div>
    </div>
  </div>

  <!-- Gangguan sering muncul -->
  <div class="kotak">
    <div class="kepala-kotak">Gangguan Sering Muncul </div>

    <!-- bagian ini dibuat bisa scroll kiri/kanan -->
    <div class="isi-kotak scroll-horizontal">
      <div class="isi-scroll">
        <div class="grid-dua-kolom">

          <div class="bingkai-grafik">
            <canvas id="grafikGangguan" height="140"></canvas>
          </div>

          <div class="bingkai-tabel">
            <table class="tabel-dashboard">
              <thead>
                <tr>
                  <th>Rank</th>
                  <th>Gangguan</th>
                  <th>Jumlah</th>
                </tr>
              </thead>
              <tbody>
                <?php if(count($dataTop7) === 0): ?>
                  <tr><td colspan="3" class="kosong">Belum ada data.</td></tr>
                <?php else: ?>
                  <?php $rank=1; foreach($dataTop7 as $tg): ?>
                    <tr>
                      <td><?= $rank++; ?></td>
                      <td><?= htmlspecialchars($tg['nama_gangguan']); ?></td>
                      <td><?= (int)$tg['jumlah']; ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>

  <!-- Konsultasi terbaru (di bawah) -->
  <div class="kotak">
    <div class="kepala-kotak">Konsultasi Terbaru</div>
    <div class="isi-kotak">
      <table class="tabel-dashboard tabel-konsultasi">
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Pengguna</th>
            <th>Hasil</th>
            <th>Persen</th>
            <th>Kategori</th>
          </tr>
        </thead>
        <tbody>
        <?php if(mysqli_num_rows($qTerbaru) == 0): ?>
          <tr><td colspan="5" class="kosong">Belum ada data konsultasi.</td></tr>
        <?php else: ?>
          <?php while($r = mysqli_fetch_assoc($qTerbaru)): ?>
            <tr>
              <td data-label="Tanggal"><?= htmlspecialchars($r['tanggal_konsultasi']); ?></td>
              <td data-label="Pengguna"><?= htmlspecialchars($r['nama_pengguna']); ?></td>
              <td data-label="Hasil"><?= htmlspecialchars($r['nama_gangguan'] ?? '-'); ?></td>
              <td data-label="Persen"><?= htmlspecialchars($r['persentase_tertinggi'] ?? '0'); ?>%</td>
              <td data-label="Kategori">
                <?php
                  $kat = strtolower($r['kategori'] ?? 'ringan');
                  if(!in_array($kat, ['ringan','sedang','berat'])) $kat = 'ringan';
                ?>
                <span class="badge <?= $kat; ?>"><?= htmlspecialchars($r['kategori'] ?? '-'); ?></span>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

</div>

<script>
const labelGangguan = <?= json_encode($labelGangguan, JSON_UNESCAPED_UNICODE); ?>;
const jumlahGangguan = <?= json_encode($jumlahGangguan, JSON_UNESCAPED_UNICODE); ?>;

const warna = ['#4e79a7','#f28e2b','#e15759','#76b7b2','#59a14f','#edc948','#b07aa1'];

const ctx = document.getElementById('grafikGangguan').getContext('2d');
new Chart(ctx, {
  type: 'bar',
  data: {
    labels: labelGangguan,
    datasets: [{
      label: 'Jumlah',
      data: jumlahGangguan,
      backgroundColor: labelGangguan.map((_, i) => warna[i % warna.length]),
      borderColor: labelGangguan.map((_, i) => warna[i % warna.length]),
      borderWidth: 1
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: { display: false },
      tooltip: { enabled: true }
    },
    scales: {
      y: { beginAtZero: true, ticks: { precision: 0 } },
      x: { ticks: { autoSkip: false, maxRotation: 60, minRotation: 30 } }
    }
  }
});
</script>
