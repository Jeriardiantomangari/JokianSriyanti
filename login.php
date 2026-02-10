<?php
session_start();
include 'koneksi/koneksi.php';

$error = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['password'])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // TAMBAHKAN kolom foto di SELECT
    $sql  = "SELECT id, nama, username, password, foto FROM admin WHERE username = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);

        if ($res && $u = mysqli_fetch_assoc($res)) {

            // PASSWORD 
            $password_match = ($password === $u['password']); 

            if ($password_match) {
                $_SESSION['login']    = true;
                $_SESSION['id']       = $u['id'];
                $_SESSION['nama']     = $u['nama'];
                $_SESSION['username'] = $u['username'];
                $_SESSION['foto']     = $u['foto']; 

                header("Location: admin/gangguan/gangguan.php");
                exit;
            } else {
                $error = 'Password salah!';
            }
        } else {
            $error = 'Username tidak ditemukan!';
        }

        mysqli_stmt_close($stmt);
    } else {
        $error = 'Terjadi kesalahan pada server.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login Admin</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

  <style>
    * { box-sizing: border-box; 
      font-family: Inter, system-ui, Arial; }

    body { 
      margin: 0; 
      background-size: cover; }

    .wadah { 
      display: flex; 
      justify-content: center; 
      align-items: center; 
      min-height: 100vh; }

    .kartu { 
      background: #fff; 
      width: 400px; 
      padding: 24px; 
      border-radius: 14px; 
      color: #000; 
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15); }

    .gambar { 
      width: 40%; 
      max-width: 250px; 
      margin: 0 auto 20px; 
      display: block; }

    .formulir-masuk label { 
      display: block; 
      margin-top: 8px; 
      font-size: 14px; }

    .formulir-masuk input { 
      width: 100%; 
      padding: 10px; 
      border-radius: 8px; 
      border: 1px solid black; 
      margin-top: 6px; }

    .input-sandi { 
      position: relative; }

    .tombol-lihat-sandi { 
      position: absolute; 
      right: 12px; 
      top: 50%; 
      transform: translateY(-50%); 
      cursor: pointer; }

    .tombol-masuk { 
      width: 100%; 
      padding: 10px; 
      border-radius: 6px; 
      border: none; 
      margin-top: 50px; 
      background: #fff; 
      color: blue; 
      border: 1px solid black; 
      cursor: pointer; 
      font-weight: 700; }

    .alert-error { 
      background: #ffe3e3; 
      color: #c92a2a; 
      border: 1px solid #faa2a2; 
      padding: 10px; 
      border-radius: 8px; 
      margin-bottom: 12px; 
      display: flex; 
      align-items: center; 
      gap: 8px; }
  </style>
</head>

<body>
  <div class="wadah">
    <div class="kartu">
      <img src="gambar/login.png" alt="login" class="gambar" />

      <?php if (!empty($error)): ?>
        <div class="alert-error">
          <i class="fa-solid fa-circle-exclamation"></i>
          <span><?= htmlspecialchars($error) ?></span>
        </div>
      <?php endif; ?>

      <form action="" method="POST" class="formulir-masuk">
        <label><i class="fa-solid fa-user"></i> Username</label>
        <input type="text" name="username" placeholder="Masukkan username" required value="<?= htmlspecialchars($username) ?>" />

        <label><i class="fa-solid fa-key"></i> Password</label>
        <div class="input-sandi">
          <input type="password" id="sandi" name="password" placeholder="Masukkan password" required />
          <i id="tombolLihatSandi" class="fa-solid fa-eye tombol-lihat-sandi"></i>
        </div>

        <button type="submit" class="tombol-masuk">Masuk</button>
      </form>
    </div>
  </div>

  <script>
    const tombol = document.getElementById("tombolLihatSandi");
    const sandi = document.getElementById("sandi");

    tombol.addEventListener("click", () => {
      sandi.type = sandi.type === "password" ? "text" : "password";
      tombol.classList.toggle("fa-eye");
      tombol.classList.toggle("fa-eye-slash");
    });
  </script>
</body>
</html>
