<?php
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sistem Pakar - Halaman Utama</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

  <style>
    * { margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    body { background:#fff; overflow-x:hidden; }
    .menu-atas{
      position: fixed;
      top:0; left:0; right:0;
      height:70px;
      background:#fff;
      display:flex;
      align-items:center;
      justify-content:space-between;
      padding:0 16px;
      z-index:250;
      box-shadow:0 2px 8px rgba(0,0,0,.25);
    }

    .kiri-menu-atas{
      display:flex;
      align-items:center;
      gap:10px;
      min-width: 140px;
    }

    .logo-navbar{
      width:50px;
      height:50px;
      object-fit:cover;
    }

    .tengah-menu-atas{
      position:absolute;
      left:50%;
      transform:translateX(-50%);
      text-align:center;
      max-width: 820px;
      padding: 0 10px;
    }

    .teks-selamat{
      font-size:20px;
      font-weight:bold;
      color:#333;
      line-height:1.2;
    }

 
    .kanan-menu-atas{
      display:flex;
      align-items:center;
      gap:10px;
      min-width: 140px;
      justify-content: flex-end;
    }

    .btn-login-icon{
      width:46px;
      height:46px;
      border-radius:50%;
      border:1px solid #00AEEF;
      background:#fff;
      display:grid;
      place-items:center;
      cursor:pointer;
      transition:.2s ease;
      text-decoration:none;
      color:#333;
    }
    .btn-login-icon:hover{
      transform: translateY(-1px);
      box-shadow: 0 6px 16px rgba(0,0,0,.12);
    }
    .btn-login-icon i{
      font-size:20px;
    }

    /* ===== KONTEN UTAMA ===== */
    .pembungkus{
      padding-top: 90px; 
      display:flex;
      justify-content:center;
      padding-left: 14px;
      padding-right: 14px;
    }

    .bagian_utama{
      width: min(1100px, 100%);
      margin-top: 10px;
      border:1px solid #d9d9d9;
      border-radius: 10px;
      overflow:hidden;
      background:#fff;
    }

    .isi_utama{
      display:grid;
      grid-template-columns: 1fr 1fr; 
      gap: 24px;
      padding: 26px;
      background:#b3ebf2;
      min-height: 600px;
    }

    .kiri_utama h1{
      font-size: 22px;
      color:#111;
      margin-bottom: 20px;
      margin-top:80px;
      font-weight: 800;
      text-transform: uppercase;
    }

    .kiri_utama p{
      color: #1f2937;      
      font-size: 16.5px;     
      line-height: 1.5;      
      max-width: 560px;     
      margin-bottom: 50px;  
    }

    .btn-mulai{
      display:inline-block;
      padding: 10px 16px;
      background:#fff;
      color:#111;
      border-radius: 10px;
      border: 1px solid rgba(0,0,0,.2);
      text-decoration:none;
      font-weight: 800;
      transition:.2s ease;
    }
    .btn-mulai:hover{
      transform: translateY(-1px);
      box-shadow: 0 8px 18px rgba(0,0,0,.15);
    }

    .kanan_utama{
      display:flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    .gambar_utama{
      width: min(520px, 100%);
      height: 350px;             
      border-radius: 12px;
      border: 2px solid rgba(0,0,0,.25);
      background: rgba(255,255,255,.55);
      overflow: hidden;
    }

    .gambar_utama img{
      width: 100%;
      height: 100%;
      object-fit: cover;          
      object-position: center;   
      display: block;
    }

    .teks_tagline{
      font-weight: 700;
      color:#fff;
      text-shadow: 0 2px 8px rgba(0,0,0,.25);
      font-size: 15px;
      text-align:center;
    }

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {

  .menu-atas {
    height: 56px;
  }

  .logo-navbar {
    width: 32px;
    height: 32px;
  }

  .teks-selamat {
    font-size: 14px;
  }

  .btn-login-icon {
    width: 36px;
    height: 36px;
  }

  .btn-login-icon i {
    font-size: 16px;
  }

  .pembungkus {
    padding-top: 72px;
  }

  .isi_utama {
    grid-template-columns: 1fr;
    min-height: auto;
  }

  .gambar_utama {
    width: min(520px, 100%);
    aspect-ratio: 16/10;
    height: auto;
    border-radius: 12px;
    border: 2px solid rgba(0,0,0,.25);
    background: rgba(255,255,255,.75);
    overflow: hidden;
  }

  .gambar_utama img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    object-position: center;
    display: block;
  }

  .tengah-menu-atas {
    display: none; 
  }

  .kiri_utama h1 {
    margin-top: 10px;
  }
  .teks_tagline{
      font-size: 13px;
  }

}

  </style>
</head>

<body>

  <!-- NAVBAR -->
  <div class="menu-atas">
    <div class="kiri-menu-atas">
      <img src="gambar/mental.png" class="logo-navbar" alt="Logo 1">
      <img src="gambar/love.png" class="logo-navbar" alt="Logo 2">
    </div>

    <div class="tengah-menu-atas">
      <span class="teks-selamat">Sistem Pakar Diagnosa Gangguan Kesehatan Mental Pada Remaja</span>
    </div>

    <div class="kanan-menu-atas">
      <a class="btn-login-icon" href="login.php" title="Login">
        <i class="fa-solid fa-user"></i>
      </a>
    </div>
  </div>

  <!-- KONTEN -->
  <div class="pembungkus">
    <div class="bagian_utama">
      <div class="isi_utama">
        <div class="kiri_utama">
          <h1>Sistem Pakar <br> Diagnosa Gangguan Kesehatan Mental Pada Remaja</h1>

          <p>
            Kesehatan mental sama pentingnya dengan kesehatan fisik.
            Melalui website ini, kamu bisa memahami kesehatan mental dan melakukan tes sederhana
            untuk mengenali kondisi kamu.
          </p>

        <a class="btn-mulai" href="pengguna/data_pengguna.php">Mulai Sekarang</a>
        </div>

        <div class="kanan_utama">
          <div class="gambar_utama">
            <img src="gambar/gambarutama.png" alt="Logo 1">
          </div>
          <div class="teks_tagline">Menjaga Pikiran Sehat, Hidup Lebih Bahagia</div>
        </div>

      </div>
    </div>
  </div>

</body>
</html>
