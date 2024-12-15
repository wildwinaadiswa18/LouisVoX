<?php
require '../config.php';
session_start();
$id_guru = $_SESSION['uid'];
$id_siswa = $_SESSION['uid'];
$id_kuis = $_SESSION['jawab']['id'];
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if($_SESSION['level'] == 3 && isset($_SESSION['jawab'])){
      
      $jawab = $_SESSION['jawab']['jawab'];
      $jb = $_POST['jawab'];
      $no = $_POST['no'];
      $jawab[$no] = $jb;
      $jbs = ($conn->query("SELECT * FROM `tbkuisjawab` WHERE tbkuisjawab.id_siswa = '$id_siswa' AND id_kuis = '$id_kuis'"))->num_rows;
      $time = ($conn->query("SELECT tk.mulai, tk.selesai FROM tbkuis tk WHERE tk.id_kuis = '$id_kuis' LIMIT 1"))->fetch_assoc();
      $m = explode(' ', $time['mulai']);
      $s = explode(' ', $time['selesai']);
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
      if(($m_date == $current_date && $m_time > $current_time) || ($m_date > $current_date) || ($s_date < $current_date) || ($s_date == $current_date && $s_time <= $current_time) || $jbs != 0){
        $_SESSION['jawab']['jawab'][$no] = $jb;
        $_SESSION['jawab']['soal'][$no] = false;
        return 0;
      }

      if(isset($_SESSION['jawab']['jawab'][$no]) && isset($_SESSION['jawab']['soal'][$no])){
        http_response_code(400);
      }else{
        $_SESSION['jawab']['jawab'][$no] = $jb;
        $cek = ($conn->query("SELECT * FROM tbkuisdtl WHERE id_kuis = '$id_kuis' AND no = '$no' AND kunci = '$jb';"))->num_rows;
        if($cek > 0){
          $_SESSION['jawab']['soal'][$no] = true;
        }else{
          $_SESSION['jawab']['soal'][$no] = false;
        }
      }
    }
}else if($_SERVER['REQUEST_METHOD'] === 'GET') {
  $jawab = $_SESSION['jawab'];
  echo json_encode(['jawab' => $jawab['jawab']]);
}else if($_SERVER['REQUEST_METHOD'] === 'PUT'){
  if($_SESSION['level'] == 3 && isset($_SESSION['jawab'])){
    $benar = count(array_filter($_SESSION['jawab']['soal'], function($value) {
      return $value === true;
    }));
    $dtl = ($conn->query("SELECT * FROM `tbkuisdtl` WHERE id_kuis = '$id_kuis'"))->num_rows;
    $total = $benar * (100 / $dtl);
    $conn->query("INSERT INTO `tbkuisjawab`(`id_kuis`, `id_siswa`, `nilai`) VALUES ('$id_kuis','$id_siswa','$total')");
  }else{
    http_response_code(400);
  }
}
?>