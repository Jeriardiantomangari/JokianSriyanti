<?php
include '../../koneksi/koneksi.php';

$aksi = isset($_POST['aksi']) ? $_POST['aksi'] : '';

// =========================
// 1) AMBIL DATA (UNTUK EDIT)
// =========================
if ($aksi === 'ambil') {
    $id = (int)($_POST['id'] ?? 0);

    $q = mysqli_query($conn, "SELECT * FROM aturan WHERE id_aturan = $id LIMIT 1");
    $row = mysqli_fetch_assoc($q);

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($row);
    exit;
}

// =========================
// 2) HAPUS DATA
// =========================
if ($aksi === 'hapus') {
    $id = (int)($_POST['id'] ?? 0);

    mysqli_query($conn, "DELETE FROM aturan WHERE id_aturan = $id");
    echo "ok";
    exit;
}

// =========================
// 3) SIMPAN (INSERT / UPDATE)
// =========================
$id_aturan   = trim($_POST['id_aturan'] ?? '');
$id_gangguan = (int)($_POST['id_gangguan'] ?? 0);
$id_gejala   = (int)($_POST['id_gejala'] ?? 0);

$nilai_mb = (float)($_POST['nilai_mb'] ?? 0);
$nilai_md = (float)($_POST['nilai_md'] ?? 0);

// bobot dihitung otomatis (MB - MD)
$bobot = round($nilai_mb - $nilai_md, 2);

// validasi dasar
if ($id_gangguan <= 0 || $id_gejala <= 0) {
    http_response_code(400);
    echo "Gangguan/Gejala belum dipilih";
    exit;
}

// (opsional) batasi MB/MD 0..1
if ($nilai_mb < 0) $nilai_mb = 0;
if ($nilai_mb > 1) $nilai_mb = 1;
if ($nilai_md < 0) $nilai_md = 0;
if ($nilai_md > 1) $nilai_md = 1;

// (opsional) jika mau bobot tidak negatif:
// if ($bobot < 0) $bobot = 0;

if ($id_aturan === '') {
    // INSERT
    $sql = "INSERT INTO aturan (id_gangguan, id_gejala, nilai_mb, nilai_md, bobot)
            VALUES ($id_gangguan, $id_gejala, $nilai_mb, $nilai_md, $bobot)";
    $ok = mysqli_query($conn, $sql);

    if (!$ok) {
        http_response_code(500);
        echo "Gagal insert: " . mysqli_error($conn);
        exit;
    }

    echo "ok";
    exit;
} else {
    // UPDATE
    $id = (int)$id_aturan;

    $sql = "UPDATE aturan
            SET id_gangguan = $id_gangguan,
                id_gejala   = $id_gejala,
                nilai_mb    = $nilai_mb,
                nilai_md    = $nilai_md,
                bobot       = $bobot
            WHERE id_aturan = $id";

    $ok = mysqli_query($conn, $sql);

    if (!$ok) {
        http_response_code(500);
        echo "Gagal update: " . mysqli_error($conn);
        exit;
    }

    echo "ok";
    exit;
}
