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

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="../assets/css/demo.css" />
  </head>
  <body>
    <!-- read config -->
    <?php
    require '../config.php';
    if(!isset($_GET['id'])){
      header('Location: '.url("/admin/mata-pelajaran.php?ta=0"));
    }
    $id = $_GET['id'];
    $dm = ($conn->query("SELECT * FROM tbmapel WHERE id_mapel = '$id'"))->fetch_assoc();
    ?>
    <div class="wrapper">
      <!-- menu -->
       <?php
        $menu = "guru";
        require 'menu.php';

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
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
              <div class="page-header">
                <h3 class="fw-bold mb-3">Penugasan Guru</h3>
                <ul class="breadcrumbs mb-3">
                  <li class="nav-home">
                    <a href="<?= url("/admin"); ?>">
                      <i class="icon-home"></i>
                    </a>
                  </li>
                  <li class="separator">
                    <i class="icon-arrow-right"></i>
                  </li>
                  <li class="nav-item">
                    <?= tahun_ajar($dm['tahun_ajaran']); ?>
                  </li>
                  <li class="separator">
                    <i class="icon-arrow-right"></i>
                  </li>
                  <li class="nav-item">
                  <?= $dm['nm_mapel']; ?>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
                  <div class="card card-round">
                    <div class="card-header">
                      <div class="card-head-row card-tools-still-right">
                        <?php
                          if(!isset($_GET['dtl'])){
                        ?>
                        <h4 class="card-title">Form Penugasan Guru</h4>
                        <?php
                          }else{
                        ?>
                        <h4 class="card-tools">
                          Form Edit Penugasan Guru
                        </h4>
                        <?php
                          }
                        ?>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-6">
                        <?php
                          if(!isset($_GET['dtl'])){
                            $ta = $dm['tahun_ajaran'];
                        ?>
                          <form action="do-mapel-guru.php" method="POST" class="form-group" >
                            <input type="hidden" name="id_mapel" value="<?= $_GET['id']; ?>">
                            <label>Nama Guru</label>
                            <select class="form-select" name="id_guru">
                              <?php
                              $qdg = $conn->query("SELECT * FROM tbguru;");
                              while($dg = $qdg->fetch_assoc()){
                              ?>
                              <option value="<?= $dg['id_user']; ?>"><?= $dg['nm_guru']; ?></option>
                              <?php
                                }
                              ?>
                            </select>
                            <label>Kelas</label>
                            <select class="form-select" name="id_kelas">
                              <?php
                              $qdk = $conn->query("SELECT * FROM tbkelas;");
                              while($dk = $qdk->fetch_assoc()){
                              ?>
                              <option value="<?= $dk['id_kelas']; ?>"><?= $dk['nm_kelas']; ?></option>
                              <?php
                                }
                              ?>
                            </select>
                            <br>
                            <button type="submit" class="form-control btn btn-primary"> Submit</button>
                          </form>
                        <?php
                          }
                        ?>
                        </div>
                        <div class="col-md-6">
                          <?php
                          if(isset($_GET['dtl'])){
                            $id = $_GET['id'];
                            $dtl = $_GET['dtl'];
                            $ta = $dm['tahun_ajaran'];
                            $raw = ($conn->query("SELECT * FROM tbmapeldtl tmd, tbkelas tk, tbguru tg WHERE tg.id_user = tmd.id_guru AND tk.id_kelas = tmd.id_kelas AND tmd.id_mapel_dtl = '$dtl'"))->fetch_assoc();
                          ?>
                          <form action="do-mapel-guru.php" method="POST" class="form-group" >
                            <input type="hidden" name="PUT" value="<?= $dtl; ?>"/>
                            <input type="hidden" name="id_mapel" value="<?= $id; ?>">
                            <label>Nama Guru</label>
                            <select class="form-select" name="id_guru">
                              <?php
                              $qdg = $conn->query("SELECT * FROM tbguru;");
                              while($dg = $qdg->fetch_assoc()){
                              ?>
                              <option value="<?= $dg['id_user']; ?>" <?= ($dg['id_user'] == $raw['id_guru']) ? 'selected' : ''; ?>><?= $dg['nm_guru']; ?></option>
                              <?php
                                }
                              ?>
                            </select>
                            <label>Kelas</label>
                            <select class="form-select" name="id_kelas">
                              <?php
                              $qdk = $conn->query("SELECT * FROM tbkelas;");
                              while($dk = $qdk->fetch_assoc()){
                              ?>
                              <option value="<?= $dk['id_kelas']; ?>" <?= ($dk['id_kelas'] == $raw['id_kelas']) ? 'selected' : ''; ?>><?= $dk['nm_kelas']; ?></option>
                              <?php
                                }
                              ?>
                            </select>
                            <br>
                            <button type="submit" class="form-control btn btn-primary"> Submit</button>
                          </form>
                          <?php
                          }
                          ?>
                        </div>
                      </div>
                    </div>
            </div>
            <?php
              if(!isset($_GET['dtl'])){
                $id = $_GET['id'];
            ?>
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <div class="card-title">Data Penugasan Guru</div>
                </div>
                <div class="card-body">
                  <div class="col-md-12">
                  </div>
                <table class="table table-hover">
                  <thead> 
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Guru</th>
                        <th scope="col">Kelas</th>
                        <th scope="col" colspan="2">Aksi</th>
                      </tr>    
                  </thead>
                  <tbody>
                  <?php
                    $query = $conn->query("SELECT nm_guru, nm_kelas, id_mapel_dtl FROM tbmapeldtl tbmd, tbguru tbg, tbmapel tbm, tbkelas tbk WHERE tbg.id_user = tbmd.id_guru AND tbm.id_mapel = tbmd.id_mapel AND tbk.id_kelas = tbmd.id_kelas AND  tbm.id_mapel = '$id'");
                    $i = 1;
                    while($data = $query->fetch_assoc()){
                  ?>
                    <tr>
                      <td><?= $i++; ?></td>
                      <td><?= $data['nm_guru']; ?></td>
                      <td><?= $data['nm_kelas']; ?></td>
                      <td><a href="<?= url("/admin/mata-pelajaran-guru.php?id=".$id."&dtl=".$data['id_mapel_dtl']); ?>" class="btn btn-warning">Edit</a></td>
                      <td> 
                        <button
                        type="button"
                        class="btn btn-danger"
                        id="del-mapel"
                        data-id="<?= $data['id_mapel_dtl']; ?>">
                          Delete
                        </button>
                      </td>
                    </tr>
                  <?php
                    }
                  ?>
                  </tbody>
                </table>
              </div>
            </div>
          <?php
              }
          ?>
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

    <script src="../assets/js/main.min.js"></script>

    <script>
    var SweetAlert2Demo = (function () {
        var initDemos = function () {
            $(document).on('click', '#del-mapel',function (e) {   
              var id = $(this).data('id');
              Swal.fire({
                title: "Apakah Anda Yakin?",
                text: "Data akan di hapus",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Hapus Sekarang!"
              }).then((result) => {
                if (result.isConfirmed) {
                  $.ajax({
                    url: '<?= url("/admin/do-mata-pelajaran.php")?>',
                    type: 'DELETE',
                    data: JSON.stringify({ idMapel: id}),
                    success: function(data, textStatus, xhr) {
                    console.log(data);
                    swal.fire({
                      title: "",
                      text: "Mata Pelajaran Terhapus",
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