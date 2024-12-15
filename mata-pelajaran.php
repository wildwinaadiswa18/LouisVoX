<!DOCTYPE html>
<html lang="en">
  <head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>E-Learning|Admin</title>
	<meta
	  content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
	  name="viewport"
	/>
	<link
	  rel="icon"
	  href="../assets/img/sekolah/favicon.ico"
	  type="image/x-icon"
	/>

	<!-- Fonts and icons -->
	<script src="../assets/js/plugin/webfont/webfont.min.js"></script>
	<script>
	  WebFont.load({
		google: { families: ["Public Sans:300,400,500,600,700"] },
		custom: {
		  families: [
			"Font Awesome 5 Solid",
			"Font Awesome 5 Regular",
			"Font Awesome 5 Brands",
			"simple-line-icons",
		  ],
		  urls: ["../assets/css/fonts.min.css"],
		},
		active: function () {
		  sessionStorage.fonts = true;
		},
	  });
	</script>

	<!-- CSS Files -->
	<link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="../assets/css/plugins.min.css" />
	<link rel="stylesheet" href="../assets/css/main.min.css" />

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="../assets/css/demo.css" />
  </head>
  <body>
	<!-- read config -->
	<?php
	require '../config.php';
	if(!isset($_GET['ta']) && !isset($_GET['id'])){
	  header('Location: '.url("/admin/mata-pelajaran.php?ta=0"));
	}
	?>
	<div class="wrapper">
	  <!-- menu -->
	   <?php
		$menu = "guru";
		require 'menu.php';

	   ?>
	  <!-- end menu -->

	  <div class="main-panel">
		<!-- header -->
		 <?php 
		  require 'header.php';
		 ?>
		<!-- end header -->
		<div class="container">
		  <div class="page-inner">
			<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
			  <div class="page-header">
				<h3 class="fw-bold mb-3">Mata Pelajaran</h3>
				<ul class="breadcrumbs mb-3">
				  <li class="nav-home">
					<a href="<?= url("/admin"); ?>">
					  <i class="icon-home"></i>
					</a>
				  </li>
				  <li class="separator">
					<i class="icon-arrow-right"></i>
				  </li>
				  <li class="nav-item">
					<a href="<?= url("/admin/mata-pelajaran.php"); ?>">Mata Pelajaran</a>
				  </li>
				</ul>
			  </div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-md-12">
				  <div class="card card-round">
					<div class="card-header">
					  <div class="card-head-row card-tools-still-right">
						<?php
						  if(!isset($_GET['id'])){
						?>
						<h4 class="card-title">Form Tambah Mata Pelajaran</h4>
						<?php
						  }else{
						?>
						<h4 class="card-tools">
						  Form Edit Mata Pelajaran
						</h4>
						<?php
						  }
						?>
					  </div>
					</div>
					<div class="card-body">
					  <div class="row">
						<div class="col-md-6">
						<?php
						  if(!isset($_GET['id'])){
						?>
						  <form action="do-mata-pelajaran.php" method="POST" class="form-group" >
							<label>Nama Mata Pelajaran</label>
							<input type="text" class="form-control" name="mapel" placeholder="Nama Mata Pelajaran">
							<label>Tahun Ajaran</label>
							<select class="form-select" name="tahun_ajar">
							  <?php
							  for($tahun = $env['TAHUN']; $tahun < date("Y")+5; $tahun++){
							  ?>
							  <option value="<?= $tahun; ?>.1"><?= $tahun; ?> Ganjil</option>
							  <option value="<?= $tahun; ?>.2"><?= $tahun; ?> Genap</option>
							  <?php
								}
							  ?>
							</select>
							<br>
							<button type="submit" class="form-control btn btn-primary"> Submit</button>
						  </form>
						<?php
						  }
						?>
						</div>
						<div class="col-md-6">
						  <?php
						  if(isset($_GET['id'])){
							$id = $_GET['id'];
							$raw = ($conn->query("SELECT * FROM tbmapel WHERE id_mapel = '$id'"))->fetch_assoc();
						  ?>
						  <form action="do-mata-pelajaran.php" method="POST" class="form-group" >
							<input type="hidden" name="PUT" value="<?= $id; ?>"/>
							<label>Nama Mata Pelajaran</label>
							<input type="text" class="form-control" name="mapel" value="<?= $raw['nm_mapel']; ?>" placeholder="Nama Mata Pelajaran">
							<label>Tahun Ajaran</label>
							<select class="form-select" name="tahun_ajar" >
							  <?php
							  for($tahun = $env['TAHUN']; $tahun < date("Y")+5; $tahun++){
							  ?>
							  <option value="<?= $tahun; ?>.1" <?= ($raw['tahun_ajaran'] == $tahun) ? 'selected' : ''; ?>><?= $tahun; ?> Ganjil</option>
							  <option value="<?= $tahun; ?>.2" <?= ($raw['tahun_ajaran'] == $tahun) ? 'selected' : ''; ?>><?= $tahun; ?> Genap</option>
							  <?php
								}
							  ?>
							</select>
							<br>
							<button type="submit" class="form-control btn btn-primary"> Submit</button>
						  </form>
						  <?php
						  }
						  ?>
						</div>
					  </div>
					</div>
			</div>
			<?php
			  if(!isset($_GET['id'])){
				$ta = $_GET['ta'];
			?>
			<div class="col-md-12">
			  <div class="card">
				<div class="card-header">
				  <div class="card-title">Data Mata Pelajaran</div>
				</div>
				<div class="card-body">
				  <div class="col-md-12">
					<form class="input-group " method="GET" action="<?= url("/admin/mata-pelajaran.php");?>">
					  <select class="form-select" name="ta">
						<option value="0" <?= ($ta == 0) ? 'selected' : ''; ?>>Semua</option>
						<?php
						  for($tahun = $env['TAHUN']; $tahun < date("Y")+5; $tahun++){
						?>
						  <option value="<?= $tahun; ?>.1" <?= ($ta == $tahun) ? 'selected' : ''; ?>><?= $tahun; ?> Ganjil</option>
						  <option value="<?= $tahun; ?>.2"><?= ($ta == $tahun) ? 'selected' : ''; ?><?= $tahun; ?> Genap</option>
						<?php
						  }
						?>
					  </select>
					  &nbsp;&nbsp;&nbsp;
					  <div class="input-group-prepend">
						<input type="text" name="mapel" placeholder="Cari Mata Pelajaran ..." class="form-control">
					  </div>
					  <button type="submit" class="btn btn-search pe-0" name="cari">
						  <i class="fa fa-search search-icon"></i>
					  </button>                    
					</form>
				  
				  </div>
				<table class="table table-hover">
				  <thead> 
					  <tr>
						<th scope="col">#</th>
						<th scope="col">Nama Mata Pelajaran</th>
						<th scope="col">Tahun Ajar</th>
                        <th scope="col">Aksi</th>
					  </tr>    
				  </thead>
				  <tbody>
				  <?php
					if(isset($_GET['cari'])){
					  $nama = $_GET['mapel'];
					  $th_ajar = $_GET['ta'];
					  if($ta == 0){
						$query = $conn->query("SELECT * FROM tbmapel WHERE nm_mapel LIKE '%$nama%'");
					  }else{
						$query = $conn->query("SELECT * FROM tbmapel WHERE nm_mapel LIKE '%$nama%' AND tahun_ajaran = '$ta'");
					  }
					}else{
					  $query = $conn->query("SELECT * FROM tbmapel;");
					}
					$i = 1;
					while($data = $query->fetch_assoc()){
				  ?>
					<tr>
						<td><?= $i++; ?></td>
						<td><?= $data['nm_mapel']; ?></td>
						<td><?= tahun_ajar($data['tahun_ajaran']); ?></td>
						<td>
                       		<div style="display: flex; flex-direction: row; gap: 1em; justify-content: flex-end; white-space: nowrap;">
								<a href="<?= url("/admin/mata-pelajaran-guru.php?id=".$data['id_mapel']); ?>" class="btn btn-primary"><?= $env['STR_VIEW_SUBJECT'] ?></a>
								<button href="<?= url("/admin/mata-pelajaran.php?id=".$data['id_mapel']); ?>" class="btn btn-warning"><?= $env['STR_EDIT_SUBJECT'] ?></button>
								<button id="del-mapel" class="btn btn-danger" data-id="<?= $data['id_mapel']; ?>"><?= $env['STR_SUBJECT_DELETE'] ?></button>
							</div>
						</td>
					</tr>
				  <?php
					}
				  ?>
				  </tbody>
				</table>
			  </div>
			</div>
		  <?php
			  }
		  ?>
		  </div>
		</div>
	  </div>
	</div>
  </div>
	<!--   Core JS Files   -->
	<script src="../assets/js/core/jquery-3.7.1.min.js"></script>
	<script src="../assets/js/core/popper.min.js"></script>
	<script src="../assets/js/core/bootstrap.min.js"></script>

	<!-- jQuery Scrollbar -->
	<script src="../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

	<!-- Chart JS -->
	<script src="../assets/js/plugin/chart.js/chart.min.js"></script>

	<!-- jQuery Sparkline -->
	<script src="../assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

	<!-- Chart Circle -->
	<script src="../assets/js/plugin/chart-circle/circles.min.js"></script>

	<!-- Datatables -->
	<script src="../assets/js/plugin/datatables/datatables.min.js"></script>

	<!-- Bootstrap Notify -->
	<script src="../assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

	<!-- jQuery Vector Maps -->
	<script src="../assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
	<script src="../assets/js/plugin/jsvectormap/world.js"></script>

	<!-- Sweet Alert -->
	<script src="../assets/js/plugin/sweetalert/sweetalert2-11.js"></script>

	<script src="../assets/js/main.min.js"></script>

	<script>
	var SweetAlert2Demo = (function () {
		var initDemos = function () {

			// Check for user click on button click
			$(document).on('click', '#del-mapel',function (e) {
				var id_mapel = $(this).data('id'); // Get the selected subjects id
				// Spawn confirmation dialog
				swal.fire({
					title: "<?= $env['STR_SUBJECT_DELETE'] ?>",
					text: `Mata pelajaran terpilih tidak dapat dikembalikan setelah terhapus!`,
					icon: "warning",
					showCancelButton: true,
					confirmButtonColor: "#d33",
					cancelButtonColor: "#3085d6",
					confirmButtonText: "Hapus Sekarang!",
					cancelButtonText: "Batal"
				}).then((result) => {
					// Check if user confirms.
					if (result.isConfirmed) {
						// Send deletion request and spawn status dialog after data is received.
						$.ajax({
							url: '<?= url("/admin/do-mata-pelajaran.php")?>',
							type: 'DELETE',
							data: JSON.stringify({ idMapel: id_mapel}),
							success: function(data, textStatus, xhr) {
								console.log(data); // Debugging
								swal.fire({
									title: "",
									text: "Mata pelajaran berhasil terhapus",
									icon: "success"
								}).then((result) => {
									if (result.isConfirmed) {
										location.reload();
									}
								});
							},
							error: function(xhr, status, error) {
								swal.fire("", "Error: " + xhr.responseText, "error");
							}
						});
					}
				});
			});
		};

		return {
			init: function () {
				initDemos();
			},
		};
	})();

	jQuery(document).ready(function () {
		SweetAlert2Demo.init();
	});
</script>
  </body>
</html>
