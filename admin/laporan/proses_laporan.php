<?php
include '../../koneksi/koneksi.php';
header('Content-Type: application/json; charset=utf-8');

$aksi = $_POST['aksi'] ?? '';
if ($aksi !== 'hapus') {
  echo json_encode(['status'=>'error','message'=>'Aksi tidak valid']);
  exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if ($id <= 0) {
  echo json_encode(['status'=>'error','message'=>'ID tidak valid']);
  exit;
}

/*
  Dengan FK yang kamu punya:
  - detail_konsultasi ON DELETE CASCADE ke konsultasi
  - cf_gangguan ON DELETE CASCADE ke konsultasi
  Jadi cukup delete dari konsultasi.
*/
$stmt = mysqli_prepare($conn, "DELETE FROM konsultasi WHERE id_konsultasi = ?");
if(!$stmt){
  echo json_encode(['status'=>'error','message'=>'Prepare gagal: '.mysqli_error($conn)]);
  exit;
}
mysqli_stmt_bind_param($stmt, "i", $id);
$ok = mysqli_stmt_execute($stmt);

if($ok){
  echo json_encode(['status'=>'ok']);
} else {
  echo json_encode(['status'=>'error','message'=>'Execute gagal: '.mysqli_error($conn)]);
}
