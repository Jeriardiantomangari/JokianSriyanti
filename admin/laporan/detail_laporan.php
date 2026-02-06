<?php
include '../../koneksi/sidebar.php';
include '../../koneksi/koneksi.php';

if (!function_exists('h')) {
  function h($s){
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
  }
}

/* ====== MAPPING JAWABAN USER DARI CF ====== */
if (!function_exists('jawaban_user')) {
  function jawaban_user($cf){
    $key = number_format((float)$cf, 1, '.', '');
    $map = [
      "0.0" => "Tidak Yakin",
      "0.2" => "Agak Yakin",
      "0.4" => "Cukup Yakin",
      "0.8" => "Yakin",
      "1.0" => "Sangat Yakin",
    ];
    return $map[$key] ?? ('CF ' . $key);
  }
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) { die("ID konsultasi tidak valid."); }

/* ====== HEADER: konsultasi + pengguna ====== */
$sqlHeader = "
  SELECT
    k.id_konsultasi, k.tanggal_konsultasi, k.id_gangguan, k.nilai_cf_tertinggi, k.persentase_tertinggi, k.kategori,
    p.nama_pengguna, p.jenis_kelamin, p.usia, p.alamat
  FROM konsultasi k
  JOIN pengguna p ON k.id_pengguna = p.id_pengguna
  WHERE k.id_konsultasi = ?
  LIMIT 1
";
$stmt = mysqli_prepare($conn, $sqlHeader);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$hdr = mysqli_fetch_assoc($res);
if(!$hdr){ die("Data konsultasi tidak ditemukan."); }

$userData = [
  'nama_pengguna' => $hdr['nama_pengguna'],
  'jenis_kelamin' => $hdr['jenis_kelamin'],
  'usia'          => $hdr['usia'],
  'alamat'        => $hdr['alamat'],
];

$tanggal = date('d M Y H:i', strtotime($hdr['tanggal_konsultasi']));

/* ====== HASIL: ranking dari cf_gangguan ====== */
$hasil = [];
$qRank = mysqli_prepare($conn, "
  SELECT
    c.id_gangguan,
    c.nilai_cf_total,
    c.persentase,
    c.kategori,
    j.nama_gangguan
  FROM cf_gangguan c
  JOIN jenis_gangguan j ON c.id_gangguan = j.id_gangguan
  WHERE c.id_konsultasi = ?
  ORDER BY c.nilai_cf_total DESC
");
mysqli_stmt_bind_param($qRank, "i", $id);
mysqli_stmt_execute($qRank);
$rRank = mysqli_stmt_get_result($qRank);

while($r = mysqli_fetch_assoc($rRank)){
  $hasil[] = [
    'id_gangguan' => (int)$r['id_gangguan'],
    'nama'        => $r['nama_gangguan'],
    'cf'          => (float)$r['nilai_cf_total'],
    'persen'      => (float)$r['persentase'],
    'keparahan'   => $r['kategori'],
  ];
}

/* ====== GEJALA DIPILIH ====== */
$gejalaDipilih = [];
$qGejala = mysqli_prepare($conn, "
  SELECT g.kode_gejala, g.nama_gejala, d.cf_user
  FROM detail_konsultasi d
  JOIN gejala g ON d.id_gejala = g.id_gejala
  WHERE d.id_konsultasi = ? AND d.cf_user > 0
  ORDER BY g.id_gejala ASC
");
mysqli_stmt_bind_param($qGejala, "i", $id);
mysqli_stmt_execute($qGejala);
$rGejala = mysqli_stmt_get_result($qGejala);
while($g = mysqli_fetch_assoc($rGejala)){
  $gejalaDipilih[] = $g;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Laporan Diagnosa</title>

  <!-- jsPDF + autoTable (CETAK PDF TANPA @media print) -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>

  <style>
    *{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}
    body{background:#fff;}

    /* mengikuti layout admin kamu (sidebar: margin-left 250, topbar: 60) */
    .konten-utama{
      margin-left:250px;
      margin-top:60px;
      padding:24px;
      min-height:calc(100vh - 60px);
      background:#ffffff;
    }

    /* ====== KOTAK ACUAN ====== */
    .kotak-hasil{
      width:min(980px, 100%);
      border:2px solid #111;
      background:#fff;
      margin:0 auto;
    }

    .bagian-atas{
      padding:14px;
      border-bottom:2px solid #111;
      background:#fff;
    }

    .grid-data{
      display:grid;
      grid-template-columns:1fr 1fr;
      gap:14px;
    }

    .baris-data{
      display:grid;
      grid-template-columns:140px 1fr;
      gap:10px;
      align-items:center;
      margin-bottom:10px;
    }
    .label-data{font-weight:800;font-size:13px;}
    .isi-data{
      background:#fff;
      border:2px solid #aaa;
      padding:6px 10px;
      border-radius:8px;
      font-weight:700;
      font-size:13px;
    }

    .bagian-tengah{padding:14px;background:#fff;}

    .kepala-hasil{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:10px;
      margin-bottom:10px;
      font-weight:900;
    }

    table{width:100%;border-collapse:collapse;font-size:12px;}
    th, td{border:2px solid #111;padding:6px 8px;text-align:left;}
    th{background:#fff;font-weight:900;}
    td.tengah{text-align:center;}

    .tombol-solusi{
      display:inline-flex;align-items:center;justify-content:center;
      width:28px;height:28px;border:2px solid #111;border-radius:8px;
      text-decoration:none;color:#111;font-weight:900;
      background:#fff;
      cursor:pointer;
    }

    /* blok gejala */
    .blok-gejala{
      margin-top:14px;
      border-top:2px solid #111;
      padding-top:12px;
    }
    .judul-seksi{
      font-weight:900;
      margin-bottom:8px;
      display:flex;
      justify-content:space-between;
      gap:10px;
      flex-wrap:wrap;
    }

    /* tombol bawah */
    .bagian-bawah{
      padding:10px 14px;
      display:flex;
      gap:10px;
      justify-content:center;
      flex-wrap:wrap;
      margin-top:10px;
      margin-bottom:10px;
    }
    .tombol{
      border:2px solid #111;
      background:#fff;
      padding:7px 14px;
      border-radius:10px;
      font-weight:900;
      text-decoration:none;
      color:#111;
      box-shadow:0 2px 0 rgba(0,0,0,.25);
      font-size:12px;
      cursor:pointer;
    }

    /* MODAL SOLUSI */
    .modal{
      position:fixed;
      inset:0;
      background:rgba(0,0,0,.5);
      display:none;
      align-items:center;
      justify-content:center;
      padding:16px;
      z-index:99999;
    }
    .modal.aktif{display:flex;}
    .modal-isi{
      width:min(700px, 100%);
      background:#fff;
      border:2px solid #111;
      border-radius:12px;
      overflow:hidden;
    }
    .modal-atas{
      display:flex;
      justify-content:space-between;
      align-items:center;
      padding:10px 12px;
      border-bottom:2px solid #111;
      background:#fff;
    }
    .modal-judul{font-weight:900;}
    .modal-tutup{
      border:2px solid #111;
      background:#fff;
      width:34px;height:34px;
      border-radius:10px;
      font-weight:900;
      cursor:pointer;
    }
    .modal-body{
      padding:12px;
      font-size:13px;
      line-height:1.5;
      background:#fff;
    }

    /* responsive tabel jadi card */
    @media(max-width:768px){
      .konten-utama{ margin-left:0; margin-top:60px; padding:14px; }
      .grid-data{grid-template-columns:1fr;}
      .baris-data{grid-template-columns:1fr;}

      table, thead, tbody, th, td, tr{ display:block; width:100%; }
      thead{display:none;}
      tr{
        border:2px solid #111;
        border-radius:10px;
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
      }
      td::before{
        content: attr(data-label);
        font-weight:900;
        flex:0 0 140px;
      }
      td.tengah{text-align:left;}
    }
  </style>
</head>

<body>
  <div class="konten-utama">
    <div class="kotak-hasil" id="area-cetak">

      <div class="bagian-atas">
        <div class="grid-data">
          <div>
            <div class="baris-data"><div class="label-data">Nama Pengguna</div><div class="isi-data"><?= h($userData['nama_pengguna']) ?></div></div>
            <div class="baris-data"><div class="label-data">Jenis Kelamin</div><div class="isi-data"><?= h($userData['jenis_kelamin']) ?></div></div>
            <div class="baris-data"><div class="label-data">Tanggal Diagnosa</div><div class="isi-data"><?= h($tanggal) ?></div></div>
          </div>
          <div>
            <div class="baris-data"><div class="label-data">Umur</div><div class="isi-data"><?= h($userData['usia']) ?> Tahun</div></div>
            <div class="baris-data"><div class="label-data">Alamat</div><div class="isi-data"><?= h($userData['alamat']) ?></div></div>
          </div>
        </div>
      </div>

      <div class="bagian-tengah">
        <div class="kepala-hasil">
          <div class="judul-hasil">HASIL DIAGNOSA</div>
        </div>

        <!-- TABEL HASIL -->
        <table id="tabel-hasil">
          <thead>
            <tr>
              <th>Nama Gangguan</th>
              <th style="width:90px;">Nilai CF</th>
              <th style="width:100px;">Presentase</th>
              <th style="width:150px;">Tingkat Keparahan</th>
              <th style="width:70px;" class="tengah">Solusi</th>
            </tr>
          </thead>
          <tbody>
            <?php if(count($hasil) === 0){ ?>
              <tr>
                <td data-label="Gangguan" colspan="5">Belum ada data hasil untuk konsultasi ini.</td>
              </tr>
            <?php } else { ?>
              <?php foreach ($hasil as $rowH): ?>
                <tr>
                  <td data-label="Gangguan"><?= h($rowH['nama']) ?></td>
                  <td data-label="Nilai CF"><?= h(number_format((float)$rowH['cf'], 6, '.', '')) ?></td>
                  <td data-label="Presentase"><?= h(number_format((float)$rowH['persen'], 2, '.', '')) ?>%</td>
                  <td data-label="Kategori"><?= h($rowH['keparahan']) ?></td>
                  <td data-label="Solusi" class="tengah">
                    <button
                      type="button"
                      class="tombol-solusi"
                      data-id="<?= (int)$rowH['id_gangguan'] ?>"
                      data-kategori="<?= h($rowH['keparahan']) ?>"
                      title="Lihat Solusi"
                    >✎</button>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php } ?>
          </tbody>
        </table>

        <!-- TABEL GEJALA -->
        <div class="blok-gejala">
          <div class="judul-seksi">
            <div>GEJALA YANG DIPILIH USER</div>
          </div>

          <table id="tabel-gejala">
            <thead>
              <tr>
                <th style="width:60px;">No</th>
                <th style="width:90px;">Kode</th>
                <th>Nama Gejala</th>
                <th style="width:140px;">Jawaban User</th>
                <th style="width:100px;">CF User</th>
              </tr>
            </thead>
            <tbody>
              <?php if(count($gejalaDipilih) === 0){ ?>
                <tr>
                  <td data-label="No" colspan="5">Tidak ada gejala yang dipilih.</td>
                </tr>
              <?php } else { ?>
                <?php $noG=1; foreach($gejalaDipilih as $g){ ?>
                  <tr>
                    <td data-label="No"><?= $noG++; ?></td>
                    <td data-label="Kode"><?= h($g['kode_gejala']); ?></td>
                    <td data-label="Nama Gejala"><?= h($g['nama_gejala']); ?></td>
                    <td data-label="Jawaban User"><?= h(jawaban_user($g['cf_user'])); ?></td>
                    <td data-label="CF User"><?= h(number_format((float)$g['cf_user'], 2, '.', '')); ?></td>
                  </tr>
                <?php } ?>
              <?php } ?>
            </tbody>
          </table>
        </div>

        <!-- tombol bawah -->
        <div class="bagian-bawah">
          <a class="tombol" href="laporan.php">KEMBALI</a>
          <button class="tombol" type="button" id="btn-cetak-pdf">CETAK</button>
        </div>

      </div>
    </div>
  </div>

  <!-- MODAL SOLUSI -->
  <div id="modal-solusi" class="modal" aria-hidden="true">
    <div class="modal-isi">
      <div class="modal-atas">
        <div class="modal-judul">Solusi</div>
        <button type="button" class="modal-tutup" id="tutup-modal">✕</button>
      </div>
      <div class="modal-body" id="konten-solusi">Memuat...</div>
    </div>
  </div>

<script>
  // ===== MODAL SOLUSI =====
  const modal = document.getElementById('modal-solusi');
  const konten = document.getElementById('konten-solusi');
  const btnTutup = document.getElementById('tutup-modal');

  function bukaModal(){
    modal.classList.add('aktif');
    modal.setAttribute('aria-hidden', 'false');
  }
  function tutupModal(){
    modal.classList.remove('aktif');
    modal.setAttribute('aria-hidden', 'true');
    konten.innerHTML = 'Memuat...';
  }

  btnTutup.addEventListener('click', tutupModal);
  modal.addEventListener('click', (e) => {
    if (e.target === modal) tutupModal();
  });

  document.querySelectorAll('.tombol-solusi').forEach(btn => {
    btn.addEventListener('click', async () => {
      const idGangguan = btn.getAttribute('data-id');
      const kategori = btn.getAttribute('data-kategori');

      bukaModal();
      konten.innerHTML = 'Memuat...';

      try{
        const url =
          'solusi.php?id_gangguan=' + encodeURIComponent(idGangguan) +
          '&kategori=' + encodeURIComponent(kategori) +
          '&ajax=1';

        const res = await fetch(url);
        if (!res.ok) {
          konten.innerHTML = 'Gagal memuat solusi (HTTP ' + res.status + ').';
          return;
        }

        const html = await res.text();
        konten.innerHTML = html;
      } catch (err) {
        konten.innerHTML = 'Gagal memuat solusi. Coba lagi.';
        console.error(err);
      }
    });
  });

  // ===== CETAK PDF (jsPDF + autoTable) TANPA @media print =====
  document.getElementById('btn-cetak-pdf').addEventListener('click', () => {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({ orientation:'portrait', unit:'mm', format:'a4' });

    const marginX = 12;
    let y = 14;

    // Judul
    doc.setFontSize(14);
    doc.text("Detail Laporan Diagnosa", 105, y, { align: "center" });
    y += 8;

    // Ambil isi dari box atas (urutan sesuai tampilan)
    const isi = Array.from(document.querySelectorAll('.bagian-atas .isi-data')).map(el => el.innerText.trim());
    const nama   = isi[0] || '';
    const jk     = isi[1] || '';
    const tgl    = isi[2] || '';
    const umur   = isi[3] || '';
    const alamat = isi[4] || '';

    doc.setFontSize(10);
    doc.text(`Nama Pengguna : ${nama}`, marginX, y); y += 6;
    doc.text(`Jenis Kelamin : ${jk}`, marginX, y); y += 6;
    doc.text(`Umur          : ${umur}`, marginX, y); y += 6;
    doc.text(`Alamat        : ${alamat}`, marginX, y); y += 6;
    doc.text(`Tanggal Diagnosa : ${tgl}`, marginX, y); y += 8;

    // ===== TABEL HASIL (tanpa kolom Solusi) =====
    const hasilHead = [["Nama Gangguan", "Nilai CF", "Presentase", "Tingkat Keparahan"]];
    const hasilBody = [];

    document.querySelectorAll('#tabel-hasil tbody tr').forEach(tr => {
      const tds = tr.querySelectorAll('td');
      if (tds.length < 4) return; // baris kosong/colspan

      const namaG = tds[0].innerText.trim();
      const cf    = tds[1].innerText.trim();
      const prs   = tds[2].innerText.trim();
      const kat   = tds[3].innerText.trim();

      hasilBody.push([namaG, cf, prs, kat]);
    });

    doc.autoTable({
      head: hasilHead,
      body: hasilBody.length ? hasilBody : [["-", "-", "-", "-"]],
      startY: y,
      theme: 'grid',
      styles: { fontSize: 9, cellPadding: 2 },
      headStyles: { fontStyle: 'bold' },
      margin: { left: marginX, right: marginX }
    });

    y = doc.lastAutoTable.finalY + 8;

    // ===== TABEL GEJALA =====
    const gejalaHead = [["No", "Kode", "Nama Gejala", "Jawaban User", "CF User"]];
    const gejalaBody = [];

    document.querySelectorAll('#tabel-gejala tbody tr').forEach(tr => {
      const tds = tr.querySelectorAll('td');
      if (tds.length < 5) return;

      gejalaBody.push([
        tds[0].innerText.trim(),
        tds[1].innerText.trim(),
        tds[2].innerText.trim(),
        tds[3].innerText.trim(),
        tds[4].innerText.trim()
      ]);
    });

    doc.autoTable({
      head: gejalaHead,
      body: gejalaBody.length ? gejalaBody : [["-", "-", "-", "-", "-"]],
      startY: y,
      theme: 'grid',
      styles: { fontSize: 9, cellPadding: 2 },
      headStyles: { fontStyle: 'bold' },
      margin: { left: marginX, right: marginX },
      columnStyles: {
        0: { cellWidth: 10 },
        1: { cellWidth: 20 },
        2: { cellWidth: 70 },
        3: { cellWidth: 45 },
        4: { cellWidth: 20 }
      }
    });

    const safeName = (nama || 'User').replace(/[^\w\-]+/g, '_');
    doc.save(`Detail_Laporan_Diagnosa_${safeName}.pdf`);
  });
</script>

</body>
</html>
