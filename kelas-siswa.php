<?php
require '../config.php';
if($_SERVER['REQUEST_METHOD'] === 'POST') {
  if($_POST['idUser'] == 0 || $_POST['nmSiswa'] == "" || $_POST['username'] == "" || $_POST['password'] == "" || $_POST['tahunMasuk'] == ""){
    $response = "Data Siswa Belum Di Isi Lengkap";
    http_response_code(400);
  }else{
    $id_user = $_POST['idUser'];
    $nm_siswa = $_POST['nmSiswa'];
    $id_kelas = $_POST['idKelas'];
    $tahun_masuk = $_POST['tahunMasuk'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $conn->query("INSERT INTO tbuser (uid, `email`, `password`, `level`) VALUES ('$id_user','$username','$password','3')");
    $conn->query("INSERT INTO tbsiswa (`id_user`, `id_kelas`, `nm_siswa`, `tahun_ajaran`, `masuk_tahun`) VALUES ('$id_user','$id_kelas',' $nm_siswa', '0','$tahun_masuk')");
    http_response_code(200);
    $response = "Berhasil menambah siswa";
  }
  echo $response;
}else if($_SERVER['REQUEST_METHOD'] === 'PUT') {
  $_PUT = json_decode(file_get_contents('php://input'), true);
  $tahun_ajaran = $_PUT['tahunAjaran'];
  $id_kelas = $_PUT['idKelas'];
  $cek = $conn->query("SELECT tahun_ajaran FROM tbsiswa WHERE id_kelas = '$id_kelas' GROUP BY tahun_ajaran");
  if($cek->num_rows == 0){
    $response = "Minimal Terdapat 1 Siswa";
    http_response_code(400);
  }else{
    $conn->query("UPDATE tbsiswa SET `tahun_ajaran`='$tahun_ajaran' WHERE id_kelas = '$id_kelas'");
    $response = json_encode([
      'message' => "succes update siswa",
    ]);
    http_response_code(200);
  }
  // header('Content-Type: application/json');
  echo $response;
}
?>