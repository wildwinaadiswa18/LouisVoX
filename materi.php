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
    <?php require '../config.php'; ?>
    <div class="wrapper">
      <?php
        $menu = "Materi";
        require 'menu.php';
      ?>

      <div class="main-panel">
        <?php require 'header.php'; ?>
        <div class="container">
          <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
              <div class="page-header">
                <h3 class="fw-bold mb-3">Materi</h3>
              </div>
            </div>
            <div class="material-section">
              <?php
                $dtl = (isset($_GET['id'])) ? $_GET['id'] : 0;
                $qu = $conn->query("SELECT * FROM tbmateri tm, tbmateridtl tmd WHERE tm.id_materi = tmd.id_materi AND tm.id_mapel_dtl = '$dtl'");
                while($data = $qu->fetch_assoc()){
              ?>
              
              <h4><?= $data['nm_materi']; ?></h4>
              <ul class="material-list">
                <li><a href="<?= $data['dokumen']; ?>" target="_blank"><?= $data['nm_materi'] . " : " . $data['dtl_materi']; ?></a></li>
              </ul>
              <?php
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
