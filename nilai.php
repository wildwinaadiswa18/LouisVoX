<!DOCTYPE html>
<html lang="id">
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
          families: ["Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"],
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
      <?php $menu = "Nilai"; require 'menu.php'; ?>

      <div class="main-panel">
        <?php require 'header.php'; ?>
        <div class="container">
          <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
              <div class="page-header">
                <h3 class="fw-bold mb-3">Penilaian Mata Pelajaran</h3>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Data Penilaian</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table id="assessment-datatables" class="display table table-striped table-hover">
                        <thead>
                          <tr>
                            <th>Nama Tugas/Kuis</th>
                            <th>Mata Pelajaran</th>
                            <th>Nilai</th>
                            <th>Tanggal</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $qt = $conn->query("SELECT 
                            ttd.nm_tugas, 
                            tm.nm_mapel, 
                            COALESCE(ttj.nilai, 0) AS nilai, 
                            ttd.mulai as tgl 
                            FROM tbsiswa ts
                            INNER JOIN tbmapel tm ON ts.tahun_ajaran = tm.tahun_ajaran
                            INNER JOIN tbmapeldtl tmd ON  tm.id_mapel = tmd.id_mapel
                            INNER JOIN tbtugas tt ON tt.id_mapel_dtl = tmd.id_mapel_dtl
                            INNER JOIN tbtugasdtl ttd ON tt.id_tugas = ttd.id_tugas
                            LEFT JOIN tbtugasjawab ttj ON tt.id_tugas = ttj.id_tugas
                            WHERE
                            ts.id_user = '$id_siswa'
                            AND tmd.id_kelas = ts.id_kelas;");
                            while($dt = $qt->fetch_assoc()){
                              $dtgl = substr_replace(tanggal($dt['tgl']) ,"", -5);
                          ?>
                          <tr <?= ($env['KKM'] > $dt['nilai'])? "class='bg-light'": "";?>>
                            <td <?= ($env['KKM'] > $dt['nilai'])? "class='text-danger fw-bold'": "";?>><?= $dt['nm_tugas']; ?></td>
                            <td <?= ($env['KKM'] > $dt['nilai'])? "class='text-danger fw-bold'": "";?>><?= $dt['nm_mapel']; ?></td>
                            <td <?= ($env['KKM'] > $dt['nilai'])? "class='text-danger fw-bold'": "";?>><?= $dt['nilai']; ?></td>
                            <td <?= ($env['KKM'] > $dt['nilai'])? "class='text-danger fw-bold'": "";?>><?= $dtgl; ?></td>
                          </tr>
                        <?php
                            }
                        ?>
                         <?php
                            $qk = $conn->query("SELECT 
                            tk.nm_kuis, 
                            tm.nm_mapel, 
                            COALESCE(tkj.nilai, 0) AS nilai, 
                            tk.mulai as tgl 
                            FROM
                            tbsiswa ts
                            INNER JOIN tbmapel tm ON ts.tahun_ajaran = tm.tahun_ajaran
                            INNER JOIN tbmapeldtl tmd ON  tm.id_mapel = tmd.id_mapel
                            INNER JOIN tbkuis tk ON tk.id_mapel_dtl = tmd.id_mapel_dtl
                            LEFT JOIN tbkuisjawab tkj ON tk.id_kuis = tkj.id_kuis
                            WHERE
                            ts.id_user = '$id_siswa'
                            AND tmd.id_kelas = ts.id_kelas;");
                            while($dk = $qk->fetch_assoc()){
                              $dtgl = substr_replace(tanggal($dk['tgl']) ,"", -5);
                          ?>
                          <tr <?= ($env['KKM'] > $dk['nilai'])? "class='bg-light'": "";?>>
                              <td <?= ($env['KKM'] > $dk['nilai'])? "class='text-danger fw-bold'": "";?>><?= $dk['nm_kuis']; ?></td>
                              <td <?= ($env['KKM'] > $dk['nilai'])? "class='text-danger fw-bold'": "";?>><?= $dk['nm_mapel']; ?></td>
                              <td <?= ($env['KKM'] > $dk['nilai'])? "class='text-danger fw-bold'": "";?>><?= $dk['nilai']; ?></td>
                              <td <?= ($env['KKM'] > $dk['nilai'])? "class='text-danger fw-bold'": "";?>><?= $dtgl; ?></td>
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
    </div>

    <!-- Core JS Files -->
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
      $(document).ready(function () {
        var table = $('#assessment-datatables').DataTable({
          "paging": true,
          "pageLength": 10,
        });

        // Filter berdasarkan Mata Pelajaran
        $('#filter-subject').on('change', function () {
          var subject = $(this).val();
          table.column(0).search(subject).draw();
        });

        // Filter berdasarkan Kategori
        $('#filter-category').on('change', function () {
          var category = $(this).val();
          table.column(1).search(category).draw();
        });

        // Filter berdasarkan Tahun
        $('#filter-year').on('change', function () {
          var year = $(this).val();
          if (year) {
            table.column(3).search('^' + year, true, false).draw(); // Regex untuk mencocokkan tahun di awal string
          } else {
            table.column(3).search('').draw();
          }
        });
      });
    </script>
  </body>
</html>
