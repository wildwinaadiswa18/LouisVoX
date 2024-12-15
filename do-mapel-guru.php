<?php
require '../config.php';
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['PUT'])){
        $id = $_POST['PUT'];
        $id_mapel = $_POST['id_mapel'];
        $id_guru = $_POST['id_guru'];
        $id_kelas = $_POST['id_kelas'];
        $conn->query("UPDATE `tbmapeldtl` SET `id_guru`='$id_guru',`id_mapel`='$id_mapel',`id_kelas`='$id_kelas' WHERE id_mapel_dtl = '$id'");
        header("Location: ".url("/admin/mata-pelajaran-guru.php?id=".$id_mapel));
        exit;
    }else{
        echo "tambah";
        $id_mapel = $_POST['id_mapel'];
        $id_guru = $_POST['id_guru'];
        $id_kelas = $_POST['id_kelas'];
        $cek = ($conn->query("SELECT * FROM tbmapeldtl WHERE id_guru = '$id_guru' AND id_kelas = '$id_kelas'"))->num_rows;
        if($cek == 0){
            $conn->query("INSERT INTO `tbmapeldtl`(`id_guru`, `id_mapel`, `id_kelas`) VALUES ('$id_guru','$id_mapel','$id_kelas')");
        }
        header("Location: ".url("/admin/mata-pelajaran-guru.php?id=".$id_mapel));
        exit;
    }
}else if($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $_DELETE = json_decode(file_get_contents('php://input'), true);
    $id_mapel = $_DELETE['idMapel'];
    $conn->query("DELETE FROM tbmapel WHERE id_mapel = $id_mapel;");
    $response = [
        'message' => "succes delete kelas",
    ];
}

?>