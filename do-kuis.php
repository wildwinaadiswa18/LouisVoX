<?php
require '../config.php';
session_start();
$id_guru = $_SESSION['uid'];
if($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    if(isset($_POST['PUT'])){
        $id = $_POST['PUT'];
        $id_mp = $_POST['id_dtl'];
        $nm_kuis = $_POST['nm_kuis'];
        $mulai_date = $_POST['mulai_date'];
        $mulai_time = $_POST['mulai_time'];
        $mulai = $mulai_date." ".$mulai_time;
        $selesai_date = $_POST['selesai_date'];
        $selesai_time = $_POST['selesai_time'];
        $selesai = $selesai_date." ".$selesai_time;
        $conn->query("UPDATE tbkuis SET nm_kuis ='$nm_kuis', mulai='$mulai', selesai='$selesai' WHERE id_kuis = '$id'");
        header("Location: ".url("/guru/kuis.php?kl=".$id_mp));
        exit;
    }else{
        $id_mp = $_POST['id_dtl'];
        $nm_kuis = $_POST['nm_kuis'];
        $mulai_date = $_POST['mulai_date'];
        $mulai_time = $_POST['mulai_time'];
        $mulai = $mulai_date." ".$mulai_time;
        $selesai_date = $_POST['selesai_date'];
        $selesai_time = $_POST['selesai_time'];
        $selesai = $selesai_date." ".$selesai_time;
        $conn->query("INSERT INTO tbkuis(id_mapel_dtl, nm_kuis, mulai, selesai) VALUES ('$id_mp','$nm_kuis','$mulai','$selesai')");
        header("Location: ".url("/guru/kuis.php?kl=".$id_mp));
        exit;
    }
}else if($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $_DELETE = json_decode(file_get_contents('php://input'), true);
    $id = $_DELETE['idKuis'];
    $conn->query("DELETE FROM tbkuis WHERE id_kuis = $id;");
    $conn->query("DELETE FROM tbkuisdtl WHERE id_kuis = $id;");
}else if($_SERVER['REQUEST_METHOD'] === 'PUT'){
    $_PUT = json_decode(file_get_contents('php://input'), true);
    $id = $_PUT['idJawab'];
    $nilai = $_PUT['nilai'];
    $conn->query("UPDATE `tbtugasjawab` SET `status`='3',`nilai`='$nilai' WHERE id_tugasjawab = '$id'");
}

?>