<?php
session_start();
require_once('auth/db_login.php');
if(!isset($_SESSION['username'])){
    header('Location: login.php');
}

$username = $_SESSION['username'];
$login = $db->query("SELECT * FROM user WHERE username='$username'");

$result = $login->fetch_object();

$thisPage = "Profile";
?>

<!DOCTYPE html>
<html lang="en">
	
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $thisPage; ?></title>

	<!-- Vendor CSS Files -->
	<link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="../assets/vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
	<link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
	<link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
	
	<!-- Datatable CSS File -->
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">

	<!-- Boxicons CDN Link -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" rel="stylesheet">
	
	<!-- Bootstrap CSS File -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

	<!-- CSS File -->
	<link rel="stylesheet" href="../assets/css/style.css">

	<!-- IMG File -->
	<link rel="shortcut icon" type="image/png" href="../assets/img/logo.png">
		
</head>
<body>

	<!-- SIDEBAR -->
	<?php include '../assets/inc/sidebar.php';?>
	<!-- SIDEBAR -->

	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<?php include '../assets/inc/navbar.php';?>
		<!-- NAVBAR -->

		<!-- MAIN -->
			<main>
			<div class="left">
					<?php
						if (isset($_SESSION['notification'])) {
							$notification = $_SESSION['notification'];
							$type = $notification['type'];
							$message = $notification['message'];
							unset($_SESSION['notification']);

							echo '<div id="notification" class="alert alert-' . ($type == 'success' ? 'success' : 'danger') . ' alert-dismissible fade show" role="alert">';
							echo $message;
							echo '</div>';
						}
					?>
			</div>
				<div class="head-title">
					<div class="left">
						<center><h1>Profile</h1></center>
						<ul class="breadcrumb">
							<ul class="asd"></ul>
						</ul>
					</div>
	
				</div>

				<div class="table-data">
					<div class="boxxx">
						<h4>&nbsp;&nbsp;Hello, <?=$result->nama_lengkap?>!</h4>
						<form method="POST" action="action/editProfile.php">
							<div class="mini-box">
								<div class="minibox" style="width: 45%;">
									<label for="inputnama" class="label-name">USERNAME</label>
									<input type="text" class="form-control" value="<?= $result->username ?>" disabled>
								</div>
								<div class="minibox" style="width: 45%;">
									<label for="inputrole" class="label-name">ROLE</label>
									<input type="text" class="form-control" value="<?= $result->role ?>" disabled>
								</div>
								<div class="minibox" style="width: 45%;">
									<label for="inputpass" class="label-name">PASSWORD</label>
									<input type="text" class="form-control" name="password" value="<?= $result->password ?>" disabled>
								</div>
								<div class="minibox" style="width: 45%;">
									<label for="inputgrup" class="label-name">GRUP</label>
									<input type="text" class="form-control" id="inputgrup" placeholder="Masukan Grup" value="<?php 
									if ($result->grup1 == NULL && $result->grup2 == NULL) {
										echo "";
									} elseif ($result->grup1 != NULL && $result->grup2 == NULL) {
										echo $result->grup1;
									} elseif ($result->grup1 == NULL && $result->grup2 != NULL) {
										echo $result->grup2;
									} else {
										echo $result->grup1 . ", " . $result->grup2;
									}
									?>" disabled>
								</div>
								<div class="minibox" style="width: 45%;">
									<label for="inputinisial" class="label-name">INISIAL</label>
									<input type="text" class="form-control" id="inputinisial" placeholder="Masukan Inisial" style="text-transform: uppercase;" value="<?= $result->initial_name ?>" disabled>
								</div>
								<div class="profile-btn">
									<button type="button" class="modal-btn-add btn-primary" data-bs-toggle="modal" data-bs-target="#editProfile">Edit</button>

									<!-- Edit Modal -->
									<div class="modal fade" id="editProfile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLabel">Edit Profile</h5>
												<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
											</div>
											<form method="POST" action="action/editProfile.php">
												<div class="modal-body">
													<div class="form-row">
														<div class="col">
															<div class="form-group">
																<label for="inputnama" class="label-name">USERNAME</label>
																<input type="text" class="form-control" name="username" id="inputnama" value="<?= $result->username ?>" disabled>
															</div>
									
															<div class="form-group">
																<label for="inputpass" class="label-name">PASSWORD</label>
																<input type="text" class="form-control" name="password" placeholder="Masukan Password" value="<?= $result->password ?>" required>
															</div>

															<div class="form-group">
																<label for="inputinisial" class="label-name">INISIAL</label>
																<input type="text" class="form-control" name="initial_name" id="inputinisial" placeholder="Masukan Inisial" style="text-transform: uppercase;" value="<?= $result->initial_name ?>" required>
															</div>
										
															<div class="form-group">
																<label for="inputrole" class="label-name">ROLE</label>
																<input type="text" class="form-control" name="role" id="inputrole" value="<?= $result->role ?>" disabled>
															</div>

															<div class="form-group">
																<label for="inputgrup" class="label-name">GRUP</label>
																<input type="text" class="form-control" id="inputgrup" placeholder="Masukan Grup" value="<?php 
																if ($result->grup1 == NULL && $result->grup2 == NULL) {
																	echo "";
																} elseif ($result->grup1 != NULL && $result->grup2 == NULL) {
																	echo $result->grup1;
																} elseif ($result->grup1 == NULL && $result->grup2 != NULL) {
																	echo $result->grup2;
																} else {
																	echo $result->grup1 . ", " . $result->grup2;
																}
																?>" disabled>
															</div>
														</div>
													</div>
												</div>
												<div class="modal-footer">
													<button type="submit" class="modal-btn-add" name="save" value="save">Save</button>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</form>
           			</div>
				</div>
				</div>
				<?php include '../assets/inc/copyright.php';?>	
			</main>	
	</section>
	<script>
    setTimeout(function() {
        var notification = document.getElementById('notification');
        if (notification) {
            notification.style.display = 'none';
        }
    }, 1000); 
	</script>

	<!-- Vendor JS Files -->
	<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	
	<!-- Bootstrap JS File -->
	<script defer src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script defer src="../assets/js/script.js"></script>
	<script defer src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
	<script defer src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>
	
