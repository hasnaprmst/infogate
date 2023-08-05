<?php
session_start();
require_once('auth/db_login.php');
if(!isset($_SESSION['username'])){
    header('Location: login.php');
}

$username = $_SESSION['username'];
$login = $db->query("SELECT * FROM user WHERE username='$username'");

$result = $login->fetch_object();

$thisPage = "Master Pekerjaan";
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
					<center><h1>Master Pekerjaan</h1></center>
				</div>

                <!-- Button trigger modal -->
				<button type="button" class="searchlist" data-bs-toggle="modal" data-bs-target="#exampleModal">
					Add Category
				</button>
				
				<!-- Modal -->
				<div class="modal fade bd-example-modal-md" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-md">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<form method="POST" action="action/addCategory.php" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="form-row">
                                    <div class="col">
										<div class="form-group">
											<label for="job" class="label-name">JOB</label>
											<select class="form-select" id="job" name="id_job" required>
												<option value="">Pilih Job</option>
												<?php
													$result = $db->query('SELECT * FROM job');

													while ($data = $result->fetch_object()):
												?>
													<option value="<?php echo $data->id ?>"><?php echo $data->job ?></option>
												<?php endwhile ?>
											</select>
										</div>

                                        <div class="form-group">
                                            <label for="inputkategori" class="label-name">KATEGORI</label>
                                            <input type="text" class="form-control" name="kategori" id="inputkategori" placeholder="Masukan Kategori" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="modal-btn-cancel" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="modal-btn-add" name="add" value="add">Add</button>
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
								<th>PEKERJAAN</th>
								<th>KATEGORI</th>
								<th>ACTION</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$query = "SELECT * FROM job INNER JOIN kategori ON job.id = kategori.id_job ORDER BY id_job ASC";
							$result = $db->query($query);
							$no = 0;

							while ($row = $result->fetch_assoc()) {
								$no++;
							?>
								<tr>
									<td><?php echo $no; ?></td>
									<td><?php 
											if ($row['job'] == 'RAPAT') {
												echo '<span class="badge rounded-pill bg-danger" >RAPAT</span>';
											} elseif ($row['job'] == 'TUGAS') {
												echo '<span class="badge rounded-pill bg-success" >TUGAS</span>';
											} elseif ($row['job'] == 'DINAS') {
												echo '<span class="badge rounded-pill bg-warning">DINAS</span>';
											}
										?>
									</td>
									<td><?php echo $row['kategori']; ?></td>
									<td>
										<a href="" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $row['id_kat']; ?>"><i class='bx bxs-edit'></i></a>
										<a href="action/delCategory.php?id_kat=<?php echo $row['id_kat']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')"><i class='bx bxs-trash' ></i></a>
										
										<!-- Edit Modal -->
										<div class="modal fade bd-example-modal-md" id="exampleModal<?php echo $row['id_kat']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
											<div class="modal-dialog modal-md">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
													<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
												</div>
												<form method="POST" action="action/editCategory.php" enctype="multipart/form-data">
													<div class="modal-body">
														<div class="form-row">
															<div class="col">
																<input type="text" name="id_kat" value="<?php echo $row['id_kat']; ?>" hidden>
																<div class="form-group">
																	<label for="job" class="label-name">JOB</label>
																	<select class="form-select" id="job" name="job" disabled>
																		<option value="0">Pilih Job</option>
																		<option <?= $row['job'] == 'RAPAT' ? 'selected' : '' ?> value="RAPAT">RAPAT</option>
																		<option <?= $row['job'] == 'TUGAS' ? 'selected' : '' ?> value="TUGAS">TUGAS</option>
																		<option <?= $row['job'] == 'DINAS' ? 'selected' : '' ?> value="DINAS">DINAS</option>
																	</select>
																</div>

																<div class="form-group">
																	<label for="inputkategori" class="label-name">KATEGORI</label>
																	<input type="text" class="form-control" name="kategori" id="inputkategori" value="<?php echo $row['kategori']; ?>" required>
																</div>
															</div>
														</div>
													</div>
													<div class="modal-footer">
														<button type="button" class="modal-btn-cancel" data-bs-dismiss="modal">Cancel</button>
														<button type="submit" class="modal-btn-add" name="save" value="save">Save</button>
													</div>
												</form>
											</div>
											</div>
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
    <!-- <script defer src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js" integrity="sha512-FHZVRMUW9FsXobt+ONiix6Z0tIkxvQfxtCSirkKc5Sb4TKHmqq1dZa8DphF0XqKb3ldLu/wgMa8mT6uXiLlRlw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script defer src="../assets/js/script.js"></script>
    <script defer src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script defer src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->

</body>
</html>
