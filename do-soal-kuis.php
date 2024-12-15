<?php
require '../config.php';
session_start();
$id_guru = $_SESSION['uid'];
if($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    if(isset($_POST['PUT'])){
        $id = $_POST['PUT'];
        $id_mp = $_POST['id_dtl'];
        $no_soal = $_POST['no_soal'];
        $soal = $_POST['soal'];
        $a = $_POST['a'];
        $b = $_POST['b'];
        $c = $_POST['c'];
        $d = $_POST['d'];
        $kunci = $_POST['kunci'];
        $conn->query("UPDATE `tbkuisdtl` SET `soal`='$soal',`a`='$a',`b`='$b',`c`='$c', `d`='$d',`kunci`='$kunci' WHERE id_kuis = '$id' AND no = '$no_soal'");
        header("Location: ".url("/guru/soal-kuis.php?kl=".$id_mp));
        exit;
    }else{
        $id_mp = $_POST['id_dtl'];
        $no_soal = $_POST['no_soal'];
        $soal = $_POST['soal'];
        $a = $_POST['a'];
        $b = $_POST['b'];
        $c = $_POST['c'];
        $d = $_POST['d'];
        $kunci = $_POST['kunci'];
        $conn->query("INSERT INTO `tbkuisdtl`(`id_kuis`, `no`, `soal`, `a`, `b`, `c`, `d`, `kunci`) VALUES ('$id_mp','$no_soal','$soal','$a', '$b', '$c', '$d', '$kunci')");
        header("Location: ".url("/guru/soal-kuis.php?kl=".$id_mp));
        exit;
    }
}else if($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $_DELETE = json_decode(file_get_contents('php://input'), true);
    $id = $_DELETE['idKuis'];
    $no = $_DELETE['No'];
    $conn->query("DELETE FROM `tbkuisdtl` WHERE id_kuis = '$id' AND no = '$no'");
}else if($_SERVER['REQUEST_METHOD'] === 'PUT'){
    $_PUT = json_decode(file_get_contents('php://input'), true);
    $id = $_PUT['idJawab'];
    $nilai = $_PUT['nilai'];
    $conn->query("UPDATE `tbtugasjawab` SET `status`='3',`nilai`='$nilai' WHERE id_tugasjawab = '$id'");
}

?>