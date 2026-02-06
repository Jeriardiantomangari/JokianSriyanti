<?php
include '../../koneksi/sidebar.php';
include '../../koneksi/koneksi.php';
?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>

<style>
.konten-utama {
  margin-left:250px;
  margin-top:60px;
  padding:30px;
  min-height:calc(100vh - 60px);
  background:#ffffffff;
  font-family:Arial,sans-serif;
}
.konten-utama h2{ margin-bottom:20px; color:black; font-weight:700; letter-spacing:.5px; }

.tombol{
  border:none; border-radius:6px; cursor:pointer;
  color:white; font-size:11px; transition:0.25s;
  display:inline-flex; align-items:center; gap:4px;
}
.tombol i{ font-size:12px; }
.tombol:hover{ transform: translateY(-1px); box-shadow:0 2px 6px rgba(0,0,0,0.18); }

.tombol-cetak{ background:#BFFCC6; color:black; margin-right:10px; padding:8px 15px; border-radius:6px; }
.tombol-detail{ text-decoration:none; background:#b3ebf2; color:black; min-width:80px; padding:6px 10px; border-radius:6px; margin-bottom:4px; }
.tombol-hapus{ background:#fcb6d0; color:black; min-width:80px; padding:6px 10px; border-radius:6px; }

.dataTables_wrapper .dataTables_filter input,
.dataTables_wrapper .dataTables_length select{
  padding:6px 10px; border-radius:20px; border:1px solid #000;
  font-size:14px; margin-bottom:8px; outline:none;
}

.tabel-laporan{
  width:100%; border-collapse:collapse; background:white;
  border-radius:12px; overflow:hidden;
  box-shadow:0 3px 10px rgba(0,0,0,0.12);
  table-layout:fixed;
}
.tabel-laporan thead tr{ background:#b3ebf2; }
.tabel-laporan th{
  color:black; text-align:left; padding:12px 15px;
  font-weight:600; font-size:14px;
}
.tabel-laporan td{
  padding:10px 15px;
  border-bottom:1px solid #9e9e9eff;
  border-right:1px solid #9e9e9eff;
  font-size:14px; color:#424242;
  word-wrap:break-word; overflow-wrap:break-word; white-space:normal;
}
.tabel-laporan tr:nth-child(even){ background:#fffdf7; }

@media screen and (max-width: 768px){
  .konten-utama{ margin-left:0; padding:20px; width:100%; background:#fff; text-align:center; }
  .konten-utama h2{ text-align:center; }
  .konten-utama .tombol-cetak{ display:inline-block; margin:5px auto; }

  .tabel-laporan, thead, tbody, th, td, tr{ display:block; }
  thead tr{ display:none; }
  tr{
    margin-bottom:15px; border-bottom:2px solid black;
    border-radius:10px; overflow:hidden; background:#fff;
  }
  td{
    text-align:right; padding-left:50%; position:relative;
    border-right:none; border-bottom:1px solid #000;
  }
  td::before{
    content: attr(data-label);
    position:absolute; left:15px; width:45%;
    font-weight:600; text-align:left; color:black;
  }
}
</style>

<div class="konten-utama">
  <h2>Laporan Diagnosa</h2>

  <button class="tombol tombol-cetak"><i class="fa-solid fa-print"></i> Cetak</button>

  <table id="tabel-laporan" class="tabel-laporan">
    <thead>
      <tr>
        <th>No.</th>
        <th>Nama Pengguna</th>
        <th>Jenis Kelamin</th>
        <th>Umur</th>
        <th>Alamat</th>
        <th>Tanggal Diagnosa</th>
        <th>Hasil Diagnosa</th>
        <th>Aksi</th>
      </tr>
    </thead>

    <tbody>
      <?php
      $no = 1;
      $sql = "
        SELECT
          k.id_konsultasi,
          k.tanggal_konsultasi,
          k.kategori,
          k.persentase_tertinggi,
          p.nama_pengguna,
          p.jenis_kelamin,
          p.usia,
          p.alamat,
          j.kode_gangguan,
          j.nama_gangguan
        FROM konsultasi k
        JOIN pengguna p ON k.id_pengguna = p.id_pengguna
        LEFT JOIN jenis_gangguan j ON k.id_gangguan = j.id_gangguan
        ORDER BY k.tanggal_konsultasi DESC, k.id_konsultasi DESC
      ";
      $q = mysqli_query($conn, $sql);

      while($row = mysqli_fetch_assoc($q)){
        $hasil = '-';
        if (!empty($row['nama_gangguan'])) {
          $hasil = htmlspecialchars($row['nama_gangguan']);
          if ($row['persentase_tertinggi'] !== null) {
            $hasil .= ' ('.htmlspecialchars($row['persentase_tertinggi']).'%, '.htmlspecialchars($row['kategori']).')';
          }
        }
      ?>
      <tr>
        <td data-label="No"><?= $no++; ?></td>
        <td data-label="Nama Pengguna"><?= htmlspecialchars($row['nama_pengguna']); ?></td>
        <td data-label="Jenis Kelamin"><?= htmlspecialchars($row['jenis_kelamin']); ?></td>
        <td data-label="Umur"><?= (int)$row['usia']; ?></td>
        <td data-label="Alamat"><?= htmlspecialchars($row['alamat']); ?></td>
        <td data-label="Tanggal Diagnosa"><?= htmlspecialchars($row['tanggal_konsultasi']); ?></td>
        <td data-label="Hasil Diagnosa"><?= $hasil; ?></td>

        <td data-label="Aksi">
          <a class="tombol tombol-detail" href="detail_laporan.php?id=<?= (int)$row['id_konsultasi']; ?>">
            <i class="fa-solid fa-circle-info"></i> Detail
          </a>
          <button class="tombol tombol-hapus" onclick="hapusLaporan(<?= (int)$row['id_konsultasi']; ?>)">
            <i class="fa-solid fa-trash"></i> Hapus
          </button>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<script>
$(document).ready(function () {
  $('#tabel-laporan').DataTable({
    "pageLength": 10,
    "lengthMenu": [5, 10, 25, 50],
    "columnDefs": [{ "orderable": false, "targets": 7 }],
    "language": {
      "emptyTable": "Tidak ada data tersedia",
      "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
      "infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
      "infoFiltered": "(disaring dari _MAX_ data total)",
      "lengthMenu": "Tampilkan _MENU_ data",
      "loadingRecords": "Memuat...",
      "processing": "Sedang diproses...",
      "search": "Cari:",
      "zeroRecords": "Tidak ditemukan data yang sesuai",
      "paginate": {
        "first": "Pertama", "last": "Terakhir", "next": "Berikutnya", "previous": "Sebelumnya"
      }
    }
  });
});

function hapusLaporan(id){
  if(!confirm('Yakin hapus laporan konsultasi ini? Data detail & hasil CF juga ikut terhapus.')) return;

  $.post('proses_laporan.php', { aksi:'hapus', id:id }, function(res){
    if(res && res.status === 'ok'){
      alert('Berhasil dihapus');
      location.reload();
    }else{
      alert('Gagal hapus: ' + (res && res.message ? res.message : 'unknown error'));
    }
  }, 'json').fail(function(xhr){
    console.log(xhr.responseText);
    alert('Gagal hapus. Cek Console (F12).');
  });
}

// Cetak PDF
$('.tombol-cetak').click(function(){
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF({ orientation:'portrait', unit:'mm', format:'a4' });
  doc.setFontSize(14);
  doc.text("Laporan Diagnosa", 105, 15, {align:"center"});

  // header tanpa kolom Aksi (index 7)
  let headers = [];
  $('#tabel-laporan thead th').each(function(index){
    if(index !== 7) headers.push($(this).text());
  });

  let data = [];
  $('#tabel-laporan tbody tr').each(function(){
    let rowData = [];
    $(this).find('td').each(function(index){
      if(index !== 7) rowData.push($(this).text().trim());
    });
    data.push(rowData);
  });

  doc.autoTable({
    head:[headers],
    body:data,
    startY:20,
    theme:'grid',
    headStyles:{ fillColor:[30, 136, 229], textColor:255 },
    styles:{ fontSize:8 },
    margin:{ top:20 }
  });

  doc.save('Laporan_Diagnosa.pdf');
});
</script>
