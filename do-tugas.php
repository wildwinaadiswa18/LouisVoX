<?php
require '../config.php';
session_start();
$id_guru = $_SESSION['uid'];
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dok = basename($_FILES["dok"]["name"]); 
    $new_dok = time();
    $dir = "../assets/jawab/". $new_dok . ".pdf";
    $save_dir = url("/assets/jawab/". $new_dok . ".pdf");
    $tg = $_POST['tugas'];
    $mp = $_POST['mapel'];
    $sis = $_SESSION['uid'];
    if ($_FILES["dok"]["size"] == 0) {
      echo "empty";
    }else if(move_uploaded_file($_FILES["dok"]["tmp_name"], $dir)){
      $jw = $conn->query("SELECT * FROM tbtugasjawab ttj, tbsiswa ts WHERE ttj.id_siswa = '$sis' AND ttj.id_tugas = '$tg' LIMIT 1");
      $djw = $jw->fetch_assoc();
      if($jw->num_rows != 0){
        $conn->query("UPDATE `tbtugasjawab` SET `dokumen`='$save_dir' WHERE id_siswa = '$sis' AND id_tugas = '$tg'");
      }else{
        echo "New Upload";
        $conn->query("INSERT INTO `tbtugasjawab`(`id_tugas`, `id_siswa`, `dokumen`, `status`) VALUES ('$tg','$sis','$save_dir','1')");
      }
      header("Location: ".url("/siswa/tugas.php?id=".$mp));
      exit;
    }
}
?>