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
                <h3 class="fw-bold mb-3">Guru</h3>
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
                    <a href="<?= url("/admin/guru.php"); ?>">Guru</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <div class="card-title">Data Guru</div>
                </div>
                <div class="card-body">
                  <div class="col-md-12">
                    <form class="input-group " method="GET" action="<?= url("/admin/guru.php");?>">
                      <button
                      type="button"
                      class="btn btn-primary"
                      id="form-guru">
                        <?= $env['STR_ADD_TEACHER'] ?>
                      </button>
                      &nbsp;&nbsp;&nbsp;
                      <div class="input-group-prepend">
                        <input type="text" name="nama" placeholder="Cari Guru ..." class="form-control">
                      </div>
                      <button type="submit" class="btn btn-search pe-0 ">
                          <i class="fa fa-search search-icon"></i>
                      </button>                    
                    </form>
                  
                  </div>
                <table class="table table-hover">
                  <thead> 
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Guru</th>
                        <th scope="col">Tahun Masuk</th>
                        <th scope="col">Tahun Keluar</th>
                        <th scope="col">Aksi</th>
                      </tr>    
                  </thead>
                  <tbody>
                  <?php
                    if(isset($_GET['nama'])){
                      $nama = $_GET['nama'];
                      $query = $conn->query("SELECT * FROM tbguru WHERE nm_guru LIKE '%$nama%'");
                    }else{
                      $query = $conn->query("SELECT * FROM tbguru;");
                    }
                    $i = 1;
                    while($data = $query->fetch_assoc()){
                  ?>
                    <tr>
                      <td><?= $i++; ?></td>
                      <td><?= $data['nm_guru']; ?></td>
                      <td><?= $data['masuk_tahun']; ?></td>
                      <td><?= $data['keluar_tahun']; ?></td>
                      <td>
                        <div style="display: flex; flex-direction: row; gap: 1em; justify-content: flex-end; white-space: nowrap;">
                          <button
                          type="button"
                          class="btn btn-warning"
                          id="edit-guru"
                          data-id="<?= $data['id_user']; ?>"
                          data-nm="<?= $data['nm_guru']; ?>"
                          data-mt="<?= $data['masuk_tahun']; ?>"
                          data-kt="<?= $data['keluar_tahun']; ?>">
                            <?= $env['STR_EDIT_TEACHER'] ?>
                          </button>
                          <button
                          type="button"
                          class="btn btn-danger"
                          id="reset-guru"
                          data-id="<?= $data['id_user']; ?>">
                            <?= $env['STR_RPW_TEACHER'] ?>
                          </button>
                          <button
                          type="button"
                          class="btn btn-danger"
                          id="del-guru"
                          data-id="<?= $data['id_user']; ?>">
                            <?= $env['STR_DELETE_TEACHER'] ?>
                          </button>
                        </div>
                      </td>
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
            $(document).on('click', '#form-guru',function (e) {
              swal.fire({
                  title: "<?= $env['STR_ADD_TEACHER'] ?>",
                  html: '<br><input class="form-control" placeholder="NIP" id="nip">'+
                        '<br><input class="form-control" placeholder="Nama Guru" id="nm_guru">'+
                        '<br><input class="form-control" placeholder="Tahun Masuk" id="th_masuk">'+
                        '<br><input class="form-control" placeholder="Username" id="user">'+
                        '<br><input class="form-control" placeholder="Password" id="pass">',
                  showCancelButton: true,
                  confirmButtonClass: 'btn btn-primary',
                  cancelButtonClass: 'btn btn-cancel',
                  buttonsStyling: true,
              }).then((result) => {
                  if (result.isConfirmed) {
                      var nip = $("#nip").val();
                      var nm_guru = $("#nm_guru").val();
                      var th_masuk = $("#th_masuk").val();
                      var user = $("#user").val();
                      var pass = $("#pass").val();
                      $.ajax({
                          url: '<?= url("/admin/do-guru.php")?>',
                          type: 'POST',
                          data: { idUser: nip, nmGuru: nm_guru, thMasuk: th_masuk, username: user, password: pass },
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
            $(document).on('click', '#reset-guru',function (e) {   
              var id = $(this).data('id');
              console.log("RESET");
              swal.fire({
                  title: "<?= $env['STR_RPW_TEACHER'] ?>",
                  html: '<br><input class="form-control" placeholder="Password Baru" id="pass">',
                  showCancelButton: true,
                  confirmButtonClass: 'btn btn-success',
                  cancelButtonClass: 'btn btn-danger',
                  buttonsStyling: true,
              }).then((result) => {
                  if (result.isConfirmed) {
                      var password = $("#pass").val();
                      $.ajax({
                          url: '<?= url("/admin/do-guru.php")?>',
                          type: 'POST',
                          data: { idUser: id, pass: password },
                          success: function(data, textStatus, xhr) {
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
            $(document).on('click', '#del-guru',function (e) {   
              var id = $(this).data('id');
              Swal.fire({
                title: "Apakah Anda Yakin?",
                text: "Data Guru tidak dapat dikembalikan setelah dihapus!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Hapus Sekarang!"
              }).then((result) => {
                if (result.isConfirmed) {
                  $.ajax({
                    url: '<?= url("/admin/do-guru.php")?>',
                    type: 'DELETE',
                    data: JSON.stringify({ idUser: id}),
                    success: function(data, textStatus, xhr) {
                    console.log(data);
                    swal.fire({
                      title: "",
                      text: "Guru Terhapus",
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
            $(document).on('click', '#edit-guru',function (e) {
              var id = $(this).data('id');
              var nm = $(this).data('nm');
              var mt = $(this).data('mt');
              var kt = $(this).data('kt');
              swal.fire({
                  title: "<?= $env['STR_EDIT_TEACHER'] ?>",
                  html: '<br><input class="form-control" placeholder="Nama guru" value="'+nm+'" id="nm">'+
                        '<br><input class="form-control" placeholder="Tahun Masuk" value="'+mt+'" id="mt">'+
                        '<br><input class="form-control" placeholder="Tahun Keluar" value="'+kt+'" id="kt">',
                  showCancelButton: true,
                  confirmButtonClass: 'btn btn-success',
                  cancelButtonClass: 'btn btn-danger',
                  buttonsStyling: true,
              }).then((result) => {
                  if (result.isConfirmed) {
                      var nama_guru = $("#nm").val();
                      var tahun_masuk = $("#mt").val();
                      var tahun_keluar = $("#kt").val();
                      $.ajax({
                          url: '<?= url("/admin/do-guru.php")?>',
                          type: 'PUT',
                          data: JSON.stringify({ idUser: id, nmGuru: nama_guru, tahunMasuk: tahun_masuk, tahunKeluar: tahun_keluar}),
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