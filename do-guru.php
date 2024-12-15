<?php
require '../config.php';
if($_SERVER['REQUEST_METHOD'] === 'POST') {
  if(isset($_POST['pass']) && $_POST['pass'] != ""){
    $password = $_POST['pass'];
    $id = $_POST['idUser'];
    $conn->query("UPDATE tbuser SET `password`='$password' WHERE uid = '$id'");
    $response = "Berhasil Reset Password Siswa";
    http_response_code(200);
  }else if($_POST['idUser'] != "" && $_POST['nmGuru'] != "" && $_POST['username'] != "" && $_POST['password'] != ""){
    var_dump($_POST);
    $id_user = $_POST['idUser'];
    $nm_guru = $_POST['nmGuru'];
    $tahun_masuk = $_POST['thMasuk'];
    $username = $_POST['email'];
    $password = $_POST['password'];
    $conn->query("INSERT INTO tbguru(`id_user`, `nm_guru`, masuk_tahun) VALUES ('$id_user', '$nm_guru', '$tahun_masuk');");
    $conn->query("INSERT INTO tbuser(`uid`, `email`, `password`, `level`) VALUES ('$id_user','$username','$password','2');");
    $response = "Berhasil Tambah Guru";
    http_response_code(200);
  }else{
    $response = "Inputan Wajib Di isi";
    http_response_code(400);
  }
  echo $response;
}else if($_SERVER['REQUEST_METHOD'] === 'PUT') {
  $_PUT = json_decode(file_get_contents('php://input'), true);
  if($_PUT['nmGuru'] == "" || $_PUT['tahunMasuk'] == "" || $_PUT['tahunKeluar'] == ""){
    $response = "Data Guru Wajib Di isi";
    http_response_code(400);
  }else{
    $id = $_PUT["idUser"];
    $masuk_tahun = $_PUT["tahunMasuk"];
    $tahun_lulus = $_PUT["tahunKeluar"];
    $nm_guru = $_PUT["nmGuru"];
    $conn->query("UPDATE `tbguru` SET `nm_guru`='$nm_guru',`masuk_tahun`='$masuk_tahun',`keluar_tahun`='$tahun_lulus' WHERE id_user = $id");
    $response = json_encode([
      'message' => "succes update guru",
    ]);
    http_response_code(200);
  }
  echo $response;
}else if($_SERVER['REQUEST_METHOD'] === 'DELETE') {
  $_DELETE = json_decode(file_get_contents('php://input'), true);
  $id = $_DELETE['idUser'];
  $response = [
    'message' => "succes delete guru",
  ];
  $conn->query("DELETE FROM tbuser WHERE uid = $id;");
  $conn->query("DELETE FROM tbguru WHERE id_user = $id;");

  http_response_code(200);
  echo json_encode($response);
}
?>