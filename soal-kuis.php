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
    if(!isset($_GET['kl'])&&!isset($_GET['dtl'])){
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
                  Soal Quiz
                </li>
              </ul>
            </div>
              <div class="ms-md-auto py-2 py-md-0">
               <!-- align right -->
              </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                  <div class="card card-round">
                    <div class="card-header">
                      <div class="card-head-row card-tools-still-right">
                      <?php
                        if(!isset($_GET['dtl']) && !isset($_GET['no'])){
                      ?>
                        <h4 class="card-title">Form Soal Quiz</h4>
                      <?php
                        }else if(isset($_GET['dtl']) && isset($_GET['no'])){
                      ?>
                        <h4 class="card-tools">Form Edit Soal Quiz</h4>
                      <?php
                        }
                      ?>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-6">
                        <?php
                          if(!isset($_GET['dtl']) && !isset($_GET['no'])){
                        ?>
                          <form action="do-soal-kuis.php" method="POST" class="form-group">
                            <input type="hidden" name="id_dtl" value="<?= $id; ?>"/>  
                            <label>No Kuis</label>
                            <input type="number" class="form-control" name="no_soal" placeholder="No Kuis" required>                        
                            <label>Soal Kuis</label>
                            <textarea class="form-control" name="soal" placeholder="Soal Kuis" required></textarea>
                            <label>Jawaban A</label>
                            <input type="text" class="form-control" name="a" placeholder="Jawaban A" required>
                            <label>Jawaban B</label>
                            <input type="text" class="form-control" name="b" placeholder="Jawaban B" required>
                            <label>Jawaban C</label>
                            <input type="text" class="form-control" name="c" placeholder="Jawaban C" required>
                            <label>Jawaban D</label>
                            <input type="text" class="form-control" name="d" placeholder="Jawaban D" required>
                            <label>Kunci Jawaban</label>
                            <div class="d-flex">
                              <div class="form-check">
                                <input class="form-check-input" type="radio" value="A" name="kunci">
                                <label class="form-check-label">
                                  A
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" value="B" name="kunci">
                                <label class="form-check-label">
                                  B
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" value="C" name="kunci">
                                <label class="form-check-label">
                                  C
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" value="D" name="kunci">
                                <label class="form-check-label">
                                  D
                                </label>
                              </div>
                          </div>
                            <br>
                            <button type="submit" class="form-control btn btn-primary"> Submit</button>
                          </form>
                        <?php
                          }
                        ?>
                        </div>
                        <div class="col-md-6">
                          <?php
                            if(isset($_GET['dtl']) && isset($_GET['no'])){
                              $no = $_GET['no'];
                              $dtl = $_GET['dtl'];
                              $raw = ($conn->query("SELECT * FROM tbkuisdtl tkd WHERE tkd.id_kuis = '$dtl' AND no = '$no' LIMIT 1;"))->fetch_assoc();
                          ?>
                            <form action="do-soal-kuis.php" method="POST" class="form-group" enctype="multipart/form-data">
                              <input type="hidden" name="PUT" value="<?= $dtl; ?>"/>
                              <input type="hidden" name="id_dtl" value="<?= $id; ?>"/>                             
                              <label>No</label>
                            <input type="number" class="form-control"  value="<?= $raw['no']; ?>" name="no_soal" placeholder="No Kuis" readonly>                        
                              <label>Soal Kuis</label>
                              <textarea class="form-control" name="soal" placeholder="Soal Kuis" required><?= $raw['soal']; ?></textarea>
                              <label>Jawaban A</label>
                              <input type="text" class="form-control" value="<?= $raw['a']; ?>" name="a" placeholder="Jawaban A" required>
                              <label>Jawaban B</label>
                              <input type="text" class="form-control" value="<?= $raw['b']; ?>" name="b" placeholder="Jawaban B" required>
                              <label>Jawaban C</label>
                              <input type="text" class="form-control" value="<?= $raw['c']; ?>" name="c" placeholder="Jawaban C" required>
                              <label>Jawaban D</label>
                              <input type="text" class="form-control" value="<?= $raw['d']; ?>" name="d" placeholder="Jawaban D" required>
                              <label>Kunci Jawaban</label>
                              <div class="d-flex">
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" value="A" name="kunci" <?= ($raw['kunci'] == 'A')? 'checked': ''; ?>>
                                  <label class="form-check-label">
                                    A
                                  </label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" value="B" name="kunci" <?= ($raw['kunci'] == 'B')? 'checked': ''; ?>>
                                  <label class="form-check-label">
                                    B
                                  </label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" value="C" name="kunci" <?= ($raw['kunci'] == 'C')? 'checked': ''; ?>>
                                  <label class="form-check-label">
                                    C
                                  </label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" value="D" name="kunci" <?= ($raw['kunci'] == 'D')? 'checked': ''; ?>>
                                  <label class="form-check-label">
                                    D
                                  </label>
                                </div>
                            </div>
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
                </div>

              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">Data Quiz Kelas <?= $dk['nm_kelas']; ?></div>
                  </div>
                  <div class="card-body table-responsive">
                  <table class="table table-hover">
                    <thead> 
                        <tr>
                          <th scope="col">No</th>
                          <th scope="col">Soal Kuis</th>
                          <th scope="col">Jawaban A</th>
                          <th scope="col">Jawaban B</th>
                          <th scope="col">Jawaban C</th>
                          <th scope="col">Jawaban D</th>
                          <th scope="col">Kunci Jawaban</th>
                          <th scope="col" colspan="2">Aksi</th>
                        </tr>    
                    </thead>
                    <tbody>
                    <?php
                      $query = $conn->query("SELECT * FROM tbkuisdtl tkd WHERE tkd.id_kuis = '$id' ORDER BY tkd.no ASC");
                      $i = 1;
                      while($data = $query->fetch_assoc()){
                    ?>
                      <tr>
                        <td><?= $data['no']; ?></td>
                        <td><?= $data['soal']; ?></td>
                        <td><?= $data['a']; ?></td>
                        <td><?= $data['b']; ?></td>
                        <td><?= $data['c']; ?></td>
                        <td><?= $data['d']; ?></td>
                        <td><?= $data['kunci']; ?></td>
                        <td><a href="<?= url("/guru/soal-kuis.php?kl=".$id."&dtl=".$data['id_kuis']."&no=".$data['no']); ?>" class="btn btn-warning"> Edit</a></td>
                        <td><button
                        type="button"
                        class="btn btn-danger"
                        id="del-kuis"
                        data-id="<?= $data['id_kuis']; ?>"
                        data-no="<?= $data['no']; ?>">
                          Delete
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
    
    <!-- Custome JS -->
    <script src="../assets/js/main.min.js"></script>

    <script>
    var SweetAlert2Demo = (function () {
        var initDemos = function () {
            $(document).on('click', '#del-kuis',function (e) {   
              var id = $(this).data('id');
              var no = $(this).data('no');
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
                    url: '<?= url("/guru/do-soal-kuis.php")?>',
                    type: 'DELETE',
                    data: JSON.stringify({ idKuis: id, No: no}),
                    success: function(data, textStatus, xhr) {
                    console.log(data);
                    swal.fire({
                      title: "",
                      text: "Kuis Terhapus",
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
