<?php
session_start();
include 'koneksi.php';

// Cek sesi login
if (!isset($_SESSION['id'])) {
    echo "SESSION_EXPIRED";
    exit;
}

$id = (int)$_SESSION['id'];

// Ambil data dari form
$nama       = mysqli_real_escape_string($conn, $_POST['nama'] ?? '');
$username   = mysqli_real_escape_string($conn, $_POST['username'] ?? '');
$passLama   = $_POST['password_lama'] ?? '';
$passBaru   = $_POST['password_baru'] ?? '';
$konfirmasi = $_POST['konfirmasi_password'] ?? '';

// Ambil password lama dari database
$q = mysqli_query($conn, "SELECT password, foto FROM admin WHERE id='$id' LIMIT 1");
$data = mysqli_fetch_assoc($q);

if (!$data) {
    echo "USER_TIDAK_DITEMUKAN";
    exit;
}

$passDB   = $data['password'];
$fotoLama = $data['foto'] ?? '';

// Logika update password
if ($passBaru !== "" || $konfirmasi !== "") {

    // Password lama wajib diisi
    if ($passLama === "") {
        echo "PASSWORD_LAMA_KOSONG";
        exit;
    }

    // Cek password lama
    if ($passLama !== $passDB) {
        echo "PASSWORD_SALAH"; 
        exit;
    }

    // Cek konfirmasi
    if ($passBaru !== $konfirmasi) {
        echo "KONFIRMASI_TIDAK_SAMA";
        exit;
    }

    // Update dengan password baru
    $sql = "UPDATE admin SET 
                nama='$nama',
                username='$username',
                password='$passBaru'
            WHERE id='$id'";
} else {
    // Update tanpa mengubah password
    $sql = "UPDATE admin SET 
                nama='$nama',
                username='$username'
            WHERE id='$id'";
}

$update = mysqli_query($conn, $sql);

if (!$update) {
    echo "SQL_ERROR: " . mysqli_error($conn);
    exit;
}

// Upload foto jika ada
if (!empty($_FILES['foto']['name'])) {

    // Folder tujuan: ../foto_admin dari file ini
    $uploadDir = realpath(__DIR__ . '/../foto_admin');

    if ($uploadDir === false) {
        $uploadDir = __DIR__ . '/../foto_admin';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
    }

    $uploadDir = rtrim($uploadDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

    // Nama file baru
    $fotoBaru = time() . "_" . basename($_FILES['foto']['name']);
    $dest     = $uploadDir . $fotoBaru;

    if (move_uploaded_file($_FILES['foto']['tmp_name'], $dest)) {

        // Hapus foto lama kalau ada
        if (!empty($fotoLama)) {
            $pathLama = $uploadDir . $fotoLama;
            if (file_exists($pathLama)) {
                unlink($pathLama);
            }
        }

        // Simpan nama foto baru
        mysqli_query($conn, "UPDATE admin SET foto='$fotoBaru' WHERE id='$id'");

        // Update session foto
        $_SESSION['foto'] = $fotoBaru;
    }
}
// Update session data & kirim respon
$_SESSION['nama']     = $nama;
$_SESSION['username'] = $username;

echo "BERHASIL"; 
exit;
