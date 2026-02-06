<?php
session_start();
include __DIR__ . '/../koneksi/koneksi.php';

function h($s){ return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

if (empty($_SESSION['id_pengguna'])) { header("Location: data_pengguna.php"); exit; }


$idPengguna = mysqli_real_escape_string($conn, (string)$_SESSION['id_pengguna']);
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) die("ID konsultasi tidak valid.");

// pastikan milik user
$qK = mysqli_query($conn, "SELECT id_konsultasi, tanggal_konsultasi FROM konsultasi WHERE id_konsultasi=$id AND id_pengguna='$idPengguna' LIMIT 1");
$kons = mysqli_fetch_assoc($qK);
if (!$kons) die("Data tidak ditemukan.");

// user data
$userData = ['nama_pengguna'=>'-','jenis_kelamin'=>'-','usia'=>'-','alamat'=>'-'];
$qU = mysqli_query($conn, "SELECT nama_pengguna, jenis_kelamin, usia, alamat FROM pengguna WHERE id_pengguna='$idPengguna' LIMIT 1");
if ($row = mysqli_fetch_assoc($qU)) $userData = $row;

// hasil
$hasil = [];
$qH = mysqli_query($conn, "
  SELECT c.id_gangguan, c.nilai_cf_total AS cf, c.persentase, c.kategori,
         j.nama_gangguan AS nama, j.kode_gangguan AS kode
  FROM cf_gangguan c
  JOIN jenis_gangguan j ON j.id_gangguan = c.id_gangguan
  WHERE c.id_konsultasi=$id
  ORDER BY c.nilai_cf_total DESC
");
while($r=mysqli_fetch_assoc($qH)){
  $hasil[] = [
    'id_gangguan'=>(int)$r['id_gangguan'],
    'nama'=>$r['nama'],
    'kode'=>$r['kode'],
    'cf'=>(float)$r['cf'],
    'persen'=>(float)$r['persentase'],
    'keparahan'=>$r['kategori'],
  ];
}
if(!$hasil) die("Detail hasil kosong.");

$top = $hasil[0];
$pie = max(0.0, min(100.0, (float)$top['persen']));
$tanggal = date('d / m / Y', strtotime($kons['tanggal_konsultasi']));

include __DIR__ . '/tampilan_hasil.php';

