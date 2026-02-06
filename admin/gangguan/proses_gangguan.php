<?php
include '../../koneksi/koneksi.php';

$aksi = $_POST['aksi'] ?? '';

if ($aksi == 'ambil') {
    $id = $_POST['id'];
    $q = mysqli_query($conn, "SELECT * FROM jenis_gangguan WHERE id_gangguan='$id'");
    echo json_encode(mysqli_fetch_assoc($q));
    exit;
}

if ($aksi == 'hapus') {
    $id = $_POST['id'];
    mysqli_query($conn, "DELETE FROM jenis_gangguan WHERE id_gangguan='$id'");
    exit;
}

// Tambah / Update
$id = $_POST['id'] ?? '';
$kode = $_POST['kode_gangguan'];  
$nama = $_POST['nama_gangguan'];
$des = $_POST['deskripsi'];

if ($id == "") {
    // Insert query with kode_gangguan
    mysqli_query($conn, "INSERT INTO jenis_gangguan (kode_gangguan, nama_gangguan, deskripsi) VALUES('$kode', '$nama', '$des')");
} else {
    // Update query with kode_gangguan
    mysqli_query($conn, "UPDATE jenis_gangguan SET kode_gangguan='$kode', nama_gangguan='$nama', deskripsi='$des' WHERE id_gangguan='$id'");
}
?>
