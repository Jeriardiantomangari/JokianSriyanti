<?php
if (!function_exists('h')) {
  function h($s){
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
  }
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hasil Diagnosa</title>

  <style>
    *{margin:0;
      padding:0;
      box-sizing:border-box;
      font-family:'Segoe UI',sans-serif;}

    body{
      background:#fff;}
    .menu-atas{
      position:fixed;
      top:0;
      left:0;
      right:0;
      height:70px;
      background:#fff;
      display:flex;
      align-items:center;
      justify-content:space-between;
      padding:0 16px;
      box-shadow:0 2px 8px rgba(0,0,0,.25);
      z-index:9999;
    }
    .kiri-menu-atas{
      display:flex;
      gap:10px;}
    .logo-navbar{
      width:45px;
      height:45px;
      object-fit:cover;}
    .tengah-menu-atas{
      font-size:20px;
      font-weight:bold;
      color:#333;}

    .pembungkus-halaman{
      padding-top:70px;
      min-height:100vh;
    }

    .area-dua-warna{
      position:relative;
      width:100%;
      min-height:calc(100vh - 70px);
      display:flex;
    }
    .latar-biru{flex:0 0 50%; background:#b3ebf2;}
    .latar-merah{flex:0 0 50%; background:#f5a3a3;}

    .kotak-hasil{
      position:absolute;
      left:50%;
      top:50%;
      transform:translate(-50%,-50%);
      width:min(980px, calc(100% - 40px));
      border:2px solid #111;
      background:#fff;
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
    .label-data{
      font-weight:800;
      font-size:13px;}
    .isi-data{
      background:#fff;
      border:2px solid #aaa;
      padding:6px 10px;
      border-radius:8px;
      font-weight:700;
      font-size:13px;
    }
    .bagian-tengah{
      padding:14px;
      background:#fff;}
    .kepala-hasil{
      display:flex;
      align-items:center;
      gap:10px;
      margin-bottom:10px;
      font-weight:900;
    }
    .lencana{
      display:inline-flex;
      align-items:center;
      gap:8px;
      font-weight:900;}
    .titik{
      width:14px;
      height:14px;
      border:2px solid #111;
      border-radius:50%;
      display:inline-block;}

    .grid-tengah{
      display:grid;
      grid-template-columns:1.4fr .9fr;
      gap:12px;
      align-items:start;
    }

    table{
      width:100%;
      border-collapse:collapse;
      font-size:12px;}
    th, td{
      border:2px solid #111;
      padding:6px 8px;
      text-align:left;}
    th{
      background:#fff;
      font-weight:900;}
    td.tengah{
      text-align:center;}

    .tombol-solusi{
      display:inline-flex;
      align-items:center;
      justify-content:center;
      width:28px;
      height:28px;
      border:2px solid #111;
      border-radius:8px;
      text-decoration:none;
      color:#111;
      font-weight:900;
      background:#fff;
      cursor:pointer;
    }

    .sisi-kanan{
      display:flex;
      flex-direction:column;
      gap:10px;}
    .diagram-pie{
      width:180px;
      height:180px;
      border:2px solid #111;
      border-radius:50%;
      background: conic-gradient(#b3ebf2 <?= (float)$pie ?>%, #fff 0);
      margin-left:auto;
      margin-right:auto;
    }
    .catatan{
      border:2px solid #111;
      padding:10px;
      font-size:12px;
      font-weight:700;
      line-height:1.35;
      background:#fff;
    }

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
    }

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
    .label-chart{
      padding:8px 10px;
      font-size:12px;
      font-weight:700;
      line-height:1.35;
      background:#fff;
      text-align:center;
    }

    @media(max-width:768px){
      .tengah-menu-atas{display:none;}
      .latar-biru,
      .latar-merah{display:none;}
      .kotak-hasil{
        top:16px;
        transform:translateX(-50%);
        border:none;
        box-shadow:none;
      }

      .grid-data{grid-template-columns:1fr;}
      .grid-tengah{grid-template-columns:1fr;}
      .baris-data{grid-template-columns:1fr;}

      table, thead, tbody, th, td, tr{
        display:block;
        width:100%;
      }
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
        flex:0 0 110px;
      }
      .grid-data{
        grid-template-columns: 1fr;
        gap: 0;
      }
      .grid-data > div{display: contents;}
      .baris-data{margin-bottom: 10px;}
      .bagian-atas{border-bottom: none;}
      td.tengah{text-align:left;}
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

      <!-- KOTAK PUTIH -->
      <div class="kotak-hasil">

        <div class="bagian-atas">
          <div class="grid-data">
            <div>
              <div class="baris-data"><div class="label-data">Nama Pengguna</div><div class="isi-data"><?= h((string)$userData['nama_pengguna']) ?></div></div>
              <div class="baris-data"><div class="label-data">Jenis Kelamin</div><div class="isi-data"><?= h((string)$userData['jenis_kelamin']) ?></div></div>
              <div class="baris-data"><div class="label-data">Tanggal Diagnosa</div><div class="isi-data"><?= h($tanggal) ?></div></div>
            </div>
            <div>
              <div class="baris-data"><div class="label-data">Umur</div><div class="isi-data"><?= h((string)$userData['usia']) ?> Tahun</div></div>
              <div class="baris-data"><div class="label-data">Alamat</div><div class="isi-data"><?= h((string)$userData['alamat']) ?></div></div>
            </div>
          </div>
        </div>

        <div class="bagian-tengah">
          <div class="kepala-hasil">
            <div class="judul-hasil">HASIL DIAGNOSA</div>
          </div>

          <div class="grid-tengah">
            <div>
              <table>
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
                  <?php foreach ($hasil as $rowH): ?>
                    <tr>
                      <td data-label="Gangguan"><?= h((string)$rowH['nama']) ?></td>
                      <td data-label="Nilai CF"><?= h(number_format((float)$rowH['cf'], 6, '.', '')) ?></td>
                      <td data-label="Presentase"><?= h(number_format((float)$rowH['persen'], 2, '.', '')) ?>%</td>

                      <td data-label="Kategori"><?= h((string)$rowH['keparahan']) ?></td>
                      <td data-label="Solusi" class="tengah">
                        <button
                          type="button"
                          class="tombol-solusi"
                          data-id="<?= (int)$rowH['id_gangguan'] ?>"
                          data-kategori="<?= h((string)$rowH['keparahan']) ?>"
                          title="Lihat Solusi"
                        >✎</button>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>

            <div class="sisi-kanan">
              <div class="diagram-pie"></div>

              <!-- NAMA GANGGUAN ACUAN CHART -->
              <div class="label-chart">
                <b><?= strtoupper(h((string)$top['nama'])) ?></b>
                (<?= h(number_format((float)$top['persen'], 2, '.', '')) ?>%)
              </div>

              <div class="catatan">
                Catatan: Hasil ini hanya perkiraan sistem. Untuk diagnosa pasti, konsultasikan ke tenaga profesional.
              </div>
            </div>

          </div>

          <div class="bagian-bawah">
            <a class="tombol" href="riwayat.php">LIHAT HASIL TES SEBELUMNYA</a>
           <a class="tombol" href="pertanyaan.php?action=reset">ULANGI TES</a>
            <a class="tombol" href="../index.php">KELUAR</a>
          </div>

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
      <div class="modal-body" id="konten-solusi">
        Memuat...
      </div>
    </div>
  </div>

<script>
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
</script>

</body>
</html>
