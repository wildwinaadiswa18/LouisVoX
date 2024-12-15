<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>E-Learning|Admin</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <link
      rel="icon"
      href="../assets/img/sekolah/favicon.ico"
      type="image/x-icon"
    />

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

    <!-- CSS Files -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/plugins.min.css" />
    <link rel="stylesheet" href="../assets/css/main.min.css" />
  </head>
  <body>
    <!-- read config -->
    <?php
    require '../config.php';
    if(!isset($_GET['kl'])){
      header('Location: '.url("/guru"));
    }
    ?>
    <div class="wrapper">
      <!-- menu -->
       <?php
        $menu = "kelas";
        require 'menu.php';
        if(isset($_GET['kl'])){
          $kelas = $_GET['kl'];
          $_SESSION['kelas'] = $_GET['kl'];
        }
        $id = $_GET['kl'];
        $dk = ($conn->query("SELECT * FROM tbkelas WHERE id_kelas = '$kelas'"))->fetch_assoc();
       ?>
      <!-- end menu -->

      <div class="main-panel">
        <!-- header -->
         <?php 
          require 'header.php';
         ?>
        <!-- end header -->
        <div class="container">
          <div class="page-inner">
            <div
              class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
            >
            <div class="page-header">
              <h3 class="fw-bold mb-3">Kelas</h3>
              <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                  <a href="<?= url("/guru"); ?>">
                    <i class="icon-home"></i>
                  </a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="<?= url("/guru/kelas.php?kl=".$dk['id_kelas']); ?>"><?= $dk['nm_kelas']; ?></a>
                </li>
              </ul>
            </div>
              <div class="ms-md-auto py-2 py-md-0">
               <!-- align right -->
              </div>
            </div>
            <div class="row">
           
            <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">
                      Mata Pelajaran
                      <select class="form-select" name="mapel" id="mapel">
                        <?php
                          $qdm = $conn->query("SELECT * FROM tbmapeldtl tmd, tbmapel tm WHERE tmd.id_mapel = tm.id_mapel AND tmd.id_guru = '$id_guru' AND tmd.id_kelas = '$id';");
                          $m = $qdm->num_rows;
                          $u = 0;
                          while($dtlm = $qdm->fetch_assoc()){
                          $u++;
                          $id_dtl = $dtlm['id_mapel_dtl'];
                          $qm = $conn->query("SELECT * FROM tbmateri tm WHERE tm.id_mapel_dtl = '$id_dtl'");
                          $dm = $qm->num_rows;
                          $qt = $conn->query("SELECT * FROM tbtugas tt WHERE tt.id_mapel_dtl = '$id_dtl'");
                          $dt = $qt->num_rows;
                          $qku = $conn->query("SELECT * FROM tbkuis tk WHERE tk.id_mapel_dtl = '$id_dtl'");
                          $dku = $qku->num_rows;
                        ?>
                        <option data-materi = "<?= $dm; ?>" data-tugas="<?= $dt; ?>" data-kuis="<?= $dku; ?>" value="<?= $dtlm['id_mapel_dtl']; ?>" <?= ($u == $m)? 'selected': ''; ?>><?= $dtlm['nm_mapel']; ?></option>
                        <?php
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
            </div>
            
              <div class="col-sm-6 col-md-4">
                <a class="card card-stats card-round" id="url-materi" href="<?= url("/guru/materi.php?kl=".$id_dtl); ?>">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div
                          class="icon-big text-center icon-primary bubble-shadow-small"
                        >
                        <i class="fas fa-book-reader"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Materi</p>
                         
                          <h4 class="card-title" id="materi"><?= $dm; ?></h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
              <div class="col-sm-6 col-md-4">
                <a class="card card-stats card-round" id="url-tugas" href="<?= url("/guru/tugas.php?kl=".$id_dtl); ?>">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div
                          class="icon-big text-center icon-primary bubble-shadow-small"
                        >
                        <i class="fas fa-shapes"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Tugas</p>
                          
                          <h4 class="card-title" id="tugas" ><?= $dt; ?></h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
              <div class="col-sm-6 col-md-4">
                <a class="card card-stats card-round" id="url-kuis"  href="<?= url("/guru/kuis.php?kl=".$id_dtl); ?>">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div
                          class="icon-big text-center icon-primary bubble-shadow-small"
                        >
                        <i class="fas fa-pencil-ruler"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Quiz</p>
                          
                          <h4 class="card-title" id="kuis" ><?= $dku; ?></h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
                 

              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">Data Siswa Kelas <?= $dk['nm_kelas']; ?></div>
                  </div>
                  <div class="card-body">
                    <div class="col-md-12">
                    </div>
                  <table class="table table-hover">
                    <thead> 
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Nama Siswa</th>
                        </tr>    
                    </thead>
                    <tbody>
                    <?php
                      $query = $conn->query("SELECT * FROM tbsiswa tbs WHERE tbs.id_kelas =  '$id'");
                      $i = 1;
                      while($data = $query->fetch_assoc()){
                    ?>
                      <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $data['nm_siswa']; ?></td>
                      </tr>
                    <?php
                      }
                    ?>
                    </tbody>
                  </table>
                </div>
              </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--   Core JS Files   -->
    <script src="../assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Chart JS -->
    <script src="../assets/js/plugin/chart.js/chart.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="../assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Chart Circle -->
    <script src="../assets/js/plugin/chart-circle/circles.min.js"></script>

    <!-- Datatables -->
    <script src="../assets/js/plugin/datatables/datatables.min.js"></script>

    <!-- Bootstrap Notify -->
    <script src="../assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

    <!-- jQuery Vector Maps -->
    <script src="../assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="../assets/js/plugin/jsvectormap/world.js"></script>

    <!-- Sweet Alert -->
    <script src="../assets/js/plugin/sweetalert/sweetalert2-11.js"></script>
    
    <!-- Custome JS -->
    <script src="../assets/js/main.min.js"></script>

    <script>
    var SweetAlert2Demo = (function () {
        var initDemos = function () {
            $(document).on('change', '#mapel',function (e) {   
              var id = $(this).val();
                var dataMateri = $(this).find(':selected').data('materi');
                var dataTugas = $(this).find(':selected').data('tugas');
                var dataKuis = $(this).find(':selected').data('kuis');
                $('#url-materi').attr('href', '<?= url("/guru/materi.php?kl="); ?>'+id);
                $('#url-tugas').attr('href', '<?= url("/guru/tugas.php?kl="); ?>'+id);
                $('#url-kuis').attr('href', '<?= url("/guru/kuis.php?kl="); ?>'+id);
                $('#materi').text(dataMateri);
                $('#tugas').text(dataTugas);
                $('#kuis').text(dataKuis);              
            });
        };

        return {
            init: function () {
                initDemos();
            },
        };
    })();

    jQuery(document).ready(function () {
        SweetAlert2Demo.init();
    });
    </script>
  </body>
</html>
