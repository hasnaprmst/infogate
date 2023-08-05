<?php
session_start();
require_once('auth/db_login.php');
if(!isset($_SESSION['username'])){
    header('Location: login.php');
}

$username = $_SESSION['username'];
$login = $db->query("SELECT * FROM user WHERE username='$username'");

$result = $login->fetch_object();

$thisPage = "Bank File";
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

	<!-- Ajax File -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css" integrity="sha512-mR/b5Y7FRsKqrYZou7uysnOdCIJib/7r5QeJMFvLNHNhtye3xJp1TdJVPLtetkukFn227nKpXD9OjUc09lx97Q==" crossorigin="anonymous"
    referrerpolicy="no-referrer" /> 

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
					<center><h1>Bank File</h1></center>
				</div>
				<button type="button" class="searchlist" data-bs-toggle="modal" data-bs-target="#exampleModal">
				Add File
				</button>

				<!-- Modal -->
				<div class="modal fade bd-example-modal-md" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-md">
					<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Add File</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form method="POST" action="action/addFile.php" enctype="multipart/form-data">
						<div class="modal-body">
						<div class="container-fluid">
							<div class="row">
							<div class="form-group">
								<label for="inputstatus" class="label-name">Jenis File</label>
								<select class="form-select" id="inputstatus" name="jenis_file" placeholder="Pilih Jenis File" required>
								<option selected value="">Pilih Jenis File</option>
								<option value="dokumen">DOKUMEN</option>
								<option value="mou">MOU</option>
								<option value="paparan">PAPARAN</option>
								<option value="prakom">PRAKOM</option>
								<option value="regulasi">REGULASI</option>
								</select>
							</div>

							<div class="form-group">
								<label for="inputinformasi" class="label-name">Informasi File</label>
								<textarea class="form-control" id="inputinformasi" name="informasi_file" placeholder="Masukkan Informasi File" required></textarea>
							</div>

							<div class="form-group">
								<label for="formFile" class="label-name">File Lampiran</label>
								<input type="file" class="form-control" id="formFile" name="file" required>
							</div>
							</div>
						</div>
						</div>
						<div class="modal-footer">
						<button type="button" class="modal-btn-cancel" data-bs-dismiss="modal" style="background: darkred;">Cancel</button>
						<button type="submit" class="modal-btn-add">Add</button>
						</div>
					</form>
					</div>
				</div>
				</div>

			</div>
			
			<div class="table-data">
				<div style="width: 100%;">
					<table id="example" class="table table-striped " style="width:100%">
						
						<thead style="text-align:center;">
							<tr>
								<th>NO</th>
								<th>DOKUMEN
                                <select id="dokumenFilter" class="table-filter" onchange="filterTable()" style="border-radius: 8px;">
                                        <option value="all"></option>
                                        <option value="DOKUMEN">DOKUMEN</option>
                                        <option value="MOU">MOU</option>
                                        <option value="PAPARAN">PAPARAN</option>
                                        <option value="PRAKOM">PRAKOM</option>
                                        <option value="REGULASI">REGULASI</option>
                                </select>
                                </th>
								<th>FILE</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$query = "SELECT * FROM bankfile";
							$result = $db->query($query);
							$no = 0;

							while ($row = $result->fetch_assoc()) {
								$no++;
							?>
								<tr>
									<td><?php echo $no; ?></td>
									<td>
										<div class="boxfile">
											<b class="badge bg-secondary text-uppercase"><?php echo $row['jenis_file']; ?></b>
											<span><?php echo strtoupper($row['input_by']);?></span><span> | </span>
											<span><?php echo $row['time']; ?></span>
										</div>	
										<?php echo $row['informasi_file']; ?>
									</td>
									<td>
										<a href="../files/bankfile/<?php echo $row['file_lampiran']; ?>" target="_blank" class="btn btn-success btn-sm"><i class='bx bxs-file-pdf'></i></a>
    									<a href="action/delfile.php?id=<?php echo $row['id_file']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')"><i class='bx bxs-trash' ></i></a>		
									</td>
								</tr>
							<?php
							}
							?>
						</tbody>
					</table> 
				</div>
			</div>
			<?php include '../assets/inc/copyright.php';?>	
		</main>	
	</section>

    <script>
        function filterTable() {
            var dokumenFilter = document.getElementById("dokumenFilter").value;

            var tableRows = document.querySelectorAll("#example tbody tr");

            tableRows.forEach(function(row) {
            var columns = row.querySelectorAll("td");
            var dokumen = columns[1].querySelector(".badge").textContent.toUpperCase();

            if (
                (dokumenFilter === "all" || dokumen === dokumenFilter.toUpperCase())
            ) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
            });
        }
    </script>
	<script>
    setTimeout(function() {
        var notification = document.getElementById('notification');
        if (notification) {
            notification.style.display = 'none';
        }
    }, 2000); 
	</script>
	

	<!-- jQuery JS File -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

	<!-- Vendor JS Files -->
	<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	
	<!-- Bootstrap JS File -->
	<script defer src="../assets/js/script.js"></script>
	<script defer src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
	<script defer src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

	<!-- Multiselect JS File -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js" integrity="sha512-FHZVRMUW9FsXobt+ONiix6Z0tIkxvQfxtCSirkKc5Sb4TKHmqq1dZa8DphF0XqKb3ldLu/wgMa8mT6uXiLlRlw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	
</body>
</html>
