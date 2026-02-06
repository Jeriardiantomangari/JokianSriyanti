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
  background: #ffffffff;
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

.tombol i {
  font-size:12px;
  
}

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
  background:  #BFFCC6;
  color:black;
  margin-right:10px;
  padding:8px 15px;
  border-radius:6px;
}

.tombol-edit { 
   background:  #FFEE93;
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

.tabel-gangguan  { 
  width:100%; 
  border-collapse:collapse; 
  background:white; 
  border-radius:12px; 
  overflow:hidden; 
  box-shadow:0 3px 10px rgba(0,0,0,0.12); 
  table-layout:fixed; 
}

.tabel-gangguan  thead tr {
 background:  #b3ebf2;
}

.tabel-gangguan  th { 
  color:black; 
  text-align:left; 
  padding:12px 15px; 
  font-weight:600;
  font-size:14px;
}

.tabel-gangguan  td { 
  padding:10px 15px; 
  border-bottom:1px solid  #9e9e9eff; 
  border-right:1px solid  #9e9e9eff; 
  font-size:14px;
  color:#424242;
  word-wrap: break-word; 
  overflow-wrap: break-word; 
  white-space: normal;
}


.tabel-gangguan tr:nth-child(even){
  background:#fffdf7;
}

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
  width:400px; 
  max-width:90%; 
  box-shadow:0 6px 18px rgba(0,0,0,.35); 
  text-align:center; 
  position:relative; 
  border-top:4px solid #b3ebf2;
}

label {
  font-weight: bold;
  display: block;
  color: #333;
  text-align:left;
} 
.isi-modal h3 { 
  margin-bottom:16px; 
  color:#black;
  font-size:18px;
}

.isi-modal input,
.isi-modal select { 
  width:100%; 
  padding:10px; 
  margin:6px 0; 
  border-radius:8px; 
  font-size:14px;
}

.isi-modal input:focus,
.isi-modal select:focus {
  outline:none;
}

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

.isi-modal button:hover { 
  border:1px solid black;
}

.tutup-modal { 
  position:absolute; 
  top:10px; 
  right:12px; 
  cursor:pointer; 
  font-size:20px; 
  color:black; 
}

.tutup-modal:hover { 
  color:black; 
}

@media screen and (max-width: 768px) {
  .konten-utama {
    margin-left: 0;
    padding: 20px;
    width: 100%;
    background: #ffffff;
    text-align: center;
  }

  .konten-utama h2 {
    text-align: center;
  }

  .konten-utama .tombol-cetak,
  .konten-utama .tombol-tambah {
    display: inline-block;
    margin: 5px auto;
  }

  .tabel-gangguan,
  thead,
  tbody,
  th,
  td,
  tr {
    display: block;
  }

  thead tr {
    display: none;
  }

  tr {
    margin-bottom: 15px;
    border-bottom: 2px solid black;
    border-radius:10px;
    overflow:hidden;
    background:#ffffff;
  }

  td {
    text-align: right;
    padding-left: 50%;
    position: relative;
    border-right:none;
    border-bottom:1px solid #000000ff;
  }

  td::before {
    content: attr(data-label);
    position: absolute;
    left: 15px;
    width: 45%;
    font-weight: 600;
    text-align: left;
    color:black;
  }

  .tombol-edit,
  .tombol-hapus {
    width: auto;
    padding: 6px 10px;
    display: inline-flex;
    margin: 3px 2px;
  }

  td[data-label="Deskripsi"]{
    text-align: left !important;
    padding-left: 15px !important;   
    padding-top: 38px !important;    
    white-space: normal !important;
    word-break: break-word !important;
    overflow-wrap: anywhere !important;
    line-height: 1.4;
  }

  td[data-label="Deskripsi"]::before{
    width: auto !important;         
    left: 15px !important;
    top: 10px !important;           
    display: block;
    position: absolute;
    white-space: nowrap !important;
  }
}
</style>

<div class="konten-utama">
  <h2>Data Gangguan</h2>

  <button class="tombol tombol-cetak"><i class="fa-solid fa-print"></i> Cetak</button>
  <button class="tombol tombol-tambah" onclick="tambahGangguan()"><i class="fa-solid fa-plus"></i> Tambah</button>

  <table id="tabel-gangguan" class="tabel-gangguan">
    <thead>
      <tr>
        <th>No.</th>
        <th>Kode Gangguan</th>
        <th>Nama Gangguan</th>
        <th>Deskripsi</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $no=1;
      $query = mysqli_query($conn,"SELECT * FROM jenis_gangguan ORDER BY id_gangguan ASC");
      while($row=mysqli_fetch_assoc($query)) {
      ?>
      <tr>
        <td data-label="No"><?= $no++; ?></td>
        <td data-label="Kode Gangguan"><?= htmlspecialchars($row['kode_gangguan']); ?></td>
        <td data-label="Nama Gangguan"><?= htmlspecialchars($row['nama_gangguan']); ?></td>
        <td data-label="Deskripsi"><?= htmlspecialchars($row['deskripsi']); ?></td>
        <td data-label="Aksi">
          <button class="tombol tombol-edit" onclick="editGangguan(<?= $row['id_gangguan']; ?>)">
            <i class="fa-solid fa-pen-to-square"></i> Edit
          </button>
          <button class="tombol tombol-hapus" onclick="hapusGangguan(<?= $row['id_gangguan']; ?>)">
            <i class="fa-solid fa-trash"></i> Hapus
          </button>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<!-- Modal -->
<div id="modalGangguan" class="kotak-modal">
  <div class="isi-modal">
    <span class="tutup-modal" onclick="tutupModal()">&times;</span>
    <h3 id="judulModal">Tambah Jenis Gangguan</h3>
    <form id="formGangguan">
      <input type="hidden" name="id" id="idGangguan">

      <!-- Kode Gangguan -->
      <label for="kode_gangguan">Kode Gangguan</label>
      <input type="text" name="kode_gangguan" id="kode_gangguan" placeholder="Kode gangguan" required>

      <!-- Nama Gangguan -->
      <label for="nama_gangguan">Nama Gangguan</label>
      <input type="text" name="nama_gangguan" id="nama_gangguan" placeholder="Nama gangguan" required>

      <!-- Deskripsi -->
      <label for="deskripsi">Deskripsi</label>
      <input type="text" name="deskripsi" id="deskripsi" placeholder="Deskripsi">

      <button type="submit" id="simpanGangguan">Simpan</button>
    </form>
  </div>
</div>


<script>
// DataTables
$(document).ready(function () {
  $('#tabel-gangguan').DataTable({
    "pageLength": 10,
    "lengthMenu": [5, 10, 25, 50],
    "columnDefs": [{
      "orderable": false, "targets": 4
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
function tambahGangguan() {
  $('#formGangguan')[0].reset();
  $('#idGangguan').val('');
  $('#judulModal').text('Tambah Jenis Gangguan');
  $('#modalGangguan').css('display','flex');
}

// Edit
function editGangguan(id) {
  $.post('proses_gangguan.php', {aksi:'ambil', id:id}, function(data){
    let obj = JSON.parse(data);
    $('#judulModal').text('Edit Jenis Gangguan');
   $('#idGangguan').val(obj.id_gangguan);
    $('#kode_gangguan').val(obj.kode_gangguan);
    $('#nama_gangguan').val(obj.nama_gangguan);
    $('#deskripsi').val(obj.deskripsi);
    $('#modalGangguan').css('display','flex');
  });
}

// Hapus
function hapusGangguan(id){
  if(confirm('Yakin hapus data?')){
    $.post('proses_gangguan.php', {aksi:'hapus', id:id}, function(){
      alert('Data berhasil dihapus');
      location.reload();
    });
  }
}

function tutupModal(){ $('#modalGangguan').hide(); }

// Simpan (Tambah / Edit)
$('#formGangguan').submit(function(e){
  e.preventDefault();
  $.post('proses_gangguan.php', $(this).serialize(), function(){
    $('#modalGangguan').hide();
    alert('Data berhasil disimpan');
    location.reload();
  });
});

// Cetak PDF
$('.tombol-cetak').click(function(){
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF({ orientation:'portrait', unit:'mm', format:'a4' });
  doc.setFontSize(14);
  doc.text("Data Gangguan", 105, 15, {align:"center"});

  let headers = [];
  $('#tabel-gangguan thead th').each(function(index){ 
    if(index !== 4) headers.push($(this).text()); 
  });

  let data = [];
  $('#tabel-gangguan tbody tr').each(function(){
    let rowData=[];
    $(this).find('td').each(function(index){ 
      if(index !== 4) rowData.push($(this).text()); 
    });
    data.push(rowData);
  });

  doc.autoTable({
    head:[headers], 
    body:data, 
    startY:20, 
    theme:'grid', 
   headStyles:{ fillColor:[30, 136, 229], textColor:255 },
    styles:{fontSize:10}, 
    margin:{top:20} 
  });

  doc.save('Data_Gangguan.pdf');
});
</script>
