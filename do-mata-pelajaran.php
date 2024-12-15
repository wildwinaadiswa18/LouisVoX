<?php
require '../config.php';
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['PUT'])){
        $id = $_POST['PUT'];
        $mapel = $_POST['mapel'];
        $tahun_ajar = $_POST['tahun_ajar'];
        $conn->query("UPDATE `tbmapel` SET `nm_mapel`='$mapel', tahun_ajaran = '$tahun_ajar' WHERE id_mapel = '$id'");
        header("Location: ".url("/admin/mata-pelajaran.php?ta=0"));
        exit;
    }else{
        $mapel = $_POST['mapel'];
        $tahun_ajar = $_POST['tahun_ajar'];
        $conn->query("INSERT INTO `tbmapel`(`id_mapel`, `nm_mapel`, `tahun_ajaran`) VALUES ((SELECT COALESCE(MAX(id_mapel), 0) + 1 FROM tbmapel as t),'$mapel','$tahun_ajar')");
        header("Location: ".url("/admin/mata-pelajaran.php?ta=0"));
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