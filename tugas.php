<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>E-Learning</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="../assets/img/sekolah/favicon.ico" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="../assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["../assets/css/fonts.min.css"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>

    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/plugins.min.css" />
    <link rel="stylesheet" href="../assets/css/main.min.css" />

    <style>
      .material-section {
        margin-bottom: 30px;
      }

      .material-section h4 {
        border-bottom: 2px solid #007bff;
        padding-bottom: 10px;
        margin-bottom: 20px;
        font-weight: bold;
      }

      .material-list {
        list-style-type: none;
        padding-left: 0;
      }

      .material-list li {
        margin-bottom: 10px;
      }

      .material-list a {
        text-decoration: none;
        color: #007bff;
      }

      .material-list a:hover {
        text-decoration: underline;
      }
    </style>
  </head>
  <body>
    <?php require '../config.php';
    date_default_timezone_set('Asia/Jakarta');  ?>
    <div class="wrapper">
      <?php
        $menu = "Tugas";
        require 'menu.php';
      ?>

      <div class="main-panel">
        <?php require 'header.php'; ?>
        <?php
          $dtl = (isset($_GET['id'])) ? $_GET['id'] : 0;
          $nmtugas = ($conn->query("SELECT tm.nm_mapel FROM tbmapel tm, tbmapeldtl tmd WHERE tm.id_mapel = tmd.id_mapel AND tmd.id_mapel_dtl = '$dtl' LIMIT 1"))->fetch_assoc();
          var_dump($nmtugas);
        ?>
        <div class="container">
          <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
              <div class="page-header">
                <h3 class="fw-bold mb-3">Tugas <?= $nmtugas['nm_mapel']; ?></h3>
              </div>
            </div>

            <?php
              $qu = $conn->query("SELECT * FROM tbtugas tt, tbtugasdtl ttd WHERE tt.id_tugas = ttd.id_tugas AND tt.id_mapel_dtl = '$dtl'");
              
              while($data = $qu->fetch_assoc()){

                  $current_time = new DateTime();
                  $start_time = new DateTime($data['mulai']);
                  $end_time = new DateTime($data['selesai']); 
                  if($current_time >= $start_time && $current_time <= $end_time) {
                      ?>
                      <div class="material-section">
                        <h4><?= $data['nm_tugas']; ?></h4>
                        <ul class="material-list">
                          <li><a href="<?= $data['dokumen']; ?>" target="_blank"><?= $data['dtl_tugas']; ?></a></li>
                        </ul>
                        <h5>Unggah Tugas Anda</h5>
                        <form action="do-tugas.php" method="post" enctype="multipart/form-data">
                          <div class="form-group">
                            <input type="hidden" name="tugas" value="<?= $data['id_tugas']; ?>">
                            <input type="hidden" name="mapel" value="<?= $dtl; ?>">

                            <label for="file">Pilih file untuk diunggah:</label>
                            <input type="file" name="dok" id="file" class="form-control">
                          </div>
                          <button type="submit" name="submit" class="btn btn-primary mt-3">Unggah Tugas</button>
                        </form>
                      </div>
                      <?php
                  } else {
                      continue;
                  }
                }
              ?>
          </div>
        </div>
      </div>
    </div>
    <script src="../assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <script src="../assets/js/plugin/chart.js/chart.min.js"></script>
    <script src="../assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>
    <script src="../assets/js/plugin/chart-circle/circles.min.js"></script>
    <script src="../assets/js/plugin/datatables/datatables.min.js"></script>
    <script src="../assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
    <script src="../assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="../assets/js/plugin/jsvectormap/world.js"></script>
    <script src="../assets/js/plugin/sweetalert/sweetalert.min.js"></script>
    <script src="../assets/js/main.min.js"></script>
  </body>
</html>