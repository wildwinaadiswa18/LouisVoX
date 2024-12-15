<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

$userEmail = $_SESSION['user'];
require_once "config.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Opname</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">
<link rel="stylesheet" href="css/animate.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="style.css">

<style>
.modal-body .form-group {
  text-align: left;
}

.form-check-label {
  margin-left: 10px;
  display: inline-flex;
  align-items: center;
  position: relative;

}
.form-check-label[for="csvRadio"] {
  margin-top: 16px;
}
.form-check-label[for="pdfRadio"] {
  margin-top: 16px;
}
</style>

<script>
function confirmReset() {
    if (confirm("Apakah Anda yakin ingin menghapus semua data Opname?")) {
        window.location.href = "delete_opname.php";
    }
}
</script>
</head>
<body>



<section class="about section-padding prelative" data-scroll-index='1'>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="sectioner-header text-center">
          <h3>OPNAME</h3>
          <span class="line"></span>
          <p>Welcome, <?php echo htmlspecialchars($userEmail); ?>!</p>
        </div>
        
      </div>
    </div>
  </div>
</section>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</body>
</html>
