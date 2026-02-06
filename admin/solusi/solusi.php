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

.konten-utama h2 { 
  margin-bottom:20px; 
  color:black; 
  font-weight:700;
  letter-spacing:.5px;
}

.tombol { 
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

.tombol i { font-size:12px; }

.tombol:hover { 
  transform: translateY(-1px);
  box-shadow:0 2px 6px rgba(0,0,0,0.18);
}

.tombol-tambah { 
  background:#FDD0B1;
  color:black;
  margin-bottom:12px;
  padding:8px 15px;
  border-radius:6px;
}

.tombol-cetak { 
  background:#BFFCC6;
  color:black;
  margin-right:10px;
  padding:8px 15px;
  border-radius:6px;
}

.tombol-edit { 
  background:#FFEE93;
  color:black;
  min-width:70px;
  margin-bottom:4px;
  padding:6px 10px;
  border-radius:6px;
}

.tombol-hapus { 
  background:#fcb6d0;
  color:black;
  min-width:70px;
  padding:6px 10px;
  border-radius:6px;
}

.dataTables_wrapper .dataTables_filter input,
.dataTables_wrapper .dataTables_length select { 
  padding:6px 10px; 
  border-radius:20px; 
  border:1px solid #000000ff; 
  font-size:14px; 
  margin-bottom:8px; 
  outline:none;
}

.tabel-solusi  { 
  width:100%; 
  border-collapse:collapse; 
  background:white; 
  border-radius:12px; 
  overflow:hidden; 
  box-shadow:0 3px 10px rgba(0,0,0,0.12); 
  table-layout:fixed; 
}

.tabel-solusi thead tr { background:#b3ebf2; }

.tabel-solusi th { 
  color:black; 
  text-align:left; 
  padding:12px 15px; 
  font-weight:600;
  font-size:14px;
}

.tabel-solusi td { 
  padding:10px 15px; 
  border-bottom:1px solid #9e9e9eff; 
  border-right:1px solid #9e9e9eff; 
  font-size:14px;
  color:#424242;
  word-wrap:break-word; 
  overflow-wrap:break-word; 
  white-space:normal;
}

.tabel-solusi tr:nth-child(even){ background:#fffdf7; }

.kotak-modal { 
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

.isi-modal { 
  background:white; 
  padding:25px; 
  border-radius:12px; 
  width:450px; 
  max-width:90%; 
  box-shadow:0 6px 18px rgba(0,0,0,.35); 
  text-align:center; 
  position:relative; 
  border-top:4px solid #b3ebf2;
}

label {
  font-weight:bold;
  display:block;
  color:#333;
  text-align:left;
} 

.isi-modal h3 { 
  margin-bottom:16px; 
  color:#000;
  font-size:18px;
}

.isi-modal input,
.isi-modal select,
.isi-modal textarea { 
  width:100%; 
  padding:10px; 
  margin:6px 0; 
  border-radius:8px; 
  font-size:14px;
  border:1px solid #999;
}

.isi-modal textarea { min-height:110px; resize:vertical; }

.isi-modal input:focus,
.isi-modal select:focus,
.isi-modal textarea:focus { outline:none; }

.isi-modal button { 
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

.isi-modal button:hover { border:1px solid black; }

.tutup-modal { 
  position:absolute; 
  top:10px; 
  right:12px; 
  cursor:pointer; 
  font-size:20px; 
  color:black; 
}

@media screen and (max-width: 768px) {
  .konten-utama { margin-left:0; padding:20px; width:100%; text-align:center; }
  .konten-utama h2 { text-align:center; }

  .konten-utama .tombol-cetak,
  .konten-utama .tombol-tambah { display:inline-block; margin:5px auto; }

  .tabel-solusi, thead, tbody, th, td, tr { display:block; }
  thead tr { display:none; }

  tr {
    margin-bottom:15px;
    border-bottom:2px solid black;
    border-radius:10px;
    overflow:hidden;
    background:#ffffff;
  }

  td {
    text-align:right;
    padding-left:50%;
    position:relative;
    border-right:none;
    border-bottom:1px solid #000000ff;
  }

  td::before {
    content: attr(data-label);
    position:absolute;
    left:15px;
    width:45%;
    font-weight:600;
    text-align:left;
    color:black;
  }

  .tombol-edit, .tombol-hapus { width:auto; padding:6px 10px; display:inline-flex; margin:3px 2px; }
}
</style>

<div class="konten-utama">
  <h2>Data Solusi</h2>

  <button class="tombol tombol-cetak"><i class="fa-solid fa-print"></i> Cetak</button>
  <button class="tombol tombol-tambah" onclick="tambahSolusi()"><i class="fa-solid fa-plus"></i> Tambah</button>

  <table id="tabel-solusi" class="tabel-solusi">
    <thead>
      <tr>
        <th>No.</th>
        <th>ID Solusi</th>
        <th>Gangguan</th>
        <th>Kategori</th>
        <th>Deskripsi Solusi</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $no=1;
      $q = mysqli_query($conn,"
        SELECT s.*, j.kode_gangguan, j.nama_gangguan
        FROM solusi s
        JOIN jenis_gangguan j ON j.id_gangguan = s.id_gangguan
        ORDER BY s.id_solusi ASC
      ");
      while($row=mysqli_fetch_assoc($q)) {
      ?>
      <tr>
        <td data-label="No"><?= $no++; ?></td>
        <td data-label="ID Solusi"><?= htmlspecialchars($row['id_solusi']); ?></td>
        <td data-label="Gangguan">
          <?= htmlspecialchars($row['kode_gangguan']); ?> - <?= htmlspecialchars($row['nama_gangguan']); ?>
        </td>
        <td data-label="Kategori"><?= htmlspecialchars($row['kategori']); ?></td>
        <td data-label="Deskripsi Solusi"><?= nl2br(htmlspecialchars($row['deskripsi_solusi'])); ?></td>
        <td data-label="Aksi">
          <button class="tombol tombol-edit" onclick="editSolusi('<?= htmlspecialchars($row['id_solusi']); ?>')">
            <i class="fa-solid fa-pen-to-square"></i> Edit
          </button>
          <button class="tombol tombol-hapus" onclick="hapusSolusi('<?= htmlspecialchars($row['id_solusi']); ?>')">
            <i class="fa-solid fa-trash"></i> Hapus
          </button>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<!-- Modal -->
<div id="modalSolusi" class="kotak-modal">
  <div class="isi-modal">
    <span class="tutup-modal" onclick="tutupModal()">&times;</span>
    <h3 id="judulModal">Tambah Solusi</h3>

    <form id="formSolusi">
      <input type="hidden" name="aksi" id="aksi" value="simpan">
      <input type="hidden" name="mode" id="mode" value="tambah">

      <!-- ID Solusi -->
      <label for="id_solusi">ID Solusi</label>
      <input type="text" name="id_solusi" id="id_solusi" placeholder="Contoh: S001" maxlength="5" required>

      <!-- Gangguan -->
      <label for="id_gangguan">Gangguan</label>
      <select name="id_gangguan" id="id_gangguan" required>
        <option value="">-- Pilih Gangguan --</option>
        <?php
        $jg = mysqli_query($conn,"SELECT id_gangguan, kode_gangguan, nama_gangguan FROM jenis_gangguan ORDER BY id_gangguan ASC");
        while($g=mysqli_fetch_assoc($jg)){
          echo '<option value="'.$g['id_gangguan'].'">'.htmlspecialchars($g['kode_gangguan']).' - '.htmlspecialchars($g['nama_gangguan']).'</option>';
        }
        ?>
      </select>

      <!-- Kategori -->
      <label for="kategori">Kategori</label>
      <select name="kategori" id="kategori" required>
        <option value="">-- Pilih Kategori --</option>
        <option value="Ringan">Ringan</option>
        <option value="Sedang">Sedang</option>
        <option value="Berat">Berat</option>
      </select>

      <!-- Deskripsi -->
      <label for="deskripsi_solusi">Deskripsi Solusi</label>
      <textarea name="deskripsi_solusi" id="deskripsi_solusi" placeholder="Tulis solusi..." required></textarea>

      <button type="submit" id="btnSimpan">Simpan</button>
    </form>
  </div>
</div>

<script>
// DataTables
$(document).ready(function () {
  $('#tabel-solusi').DataTable({
    "pageLength": 10,
    "lengthMenu": [5, 10, 25, 50],
    "columnDefs": [{
      "orderable": false, "targets": 5
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

// Tambah
function tambahSolusi() {
  $('#formSolusi')[0].reset();
  $('#judulModal').text('Tambah Solusi');
  $('#mode').val('tambah');
  $('#id_solusi').prop('readonly', false);
  $('#modalSolusi').css('display','flex');
}

// Edit
function editSolusi(id) {
  $.post('proses_solusi.php', {aksi:'ambil', id:id}, function(res){
    let obj = JSON.parse(res);
    $('#judulModal').text('Edit Solusi');
    $('#mode').val('edit');

    $('#id_solusi').val(obj.id_solusi).prop('readonly', true);
    $('#id_gangguan').val(obj.id_gangguan);
    $('#kategori').val(obj.kategori);
    $('#deskripsi_solusi').val(obj.deskripsi_solusi);

    $('#modalSolusi').css('display','flex');
  });
}

// Hapus
function hapusSolusi(id){
  if(confirm('Yakin hapus data?')){
    $.post('proses_solusi.php', {aksi:'hapus', id:id}, function(r){
      alert('Data berhasil dihapus');
      location.reload();
    });
  }
}

function tutupModal(){ $('#modalSolusi').hide(); }

// Simpan (Tambah / Edit)
$('#formSolusi').submit(function(e){
  e.preventDefault();

  let payload = $(this).serialize(); // sudah ada aksi=simpan & mode
  $.post('proses_solusi.php', payload, function(res){
    let obj;
    try { obj = JSON.parse(res); } catch(e){ obj = {ok:false, msg:res}; }

    if(obj.ok){
      $('#modalSolusi').hide();
      alert(obj.msg || 'Data berhasil disimpan');
      location.reload();
    } else {
      alert(obj.msg || 'Gagal menyimpan data');
    }
  });
});

// Cetak PDF
$('.tombol-cetak').click(function(){
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF({ orientation:'portrait', unit:'mm', format:'a4' });
  doc.setFontSize(14);
  doc.text("Data Solusi", 105, 15, {align:"center"});

  // ambil header kecuali kolom Aksi
  let headers = [];
  $('#tabel-solusi thead th').each(function(index){ 
    if(index !== 5) headers.push($(this).text()); 
  });

  // ambil data kecuali kolom Aksi
  let data = [];
  $('#tabel-solusi tbody tr').each(function(){
    let rowData=[];
    $(this).find('td').each(function(index){ 
      if(index !== 5) rowData.push($(this).text().trim()); 
    });
    data.push(rowData);
  });

  doc.autoTable({
    head:[headers],
    body:data,
    startY:20,
    theme:'grid',
    styles:{fontSize:9},
    margin:{top:20}
  });

  doc.save('Data_Solusi.pdf');
});
</script>
