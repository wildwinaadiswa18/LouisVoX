<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>E-Learning</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="../assets/img/sekolah/favicon.ico" type="image/x-icon" />

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
  </head>
  <body>
    <?php require '../config.php'; ?>
    <div class="wrapper">
       <?php
        $menu = "Quiz";
        require 'menu.php';
       ?>
       
        <div class="main-panel">
            <?php require 'header.php'; ?>
            <div class="container">
                <div class="page-inner d-flex align-items-center justify-content-center" style="min-height: 100vh;"> 
                    <div class="card w-100" style="max-width: 600px; margin-left: 20px; margin-right: 20px;">
                        <div class="card-body text-center">
                            <h4 class="fw-bold mb-3">Kuis Selesai</h4>
                            <p class="mb-4">
                                Terima kasih telah menyelesaikan kuis! Berikut hasil Anda:
                            </p>
                            <?php
                            if(isset($_SESSION['jawab'])){

                              $id_kuis = $_SESSION['jawab']['id'];
                              $benar = count(array_filter($_SESSION['jawab']['soal'], function($value) {
                                  return $value === true;
                              }));
                              $dtl = ($conn->query("SELECT * FROM `tbkuisdtl` WHERE id_kuis = '$id_kuis'"))->num_rows;
                              $total = $benar * (100 / $dtl);
                              unset($_SESSION['jawab']);
                              // $conn->query("INSERT INTO `tbkuisjawab`(`id_kuis`, `id_siswa`, `nilai`) VALUES ('','[value-2]','[value-3]')");
                            }
                            ?>
                            <div class="alert alert-success" role="alert">
                                Skor Anda: <strong><?= $total; ?>/100</strong>
                            </div>
                            <p class="mb-4">
                                Anda telah menyelesaikan kuis ini dengan baik. 
                          </p>
                        </div>
                    </div>
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
