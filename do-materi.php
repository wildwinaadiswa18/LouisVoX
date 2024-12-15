<?php
require '../config.php';
session_start();
$id_guru = $_SESSION['uid'];
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dok = basename($_FILES["dok"]["name"]); 
    $new_dok = time();
    $dir = "../assets/materi/". $new_dok . ".pdf";
    $save_dir = url("/assets/materi/". $new_dok . ".pdf");
    if(isset($_POST['PUT'])){
        $id = $_POST['PUT'];
        $id_mp = $_POST['id_dtl'];
        $no = $_POST['no'];
        $dtl_materi = $_POST['dtl_materi'];
        $nm_materi = $_POST['nm_materi'];
        if ($_FILES["dok"]["size"] == 0) {
            $conn->query("UPDATE `tbmateri` SET `no`='$no' WHERE id_materi = '$id'");
            $conn->query("UPDATE `tbmateridtl` SET `nm_materi`='$nm_materi',`dtl_materi`='$dtl_materi' WHERE id_materi = '$id'");
            header("Location: ".url("/guru/materi.php?kl=".$id_mp));
            exit;
        }else if(move_uploaded_file($_FILES["dok"]["tmp_name"], $dir)){
            $conn->query("UPDATE `tbmateri` SET `no`='$no' WHERE id_materi = '$id'");
            $conn->query("UPDATE `tbmateridtl` SET `nm_materi`='$nm_materi',`dtl_materi`='$dtl_materi',`dokumen`='$save_dir' WHERE id_materi = '$id'");
            header("Location: ".url("/guru/materi.php?kl=".$id_mp));
            exit;
        }
    }else{
        $nm_materi = $_POST['nm_materi'];
        $no = $_POST['no'];
        $dtl_materi = $_POST['dtl_materi'];
        $id_mp = $_POST['id_dtl'];
        if ($_FILES["dok"]["size"] == 0) {
            echo "empty";
            header("Location: ".url("/guru/materi.php?kd=".$id_mp));
            exit;
        }else if(move_uploaded_file($_FILES["dok"]["tmp_name"], $dir)){
            $conn->query("INSERT INTO `tbmateri`(`id_mapel_dtl`, `no`) VALUES ('$id_mp','$no')");
            $conn->query("INSERT INTO `tbmateridtl`(`id_materi`, `nm_materi`, `dtl_materi`, `dokumen`) VALUES ((SELECT id_materi FROM tbmateri  ORDER BY id_materi DESC LIMIT 1),'$nm_materi','$dtl_materi','$save_dir')");
            header("Location: ".url("/guru/materi.php?kl=".$id_mp));
            exit;
        }
    }
}else if($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $_DELETE = json_decode(file_get_contents('php://input'), true);
    $id = $_DELETE['idMateri'];
    $conn->query("DELETE FROM tbmateri WHERE id_materi = $id;");
    $conn->query("DELETE FROM tbmateridtl WHERE id_materi = $id;");
}

?>