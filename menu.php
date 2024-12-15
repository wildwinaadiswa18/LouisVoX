<?php 
require_once "../config.php";
session_start();
if (!isset($_SESSION['user']) || $_SESSION['level'] != 3) {
    header("Location: ../index.php");
    exit;
}
$username = $_SESSION['user'];
$id_siswa = $_SESSION['uid'];

if($menu == 'index' || $menu == 'Materi' || $menu == 'Tugas' || $menu == 'Nilai' && isset($_SESSION['jawab']) && $menu == 'Quiz'){
  echo '<script type="text/javascript">';
  echo 'window.location.href="'.url("/siswa/kuisdtl.php?id=".$_SESSION['jawab']['id']).'";';
  echo '</script>';
}

$sql = "SELECT t1.id_kelas, t3.id_mapel_dtl, t4.nm_mapel, t4.tahun_ajaran FROM tbsiswa t1 JOIN tbkelas t2 ON t1.id_kelas = t2.id_kelas JOIN tbmapeldtl t3 ON t2.id_kelas = t3.id_kelas JOIN tbmapel t4 ON t3.id_mapel = t4.id_mapel WHERE t1.id_user = '$id_siswa'";
$result = $conn->query($sql);
$mapelArray = [];
$id_mapel_dtl = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $mapelArray[] = $row['nm_mapel'];
        $id_mapel_dtl[] = $row['id_mapel_dtl'];
    }
} else {
}
?>

<div class="sidebar" data-background-color="dark">
  <div class="sidebar-logo">
    <div class="logo-header" data-background-color="dark">
      <a href="/admin/" class="logo">
        <img
          src="../assets/img/sekolah/logo.svg"
          alt="navbar brand"
          class="navbar-brand"
          height="70"
        />
      </a>
      <div class="nav-toggle">
        <button class="btn btn-toggle toggle-sidebar">
          <i class="gg-menu-right"></i>
        </button>
        <button class="btn btn-toggle sidenav-toggler">
          <i class="gg-menu-left"></i>
        </button>
      </div>
      <button class="topbar-toggler more">
        <i class="gg-more-vertical-alt"></i>
      </button>
    </div>
  </div>
  <div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
      <ul class="nav nav-secondary">
        <li class="nav-item <?= ($menu == 'index') ? 'active' : ''; ?>">
          <a href="<?= url('/siswa'); ?>">
            <i class="fas fa-home"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-section">
          <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
          </span>
          <h4 class="text-section">Menu Utama</h4>
        </li>
        <li class="nav-item <?= ($menu == 'Materi') ? 'active' : ''; ?>">
          <a data-bs-toggle="collapse" href="#kelasDropdown" aria-expanded="false">
            <i class="fas fa-book"></i>
            <p>Materi</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="kelasDropdown">
            <ul class="nav nav-collapse">
              <?php 
              if (!empty($mapelArray)): 
                  foreach ($mapelArray as $index => $mapel): 
              ?>
              <li>
                <a href="<?= url('/siswa/materi.php?id='.$id_mapel_dtl[$index]); ?>">
                  <span class="sub-item"><?= $mapel; ?></span>
                </a>
              </li>
              <?php 
                  endforeach;
              else:
                  echo "<li><span class='sub-item'>Tidak ada mata pelajaran tersedia.</span></li>";
              endif;
              ?>
            </ul>
          </div>
        </li>
        <li class="nav-item <?= ($menu == 'Tugas') ? 'active' : ''; ?>">
          <a data-bs-toggle="collapse" href="#tugasDropdown" aria-expanded="false">
            <i class="fas fa-tasks"></i>
            <p>Tugas</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="tugasDropdown">
            <ul class="nav nav-collapse">
              <?php foreach ($mapelArray as $index => $mapel): ?>
              <li>
                <a href="<?= url('/siswa/tugas.php?id='.$id_mapel_dtl[$index]); ?>">
                  <span class="sub-item"><?= $mapel; ?></span>
                </a>
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </li>
        <li class="nav-item <?= ($menu == 'Quiz') ? 'active' : ''; ?>">
          <a data-bs-toggle="collapse" href="#quizDropdown" aria-expanded="false">
            <i class="fas fa-question-circle"></i>
            <p>Kuis</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="quizDropdown">
            <ul class="nav nav-collapse">
              <?php 
              $qu = $conn->query("SELECT tm.nm_mapel, tk.id_kuis, tk.mulai, tk.selesai FROM tbsiswa ts, tbmapeldtl tmd, tbkuis tk, tbmapel tm WHERE ts.id_user = '$id_siswa' AND ts.id_kelas = tmd.id_kelas AND tmd.id_mapel = tm.id_mapel AND tm.tahun_ajaran = ts.tahun_ajaran AND tk.id_mapel_dtl = tmd.id_mapel_dtl");
              $tkuis = 0;
              while ($dkuis = $qu->fetch_assoc()){
                $idKuis = $dkuis['id_kuis'];
                $jbs = ($conn->query("SELECT * FROM `tbkuisjawab` WHERE tbkuisjawab.id_siswa = '$id_siswa' AND id_kuis = '$idKuis'"))->num_rows;
                $m = explode(' ', $dkuis['mulai']);
                $s = explode(' ', $dkuis['selesai']);
                $m_date = intval(str_replace('-', '', $m[0]));
                $m_time = intval(str_replace(':', '', $m[1]));
                $s_date = intval(str_replace('-', '', $s[0]));
                $s_time = intval(str_replace(':', '', $s[1]));
                $current_date = intval(date("Ymd"));
                $current_time = intval(date('Hi'));
                if ($current_time === 0) {
                  $current_time = 2400;
                }
                if ($m_time === 0) {
                  $m_time = 2400;
                }
                if ($s_time === 0) {
                  $s_time = 2400;
                }              
                if (($m_date == $current_date && $m_time > $current_time) || ($m_date > $current_date) || ($s_date < $current_date) || ($s_date == $current_date && $s_time <= $current_time) || $jbs != 0) {
                  continue;
                }
                $tkuis ++;
              ?>
              <li>
                <a href="<?= url('/siswa/kuis.php?id='.$dkuis['id_kuis']); ?>">
                  <span class="sub-item"><?= $dkuis['nm_mapel']; ?></span>
                </a>
              </li>
              <?php } ?>
            </ul>
          </div>
        </li>
        <li class="nav-item <?= ($menu == 'Nilai') ? 'active' : ''; ?>">
          <a href="<?= url('/siswa/nilai.php'); ?>">
            <i class="fas fa-chart-bar"></i>
            <p>Nilai</p>
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    var dropdowns = document.querySelectorAll('.collapse');

    dropdowns.forEach(function(dropdown) {
      dropdown.addEventListener('show.bs.collapse', function() {
        dropdowns.forEach(function(otherDropdown) {
          if (otherDropdown !== dropdown && otherDropdown.classList.contains('show')) {
            otherDropdown.classList.remove('show');
          }
        });
      });
    });
  });
</script>