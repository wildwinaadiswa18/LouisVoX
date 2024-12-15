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
            <?php unset($_SESSION["jawab"]); ?>
            <div class="container">
                <div class="page-inner d-flex align-items-center justify-content-center" style="min-height: 100vh;"> 
                    <div class="card w-100" style="max-width: 600px; margin-left: 20px; margin-right: 20px;">
                        <div class="card-body text-center">
                            <h4 class="fw-bold mb-3">Selamat Datang di Kuis</h4>
                            <p>
                            </p>
                            <ul class="text-start">
                                <li>Setiap soal memiliki waktu tertentu untuk dijawab.</li>
                                <li>Pastikan Anda menjawab semua soal dengan benar.</li>
                                <li>Anda tidak bisa kembali ke soal sebelumnya setelah melanjutkan.</li>
                            </ul>
                            <form action="kuisdtl.php?id=<?= $_GET['id']; ?>" method="post">
                                <button type="submit" class="btn btn-primary" name="mulai">Mulai Kuis</button>
                            </form>
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
