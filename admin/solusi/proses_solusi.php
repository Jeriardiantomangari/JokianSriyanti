<?php
include '../../koneksi/koneksi.php';

$aksi = $_POST['aksi'] ?? '';

function json_out($ok, $msg, $extra = []) {
  echo json_encode(array_merge(['ok'=>$ok, 'msg'=>$msg], $extra));
  exit;
}

if ($aksi === 'ambil') {
  $id = $_POST['id'] ?? '';
  $stmt = $conn->prepare("SELECT id_solusi, id_gangguan, kategori, deskripsi_solusi FROM solusi WHERE id_solusi=?");
  $stmt->bind_param("s", $id);
  $stmt->execute();
  $res = $stmt->get_result();
  $row = $res->fetch_assoc();
  echo json_encode($row ?: []);
  exit;
}

if ($aksi === 'hapus') {
  $id = $_POST['id'] ?? '';
  $stmt = $conn->prepare("DELETE FROM solusi WHERE id_solusi=?");
  $stmt->bind_param("s", $id);
  $ok = $stmt->execute();
  if ($ok) json_out(true, "Berhasil hapus data");
  json_out(false, "Gagal hapus data: ".$conn->error);
}

if ($aksi === 'simpan') {
  $mode = $_POST['mode'] ?? 'tambah';
  $id_solusi = trim($_POST['id_solusi'] ?? '');
  $id_gangguan = (int)($_POST['id_gangguan'] ?? 0);
  $kategori = $_POST['kategori'] ?? '';
  $deskripsi = $_POST['deskripsi_solusi'] ?? '';

  if ($id_solusi === '' || $id_gangguan === 0 || $kategori === '' || trim($deskripsi) === '') {
    json_out(false, "Semua field wajib diisi.");
  }

  // validasi kategori
  $allowed = ['Ringan','Sedang','Berat'];
  if (!in_array($kategori, $allowed, true)) {
    json_out(false, "Kategori tidak valid.");
  }

  if ($mode === 'edit') {
    $stmt = $conn->prepare("UPDATE solusi SET id_gangguan=?, kategori=?, deskripsi_solusi=? WHERE id_solusi=?");
    $stmt->bind_param("isss", $id_gangguan, $kategori, $deskripsi, $id_solusi);
    $ok = $stmt->execute();
    if ($ok) json_out(true, "Berhasil update data");
    json_out(false, "Gagal update data: ".$conn->error);
  } else {
    // tambah
    $stmt = $conn->prepare("INSERT INTO solusi (id_solusi, id_gangguan, kategori, deskripsi_solusi) VALUES (?,?,?,?)");
    $stmt->bind_param("siss", $id_solusi, $id_gangguan, $kategori, $deskripsi);
    $ok = $stmt->execute();
    if ($ok) json_out(true, "Berhasil tambah data");
    json_out(false, "Gagal tambah data: ".$conn->error);
  }
}

json_out(false, "Aksi tidak dikenal.");
