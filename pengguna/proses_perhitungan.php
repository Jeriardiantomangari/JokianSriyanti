<?php
session_start();
include __DIR__ . '/../koneksi/koneksi.php';

function h($s){ return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
function kategoriKeparahan($persen){
  if ($persen >= 70) return "Berat";
  if ($persen >= 40) return "Sedang";
  return "Ringan";
}
function combineCFPositif($cf1, $cf2){
  return $cf1 + $cf2 * (1 - $cf1);
}

if (empty($_SESSION['id_pengguna'])) { header("Location: data_pengguna.php"); exit; }

$answers = $_SESSION['diag']['answers'] ?? [];
if (empty($answers)) { header("Location: pertanyaan.php?q=1"); exit; }

$idPengguna = mysqli_real_escape_string($conn, (string)$_SESSION['id_pengguna']);

$userData = ['nama_pengguna'=>'-','jenis_kelamin'=>'-','usia'=>'-','alamat'=>'-'];
$qU = mysqli_query($conn, "SELECT nama_pengguna, jenis_kelamin, usia, alamat FROM pengguna WHERE id_pengguna='$idPengguna' LIMIT 1");
if ($row = mysqli_fetch_assoc($qU)) $userData = $row;

// RULES
$rules = [];
$qR = mysqli_query($conn, "
  SELECT a.id_gangguan, a.id_gejala, a.bobot AS cf_pakar, j.nama_gangguan, j.kode_gangguan
  FROM aturan a
  JOIN jenis_gangguan j ON j.id_gangguan = a.id_gangguan
");
while($r = mysqli_fetch_assoc($qR)) $rules[] = $r;

// HITUNG
$perGangguan = [];
foreach($rules as $r){
  $gid = (int)$r['id_gangguan'];
  $sid = (int)$r['id_gejala'];
  $cfPakar = (float)$r['cf_pakar'];
  $cfUser  = (float)($answers[$sid] ?? 0.0);

  if (!isset($perGangguan[$gid])) {
    $perGangguan[$gid] = [
      'id_gangguan'=>$gid,
      'nama'=>$r['nama_gangguan'],
      'kode'=>$r['kode_gangguan'],
      'cf_list'=>[]
    ];
  }

  if ($cfUser > 0) $perGangguan[$gid]['cf_list'][] = $cfPakar * $cfUser;
}

$hasil = [];
foreach($perGangguan as $g){
  $list = $g['cf_list'];

  if (!$list) $cfTotal = 0.0;
  else{
    $cfTotal = (float)array_shift($list);
    foreach($list as $cf){
      $cfTotal = combineCFPositif($cfTotal, (float)$cf);
    }
  }

  $cfTotal = max(0.0, min(1.0, $cfTotal));
  $persen = $cfTotal * 100;


  $hasil[] = [
    'id_gangguan'=>$g['id_gangguan'],
    'nama'=>$g['nama'],
    'kode'=>$g['kode'],
    'cf'=>$cfTotal,
    'persen'=>$persen,
    'keparahan'=>kategoriKeparahan($persen),
  ];
}

usort($hasil, fn($a,$b) => $b['cf'] <=> $a['cf']);
$top = $hasil[0] ?? ['id_gangguan'=>0,'nama'=>'-','cf'=>0.0,'persen'=>0.0,'keparahan'=>'Ringan'];

// SIMPAN DB (ANTI REFRESH)
if (empty($_SESSION['diag']['saved_konsultasi_id'])) {
  mysqli_begin_transaction($conn);
  try {
    mysqli_query($conn, "INSERT INTO konsultasi (id_pengguna, tanggal_konsultasi) VALUES ('$idPengguna', NOW())");
    $idKonsultasi = (int)mysqli_insert_id($conn);

    foreach($answers as $idGejala => $cfUser){
      $idGejala = (int)$idGejala;
      $cfUser = (float)$cfUser;
      mysqli_query($conn, "
        INSERT INTO detail_konsultasi (id_konsultasi, id_gejala, cf_user)
        VALUES ($idKonsultasi, $idGejala, $cfUser)
        ON DUPLICATE KEY UPDATE cf_user=VALUES(cf_user)
      ");
    }

    foreach($hasil as $rowH){
      $gid = (int)$rowH['id_gangguan'];
      $cf  = (float)$rowH['cf'];
      $prs = (float)$rowH['persen'];
      $kat = mysqli_real_escape_string($conn, (string)$rowH['keparahan']);

      mysqli_query($conn, "
        INSERT INTO cf_gangguan (id_konsultasi, id_gangguan, nilai_cf_total, persentase, kategori)
        VALUES ($idKonsultasi, $gid, $cf, $prs, '$kat')
        ON DUPLICATE KEY UPDATE nilai_cf_total=VALUES(nilai_cf_total), persentase=VALUES(persentase), kategori=VALUES(kategori)
      ");
    }

    $topG = (int)$top['id_gangguan'];
    $topCf = (float)$top['cf'];
    $topPr = (float)$top['persen'];
    $topKat = mysqli_real_escape_string($conn, (string)$top['keparahan']);

    mysqli_query($conn, "
      UPDATE konsultasi
      SET id_gangguan=$topG, nilai_cf_tertinggi=$topCf, persentase_tertinggi=$topPr, kategori='$topKat'
      WHERE id_konsultasi=$idKonsultasi
    ");

    mysqli_commit($conn);
    $_SESSION['diag']['saved_konsultasi_id'] = $idKonsultasi;
  } catch (Throwable $e) {
    mysqli_rollback($conn);
    die("Gagal simpan hasil: " . h($e->getMessage()));
  }
}

$pie = max(0.0, min(100.0, (float)$top['persen']));
$tanggal = date('d / m / Y');

include __DIR__ . '/tampilan_hasil.php';

