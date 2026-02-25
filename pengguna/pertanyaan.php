<?php
session_start();
include __DIR__ . '/../koneksi/koneksi.php';

function h($s)
{
  return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

function clampIndex($i, $min, $max)
{
  return max($min, min($max, $i));
}

$cfChoices = [
  "0.0" => ["label" => "Tidak Yakin",  "value" => 0.0],
  "0.2" => ["label" => "Agak Yakin",   "value" => 0.2],
  "0.4" => ["label" => "Cukup Yakin",  "value" => 0.4],
  "0.8" => ["label" => "Yakin",        "value" => 0.8],
  "1.0" => ["label" => "Sangat Yakin", "value" => 1.0],
];

// RESET
$action = $_GET['action'] ?? '';
if ($action === 'reset') {
  unset($_SESSION['diag']);
  header("Location: pertanyaan.php?q=1");
  exit;
}

// CEK USER
if (empty($_SESSION['id_pengguna'])) {
  header("Location: data_pengguna.php");
  exit;
}

// AMBIL GEJALA
$gejalaList = [];
$q = mysqli_query($conn, "SELECT id_gejala, kode_gejala, nama_gejala FROM gejala ORDER BY id_gejala ASC");
while ($r = mysqli_fetch_assoc($q)) $gejalaList[] = $r;

if (!$gejalaList) {
  echo "Tabel gejala masih kosong.";
  exit;
}
$totalQ = count($gejalaList);

// SET 5 PERTANYAAN / HALAMAN
$perPage = 5;
$totalPage = (int)ceil($totalQ / $perPage);

// INIT SESSION DIAG
if (!isset($_SESSION['diag']) || !is_array($_SESSION['diag'])) {
  $_SESSION['diag'] = ['answers' => []];
}
$answers = $_SESSION['diag']['answers'] ?? [];

// PAGE
$page = isset($_GET['q']) ? (int)$_GET['q'] : 1;
$page = clampIndex($page, 1, $totalPage);

// batch pertanyaan untuk page ini
$startIndex = ($page - 1) * $perPage;
$batch = array_slice($gejalaList, $startIndex, $perPage);

// SIMPAN JAWABAN (5 sekaligus)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_answer'])) {

  $ids = $_POST['id_gejala'] ?? [];
  $cfs = $_POST['cf_user'] ?? [];

  if (is_array($ids) && is_array($cfs)) {
    foreach ($ids as $idx => $idGejala) {
      $idGejala = (int)$idGejala;
      $choiceKey = (string)($cfs[$idx] ?? '0.0');

      if ($idGejala > 0 && isset($cfChoices[$choiceKey])) {
        $answers[$idGejala] = (float)$cfChoices[$choiceKey]['value'];
      }
    }
    $_SESSION['diag']['answers'] = $answers;
  }

  $nav = $_POST['nav'] ?? 'next';
  $cur = (int)($_POST['cur_q'] ?? $page);

  if ($nav === 'prev') {
    $to = max(1, $cur - 1);
    header("Location: pertanyaan.php?q={$to}");
    exit;
  }

  $to = $cur + 1;
  if ($to > $totalPage) {
    header("Location: proses_perhitungan.php");
    exit;
  }

  header("Location: pertanyaan.php?q={$to}");
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Diagnosa</title>

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      background: #fff;
    }

    .menu-atas {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      height: 70px;
      background: #fff;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 16px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, .25);
      z-index: 100;
    }

    .kiri-menu-atas {
      display: flex;
      gap: 10px;
    }

    .logo-navbar {
      width: 45px;
      height: 45px;
      object-fit: cover;
    }

    .tengah-menu-atas {
      font-size: 20px;
      font-weight: bold;
      color: #333;
    }

    .pembungkus {
      padding-top: 70px;
      min-height: 100vh;
    }

    .instruksi {
      width: min(1060px, calc(100% - 40px));
      margin: 18px auto 14px;
      padding: 10px 16px;
      font-size: 15px;
      line-height: 1.5;
      font-weight: 600;
      color: #111;
      text-align: center;
    }

    .bagi-dua {
      position: relative;
      width: 100%;
      min-height: calc(100vh - 70px - 70px);
      display: flex;
    }

    .latar-kiri {
      flex: 0 0 70%;
      background: #b3ebf2;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }

    .latar-kanan {
      flex: 0 0 30%;
      background: #f5a3a3;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }

    .kotak-pertanyaan {
      width: min(900px, calc(100% - 40px));
      background: #fff;
      border: 1px solid #000;
      box-shadow: 0 6px 18px rgba(0, 0, 0, .35);
      padding: 22px 24px;
      border-radius: 20px;
      min-height: 420px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .isi-pertanyaan {
      overflow: auto;
      max-height: 440px;
      padding-right: 4px;
    }

    .judul-pertanyaan {
      font-weight: 800;
      font-size: 16px;
      margin-bottom: 10px;
    }

    .pilihan-radio {
      display: flex;
      gap: 14px;
      flex-wrap: wrap;
      align-items: center;
      font-size: 13px;
      margin-bottom: 10px;
    }

    .pilihan-radio label {
      display: inline-flex;
      gap: 6px;
      align-items: center;
      cursor: pointer;
      user-select: none;
    }

    .pilihan-radio input {
      transform: translateY(1px);
    }

    .baris-bawah {
      display: flex;
      justify-content: flex-end;
      align-items: flex-end;
      margin-top: 10px;
    }

    .pembungkus-navigasi {
      display: flex;
      flex-direction: column;
      align-items: flex-end;
      gap: 8px;
    }

    .progres {
      font-size: 12px;
      font-weight: 800;
      color: #111;
      display: flex;
      gap: 6px;
      align-items: center;
    }

    .baris-tombol {
      display: flex;
      gap: 10px;
      align-items: center;
    }

    .tombol {
      border: 2px solid #777;
      background: #fff;
      padding: 6px 12px;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 700;
      font-size: 12px;
      box-shadow: 0 2px 0 rgba(0, 0, 0, .25);
    }

    .tombol:disabled {
      opacity: .5;
      cursor: not-allowed;
    }

    .pembungkus-keluar {
      display: flex;
      justify-content: center;
      margin-top: 8px;
    }

    .tombol-keluar {
      border: 2px solid #7a1d1d;
      background: #e85b5b;
      color: #fff;
      padding: 6px 18px;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 800;
      font-size: 12px;
      box-shadow: 0 2px 0 rgba(0, 0, 0, .25);
      text-decoration: none;
      display: inline-block;
    }

    /* ===== PANEL KEYAKINAN (LEBIH RAPIH) ===== */
    .panel-keyakinan {
      width: min(520px, 100%);
      background: #fff;
      border: 1px solid #111;
      border-radius: 10px;
      padding: 16px;
      box-shadow: 0 2px 0 rgba(0, 0, 0, .25);
    }

    .panel-keyakinan h3 {
      text-align: center;
      font-size: 16px;
      font-weight: 900;
      margin-bottom: 10px;
    }

    .panel-keyakinan .sub {
      text-align: center;
      font-size: 12px;
      font-weight: 700;
      line-height: 1.4;
      margin-bottom: 12px;
    }

    .daftar-keyakinan {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .item-keyakinan {
      border: 2px solid #111;
      border-radius: 12px;
      padding: 10px 12px;
      background: #fff;
    }

    .kepala-keyakinan {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 6px;
    }

    .lencana-cf {
      width: 20px;
      height: 20px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border: 1px solid #111;
      border-radius: 50%;
      font-weight: 500;
    }

    /* gradasi keyakinan */
    .cf-0  { background: #ff0000ff; }
    .cf-2  { background: #ff660eff; }
    .cf-4  { background: #ffd60a; }
    .cf-8  { background: #19d3fdd1; }
    .cf-10 { background: #258efeff; }

    .judul-keyakinan {
      font-weight: 600;
      font-size: 13px;
      line-height: 1.2;
    }

    .deskripsi-keyakinan {
      margin: 0;
      font-weight: 500;
      font-size: 11px;
      line-height: 1.45;
      color: #111;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
      .tengah-menu-atas { display: none; }
      .bagi-dua { flex-direction: column; min-height: 100vh; }
      .latar-kiri, .latar-kanan { flex: 0 0 auto; min-height: auto; padding: 16px 12px; }
      .kotak-pertanyaan { width: 100%; min-height: auto; }
      .isi-pertanyaan { overflow: visible; max-height: none; }
      .judul-pertanyaan { font-size: 14px; font-weight: 700; line-height: 1.4; }
      .pilihan-radio { font-size: 12px; gap: 10px; }
      .pilihan-radio label { gap: 4px; }
      .pilihan-radio input { transform: scale(0.9); }
      .instruksi { font-size: 13px; }
      .panel-keyakinan { width: 100%; }
    }
  </style>
</head>
<body>
  <div class="menu-atas">
    <div class="kiri-menu-atas">
      <img src="../gambar/mental.png" class="logo-navbar" alt="">
      <img src="../gambar/love.png" class="logo-navbar" alt="">
    </div>
    <div class="tengah-menu-atas">
      Sistem Pakar Diagnosa Gangguan Kesehatan Mental Pada Remaja
    </div>
    <div></div>
  </div>

  <div class="pembungkus">
    <div class="instruksi">
      Silahkan jawab pertanyaan berikut berdasarkan kondisi dan perasaan anda yang dirasakan selama
      &plusmn; 2 minggu secara berturut-turut
    </div>

    <div class="bingkai">
      <div class="bagi-dua">

        <!-- KIRI: PERTANYAAN -->
        <div class="latar-kiri">
          <div class="kotak-pertanyaan">
            <div>
              <form method="post" action="pertanyaan.php?q=<?= (int)$page ?>">
                <input type="hidden" name="save_answer" value="1" />
                <input type="hidden" name="cur_q" value="<?= (int)$page ?>" />

                <div class="isi-pertanyaan">
                  <?php foreach ($batch as $i => $g):
                    $idGejalaNow = (int)$g['id_gejala'];
                    $savedValue = (string)($answers[$idGejalaNow] ?? "0.0");
                    $nomor = $startIndex + $i + 1;
                  ?>
                    <div style="margin-bottom: 14px;">
                      <div class="judul-pertanyaan">
                        <?= $nomor ?>. <?= h($g['nama_gejala']) ?>
                      </div>

                      <input type="hidden" name="id_gejala[]" value="<?= $idGejalaNow ?>" />

                      <div class="pilihan-radio">
                        <?php foreach ($cfChoices as $k => $opt): ?>
                          <label>
                            <input
                              type="radio"
                              name="cf_user[<?= $i ?>]"
                              value="<?= h($k) ?>"
                              <?= ((string)$savedValue === (string)$opt['value']) ? 'checked' : '' ?>
                              required
                            />
                            <?= h($opt['label']) ?>
                          </label>
                        <?php endforeach; ?>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>

                <div class="baris-bawah">
                  <div class="pembungkus-navigasi">
                    <div class="progres">
                      <span>&lt;</span>
                      <span><?= (int)$page ?>/<?= (int)$totalPage ?></span>
                      <span>&gt;</span>
                    </div>

                    <div class="baris-tombol">
                      <a
                        href="pertanyaan.php?action=reset"
                        class="tombol"
                        onclick="return confirm('Yakin ingin mereset semua jawaban?');"
                        style="text-decoration: none; display: inline-block;"
                      >
                        Reset
                      </a>

                      <button
                        class="tombol"
                        type="submit"
                        name="nav"
                        value="prev"
                        <?= ($page <= 1) ? 'disabled' : ''; ?>
                      >
                        Sebelumnya
                      </button>

                      <button
                        class="tombol"
                        type="submit"
                        name="nav"
                        value="next"
                      >
                        <?= ($page < $totalPage) ? "Selanjutnya" : "Lihat Hasil" ?>
                      </button>
                    </div>

                    <div class="pembungkus-keluar">
                      <a class="tombol-keluar" href="../index.php?action=reset">Keluar</a>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>

        <!-- KANAN: PANEL KEYAKINAN (LEBIH RAPIH) -->
        <div class="latar-kanan">
          <div class="panel-keyakinan">
            <h3>Keterangan Tingkat Keyakinan</h3>
            <div class="sub">
              Pilih tingkat keyakinan sesuai kondisi yang kamu rasakan.
            </div>

            <div class="daftar-keyakinan">
              <div class="item-keyakinan">
                <div class="kepala-keyakinan">
                  <div class="lencana-cf cf-0"></div>
                  <div class="judul-keyakinan">Tidak yakin / Tidak mengalami gejala</div>
                </div>
                <p class="deskripsi-keyakinan">Pengguna merasa tidak mengalami gejala sama sekali.</p>
              </div>

              <div class="item-keyakinan">
                <div class="kepala-keyakinan">
                  <div class="lencana-cf cf-2"></div>
                  <div class="judul-keyakinan">Agak yakin</div>
                </div>
                <p class="deskripsi-keyakinan">Pengguna merasa gejala sedikit muncul, tetapi masih ragu atau tidak sering terjadi.</p>
              </div>

              <div class="item-keyakinan">
                <div class="kepala-keyakinan">
                  <div class="lencana-cf cf-4"></div>
                  <div class="judul-keyakinan">Cukup yakin</div>
                </div>
                <p class="deskripsi-keyakinan">Pengguna merasa gejala cukup sering muncul, namun belum terlalu mengganggu.</p>
              </div>

              <div class="item-keyakinan">
                <div class="kepala-keyakinan">
                  <div class="lencana-cf cf-8"></div>
                  <div class="judul-keyakinan">Yakin</div>
                </div>
                <p class="deskripsi-keyakinan">Pengguna yakin benar mengalami gejala secara nyata dan cukup sering.</p>
              </div>

              <div class="item-keyakinan">
                <div class="kepala-keyakinan">
                  <div class="lencana-cf cf-10"></div>
                  <div class="judul-keyakinan">Sangat yakin / Pasti mengalami gejala</div>
                </div>
                <p class="deskripsi-keyakinan">Pengguna sangat yakin mengalami gejala tersebut.</p>
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>
  </div>
</body>
</html>