<?php
require '../config.php';
if($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nm_kelas = isset($_POST['namaKelas']) ? $_POST['namaKelas'] : null;
  $conn->query("INSERT INTO kelas(nm_kelas) VALUES ('".$nm_kelas."')");
  $response = [
    'message' => $nm_kelas,
  ];
  header('Content-Type: application/json');
  echo json_encode($response);
}else if($_SERVER['REQUEST_METHOD'] === 'PUT') {
  $rawInput = file_get_contents("php://input");
  $put_data = json_decode($rawInput, true);
  $nm_kelas = $put_data['namaKelas'];
  print_r($put_data);

}
?>