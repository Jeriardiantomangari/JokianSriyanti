<?php
include '../../koneksi/koneksi.php';

$aksi = $_POST['aksi'] ?? '';

if ($aksi == 'ambil') {
    $id = $_POST['id'];
    $q = mysqli_query($conn, "SELECT * FROM gejala WHERE id_gejala='$id'");
    echo json_encode(mysqli_fetch_assoc($q));
    exit;
}

if ($aksi == 'hapus') {
    $id = $_POST['id'];
    mysqli_query($conn, "DELETE FROM gejala WHERE id_gejala='$id'");
    exit;
}

// Tambah / Update
$id = $_POST['id'] ?? '';
$kode = $_POST['kode_gejala'];  // Capture the kode_gejala field
$nama = $_POST['nama_gejala'];

if ($id == "") {
    // Insert query with kode_gejala
    mysqli_query($conn, "INSERT INTO gejala (kode_gejala, nama_gejala) VALUES('$kode', '$nama')");
} else {
    // Update query with kode_gejala
    mysqli_query($conn, "UPDATE gejala SET kode_gejala='$kode', nama_gejala='$nama' WHERE id_gejala='$id'");
}
?>
