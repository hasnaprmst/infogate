<?php
session_start();
require_once('auth/db_login.php');
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
}

$username = $_SESSION['username'];
$login = $db->query("SELECT * FROM user WHERE username='$username'");

$result = $login->fetch_object();

$thisPage = "Log History";
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
			<div class="head-title">
				<div class="left">
					<center><h1>Login Tracking</h1></center>
				</div>
			</div>
			<div class="table-data">
				<div style="width: 100%;">
						<table id="example" class="table table-striped " style="width:100%">
							<thead style="text-align:center;">
										<tr>
											<th>NO</th>
											<th>NAMA LENGKAP</th>
											<th>USERNAME</th>
											<th>IP ADDRESS</th>
											<th>LOGIN TIME</th>
										</tr>
							</thead>
							<tbody>
								<?php 
									$query=mysqli_query($db,"SELECT * FROM user_log");
									$no=1;
									
									while($row=mysqli_fetch_array($query))
									{
									?>
									<tr>
									<td><?php echo $no;?></td>
                                    <td><?php echo $row['nama_lengkap'];?></td>
                                    <td><?php echo $row['username'];?></td>
                                    <td><?php echo $row['user_ip'];?></td>
                                    <td><?php echo $row['login_time'];?></td>
									</tr>
								<?php $no=$no+1;
								}
								?>
							</tbody>
						</table> 
				</div>
			</div>
			<?php include '../assets/inc/copyright.php';?>
		</main>	
	</section>
	
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
