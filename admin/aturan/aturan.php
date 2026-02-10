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

.konten-utama h2{
  margin-bottom:20px;
  color:black;
  font-weight:700;
  letter-spacing:.5px;
}

.tombol{
  border:none;
  border-radius:6px;
  cursor:pointer;
  color:white;
  font-size:11px;
  transition:0.25s;
  display:inline-flex;
  align-items:center;
  gap:4px;
}
.tombol i{ font-size:12px; }
.tombol:hover{
  transform: translateY(-1px);
  box-shadow:0 2px 6px rgba(0,0,0,0.18);
}

.tombol-tambah{
  background:#FDD0B1;
  color:black;
  margin-bottom:12px;
  padding:8px 15px;
  border-radius:6px;
}
.tombol-cetak{
  background:#BFFCC6;
  color:black;
  margin-right:10px;
  padding:8px 15px;
  border-radius:6px;
}
.tombol-edit{
  background:#FFEE93;
  color:black;
  min-width:70px;
  margin-bottom:4px;
  padding:6px 10px;
  border-radius:6px;
}
.tombol-hapus{
  background:#fcb6d0;
  color:black;
  min-width:70px;
  padding:6px 10px;
  border-radius:6px;
}

.dataTables_wrapper .dataTables_filter input,
.dataTables_wrapper .dataTables_length select{
  padding:6px 10px;
  border-radius:20px;
  border:1px solid #000000ff;
  font-size:14px;
  margin-bottom:8px;
  outline:none;
}

.tabel-aturan{
  width:100%;
  border-collapse:collapse;
  background:white;
  border-radius:12px;
  overflow:hidden;
  box-shadow:0 3px 10px rgba(0,0,0,0.12);
  table-layout:fixed;
}
.tabel-aturan thead tr{ background:#b3ebf2; }

.tabel-aturan th{
  color:black;
  text-align:left;
  padding:12px 15px;
  font-weight:600;
  font-size:14px;
}
.tabel-aturan td{
  padding:10px 15px;
  border-bottom:1px solid #9e9e9eff;
  border-right:1px solid #9e9e9eff;
  font-size:14px;
  color:#424242;
  word-wrap:break-word;
  overflow-wrap:break-word;
  white-space:normal;
}
.tabel-aturan tr:nth-child(even){ background:#fffdf7; }

.kotak-modal{
  display:none;
  position:fixed;
  z-index:300;
  left:0;
  top:0;
  width:100%;
  height:100vh;
  background:rgba(0,0,0,0.55);
  justify-content:center;
  align-items:center;
}
.isi-modal{
  background:white;
  padding:25px;
  border-radius:12px;
  width:420px;
  max-width:90%;
  box-shadow:0 6px 18px rgba(0,0,0,.35);
  text-align:center;
  position:relative;
  border-top:4px solid #b3ebf2;
}

label{
  font-weight:bold;
  display:block;
  color:#333;
  text-align:left;
}

.isi-modal h3{
  margin-bottom:16px;
  color:#000;
  font-size:18px;
}

.isi-modal input,
.isi-modal select{
  width:100%;
  padding:10px;
  margin:6px 0;
  border-radius:8px;
  font-size:14px;
}
.isi-modal input:focus,
.isi-modal select:focus{ outline:none; }

.isi-modal button{
  width:100%;
  padding:10px;
  border:none;
  border-radius:8px;
  background:#b3ebf2;
  color:black;
  font-weight:600;
  cursor:pointer;
  margin-top:10px;
  letter-spacing:.5px;
}
.isi-modal button:hover{ border:1px solid black; }

.tutup-modal{
  position:absolute;
  top:10px;
  right:12px;
  cursor:pointer;
  font-size:20px;
  color:black;
}
.tutup-modal:hover{ color:black; }

@media screen and (max-width: 768px){
  .konten-utama{
    margin-left:0;
    padding:20px;
    width:100%;
    background:#ffffff;
    text-align:center;
  }
  .konten-utama h2{ text-align:center; }
  .konten-utama .tombol-cetak,
  .konten-utama .tombol-tambah{
    display:inline-block;
    margin:5px auto;
  }

  .tabel-aturan, thead, tbody, th, td, tr{ display:block; }
  thead tr{ display:none; }
  tr{
    margin-bottom:15px;
    border-bottom:2px solid black;
    border-radius:10px;
    overflow:hidden;
    background:#ffffff;
  }
  td{
    text-align:right;
    padding-left:50%;
    position:relative;
    border-right:none;
    border-bottom:1px solid #000000ff;
  }
  td::before{
    content: attr(data-label);
    position:absolute;
    left:15px;
    width:45%;
    font-weight:600;
    text-align:left;
    color:black;
  }
  .tombol-edit,
  .tombol-hapus{
    width:auto;
    padding:6px 10px;
    display:inline-flex;
    margin:3px 2px;
  }
}
</style>

<div class="konten-utama">
  <h2>Data Aturan</h2>

  <button class="tombol tombol-cetak"><i class="fa-solid fa-print"></i> Cetak</button>
  <button class="tombol tombol-tambah" onclick="tambahAturan()"><i class="fa-solid fa-plus"></i> Tambah</button>

  <table id="tabel-aturan" class="tabel-aturan">
    <thead>
      <tr>
        <th>No.</th>
        <th>Gangguan</th>
        <th>Gejala</th>
        <th>MB</th>
        <th>MD</th>
        <th>Bobot</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $no = 1;
      $q = mysqli_query($conn, "
        SELECT
          a.id_aturan,
          a.id_gangguan,
          a.id_gejala,
          a.nilai_mb,
          a.nilai_md,
          a.bobot,
          j.kode_gangguan,
          j.nama_gangguan,
          g.kode_gejala,
          g.nama_gejala
        FROM aturan a
        JOIN jenis_gangguan j ON a.id_gangguan = j.id_gangguan
        JOIN gejala g ON a.id_gejala = g.id_gejala
        ORDER BY a.id_aturan ASC
      ");

      while($row = mysqli_fetch_assoc($q)){
      ?>
      <tr>
        <td data-label="No"><?= $no++; ?></td>

        <td data-label="Gangguan">
          <?= htmlspecialchars($row['kode_gangguan']); ?> - <?= htmlspecialchars($row['nama_gangguan']); ?>
        </td>

        <td data-label="Gejala">
          <?= htmlspecialchars($row['kode_gejala']); ?> - <?= htmlspecialchars($row['nama_gejala']); ?>
        </td>

        <td data-label="MB"><?= htmlspecialchars($row['nilai_mb']); ?></td>
        <td data-label="MD"><?= htmlspecialchars($row['nilai_md']); ?></td>
        <td data-label="Bobot"><?= htmlspecialchars($row['bobot']); ?></td>

        <td data-label="Aksi">
          <button class="tombol tombol-edit" onclick="editAturan(<?= (int)$row['id_aturan']; ?>)">
            <i class="fa-solid fa-pen-to-square"></i> Edit
          </button>
          <button class="tombol tombol-hapus" onclick="hapusAturan(<?= (int)$row['id_aturan']; ?>)">
            <i class="fa-solid fa-trash"></i> Hapus
          </button>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<!-- Modal -->
<div id="modalAturan" class="kotak-modal">
  <div class="isi-modal">
    <span class="tutup-modal" onclick="tutupModal()">&times;</span>
    <h3 id="judulModal">Tambah Aturan</h3>

    <form id="formAturan">
      <input type="hidden" name="id_aturan" id="id_aturan">

      <label for="id_gangguan">Pilih Gangguan</label>
      <select name="id_gangguan" id="id_gangguan" required>
        <option value="">-- Pilih Gangguan --</option>
        <?php
        $qg = mysqli_query($conn, "SELECT * FROM jenis_gangguan ORDER BY id_gangguan ASC");
        while($g = mysqli_fetch_assoc($qg)){
          echo '<option value="'.(int)$g['id_gangguan'].'">'.
               htmlspecialchars($g['kode_gangguan']).' - '.htmlspecialchars($g['nama_gangguan']).
               '</option>';
        }
        ?>
      </select>

      <label for="id_gejala">Pilih Gejala</label>
      <select name="id_gejala" id="id_gejala" required>
        <option value="">-- Pilih Gejala --</option>
        <?php
        $qj = mysqli_query($conn, "SELECT * FROM gejala ORDER BY id_gejala ASC");
        while($gj = mysqli_fetch_assoc($qj)){
          echo '<option value="'.(int)$gj['id_gejala'].'">'.
               htmlspecialchars($gj['kode_gejala']).' - '.htmlspecialchars($gj['nama_gejala']).
               '</option>';
        }
        ?>
      </select>

      <label for="nilai_mb">Nilai MB</label>
      <input type="number" step="0.01" min="0" max="1" name="nilai_mb" id="nilai_mb" placeholder="contoh: 0.8" required>

      <label for="nilai_md">Nilai MD</label>
      <input type="number" step="0.01" min="0" max="1" name="nilai_md" id="nilai_md" placeholder="contoh: 0.2" required>

      <label for="bobot">Bobot (MB - MD)</label>
      <input type="number" step="0.01" name="bobot" id="bobot" placeholder="otomatis" readonly>

      <button type="submit" id="simpanAturan">Simpan</button>
    </form>
  </div>
</div>

<script>
// DataTables
$(document).ready(function () {
  $('#tabel-aturan').DataTable({
    "pageLength": 10,
    "lengthMenu": [5, 10, 25, 50],
    "columnDefs": [{
      "orderable": false, "targets": 6 
    }],
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
        "first": "Pertama",
        "last": "Terakhir",
        "next": "Berikutnya",
        "previous": "Sebelumnya"
      }
    }
  });
});

// === TAMBAHAN: hitung bobot otomatis (MB - MD) ===
function hitungBobot(){
  let mb = parseFloat($('#nilai_mb').val());
  let md = parseFloat($('#nilai_md').val());

  if (isNaN(mb)) mb = 0;
  if (isNaN(md)) md = 0;

  let bobot = mb - md; // bobot = MB - MD
  $('#bobot').val(parseFloat(bobot.toFixed(2)));
}

// event: setiap mb/md berubah -> bobot ikut berubah
$(document).on('input change', '#nilai_mb, #nilai_md', hitungBobot);

// Tambah
function tambahAturan(){
  $('#formAturan')[0].reset();
  $('#id_aturan').val('');
  $('#judulModal').text('Tambah Aturan');
  $('#modalAturan').css('display','flex');
  hitungBobot(); 
}

// Edit
function editAturan(id){
  $.ajax({
    url: 'proses_aturan.php',
    type: 'POST',
    dataType: 'json', 
    data: { aksi:'ambil', id:id },
    success: function(obj){
      $('#judulModal').text('Edit Aturan');
      $('#id_aturan').val(obj.id_aturan);
      $('#id_gangguan').val(obj.id_gangguan);
      $('#id_gejala').val(obj.id_gejala);
      $('#nilai_mb').val(obj.nilai_mb);
      $('#nilai_md').val(obj.nilai_md);

      hitungBobot();

      $('#modalAturan').css('display','flex');
    },
    error: function(xhr){
      // tampilkan isi response biar ketahuan masalahnya
      console.log("Response error:", xhr.responseText);
      alert("Gagal mengambil data edit. Cek Console (F12).");
    }
  });
}

// Hapus
function hapusAturan(id){
  if(confirm('Yakin hapus data?')){
    $.post('proses_aturan.php', {aksi:'hapus', id:id}, function(){
      alert('Data berhasil dihapus');
      location.reload();
    });
  }
}

function tutupModal(){ $('#modalAturan').hide(); }

// Simpan (Tambah / Edit)
$('#formAturan').submit(function(e){
  e.preventDefault();
  hitungBobot(); 
  $.post('proses_aturan.php', $(this).serialize(), function(res){
    $('#modalAturan').hide();
    alert('Data berhasil disimpan');
    location.reload();
  });
});

// Cetak PDF
$('.tombol-cetak').click(function(){
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF({ orientation:'portrait', unit:'mm', format:'a4' });
  doc.setFontSize(14);
  doc.text("Data Aturan", 105, 15, {align:"center"});
  let headers = [];
  $('#tabel-aturan thead th').each(function(index){
    if(index !== 6) headers.push($(this).text());
  });

  // ambil data, kecuali kolom Aksi
  let data = [];
  $('#tabel-aturan tbody tr').each(function(){
    let rowData = [];
    $(this).find('td').each(function(index){
      if(index !== 6) rowData.push($(this).text().trim());
    });
    data.push(rowData);
  });

  doc.autoTable({
    head:[headers],
    body:data,
    startY:20,
    theme:'grid',
    headStyles:{ fillColor:[30, 136, 229], textColor:255 },
    styles:{ fontSize:9 },
    margin:{ top:20 }
  });

  doc.save('Data_Aturan.pdf');
});
</script>
