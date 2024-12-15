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
        $kelas = $_SESSION['kelas'];
        $id = $_GET['kl'];
        $dk = ($conn->query("SELECT * FROM tbkelas WHERE id_kelas = '$kelas'"))->fetch_assoc();
        $tg = ($conn->query("SELECT * FROM tbtugasdtl WHERE id_tugas = '$id'"))->fetch_assoc();
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
                  <a href="<?= url("/guru/"); ?>">
                    <i class="icon-home"></i>
                  </a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="<?= url("/guru/kelas.php?kl=".$dk['id_kelas']); ?>"><?= $dk['nm_kelas']; ?></a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-home">
                  Jawaban Siswa
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
                    <div class="card-title">Jawaban Siswa <?= $tg['nm_tugas']; ?></div>
                  </div>
                  <div class="card-body">
                    <div class="col-md-12">
                    </div>
                  <table class="table table-hover">
                    <thead> 
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Nama Siswa</th>
                          <th scope="col">PDF</th>
                          <th scope="col">Nilai</th>
                          <th scope="col">Aksi</th>
                        </tr>    
                    </thead>
                    <tbody>
                    <?php
                      $query = $conn->query("SELECT * FROM tbtugasjawab ttj, tbsiswa ts WHERE ttj.id_siswa = ts.id_user AND ttj.id_tugas = '$id' ORDER BY ttj.id_siswa ASC");
                      $i = 1;
                      while($data = $query->fetch_assoc()){
                    ?>
                      <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $data['nm_siswa']; ?></td>
                        <td><a <?= ($data['dokumen'] == "")? "" : "href='".$data['dokumen']."'"; ?> target="_blank"><?= ($data['dokumen'] == "")? "Kosong" : "Ada"; ?></td>
                        <td><?= $data['nilai']; ?></td>
                        <td><button
                        type="button"
                        class="btn btn-warning"
                        id="nilai"
                        data-id="<?= $data['id_tugasjawab']; ?>"
                        data-nilai="<?= $data['nilai']; ?>">

                          Penilaian
                        </button></td>
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
    
    <!-- Custome JS  -->
    <script src="../assets/js/main.min.js"></script>

    <script>
    var SweetAlert2Demo = (function () {
        var initDemos = function () {
          $("#nilai").click(function (e) {
            var id = $(this).data('id');
            var data = $(this).data('nilai');

              swal.fire({
                  title: "Nilai Siswa",
                  html: '<br><input class="form-control" type="number" value="'+data+'" placeholder="1-100" id="hasil">',
                  showCancelButton: true,
                  confirmButtonClass: 'btn btn-success',
                  cancelButtonClass: 'btn btn-danger',
                  buttonsStyling: true,
              }).then((result) => {
                  if (result.isConfirmed) {
                      var hasil = $("#hasil").val();  
                      $.ajax({
                          url: '<?= url("/guru/do-tugas.php")?>',
                          type: 'PUT',
                          data: JSON.stringify({ idJawab: id, nilai: hasil }),
                          success: function(data, textStatus, xhr) {
                            console.log(data);
                            swal.fire({
                                title: "",
                                text: "Success",
                                icon: "success"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                          },
                          error: function(xhr, status, error) {
                              swal.fire("", "Error: " + xhr.responseText, "error");
                          }
                      });
                  }
              });
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
