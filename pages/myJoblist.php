<?php
session_start();
require_once('auth/db_login.php');
if(!isset($_SESSION['username'])){
    header('Location: login.php');
}

$username = $_SESSION['username'];
$login = $db->query("SELECT * FROM user WHERE username='$username'");

$result = $login->fetch_object();

$thisPage = "My Joblist";
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
			<div class="head-title">
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
					<center><h1>Joblist</h1></center>
				</div>
				<?php if ($_SESSION['role'] != 'Pegawai'){ ?>
				<div class="modall">
				<button class="searchlist" onclick="window.location.href='../files/Notulen Rapat (Template).docx'" download>Template Notulen</button>
					<!-- Button trigger modal -->
					<button type="button" class="searchlist" data-bs-toggle="modal" data-bs-target="#exampleModal">
						Add Joblist
					</button>
				</div>
				<!-- Modal -->
				<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Add Joblist</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<form method="POST" action="action/addJob.php" enctype="multipart/form-data">
							<div class="modal-body">
								<div class="container-fluid">
									<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="inputgrup" class="label-name">GRUP</label>
											<select class="form-select" name="grup" placeholder="pilih grup" required>
												<option selected value="">Pilih Grup</option>
												<option value="ADMINISTRASI">ADMINISTRASI</option>
												<option value="ALL GRUP">ALL GRUP</option>
												<option value="ARSIP">ARSIP</option>
												<option value="BINALAVOTAS">BINALAVOTAS</option>
												<option value="BINAPENTA & PASKER">BINAPENTA & PASKER</option>
												<option value="BINWASNAKER & PHI">BINWASNAKER & PHI</option>
												<option value="DEVELOPMENT & DWH">DEVELOPMENT & DWH</option>
												<option value="DISPOSISI">DISPOSISI</option>
												<option value="INTERNAL">INTERNAL</option>
												<option value="PROJECT">PROJECT</option>
											</select>
										</div>
					
										<div class="form-group">
											<label for="inputgrup" class="label-name">JUDUL</label>
											<input type="text" class="form-control" name="judul" placeholder="Masukan Judul" required>
										</div>
					
										<div class="form-group">
											<label for="inputgrup" class="label-name">DESKRIPSI</label>
											<textarea class="form-control" name="deskripsi" rows="3" placeholder="Masukan Deskripsi" required></textarea>
										</div>

										<div class="form-group">
											<label for="inputgrup" class="label-name">PIC</label>
											<select id="PIC" name="PIC[]" class="selectpicker form-control" multiple aria-label="size 3 select example" required>
												<?php
												$query = "SELECT * FROM user";
												$result = $db->query($query);
												$no = 0;

												while ($row = $result->fetch_assoc()) {
													$no++;
												?>
													<option value="<?php echo $row['initial_name']; ?>"><?php echo $row['nama_lengkap'] . ", " . $row['initial_name']; ?></option>
												<?php
												}
												?>
											</select>
										</div>

										<div class="form-group">
											<label for="inputgrup" class="label-name">STATUS</label>
											<select class="form-select" name="status" placeholder="Pilih Status" required>
												<option value="">Pilih Status</option>
												<option value="OPEN" selected>OPEN</option>
												<option value="PROCESS">PROCESS</option>
												<option value="REPORT">REPORT</option>
												<option value="CLOSE">CLOSE</option>
												<option value="SUNDUL">SUNDUL</option>
												<option value="USULAN">USULAN</option>
												<option value="INFORMASI">INFORMASI</option>
												<option value="MONITOR">MONITOR</option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="job" class="label-name">JOB</label>
											<select class="form-select" id="job" name="job" required>
												<option value="0">Pilih Job</option>
												<?php
													$result = $db->query('SELECT * FROM job');

													while ($data = $result->fetch_object()):
												?>
													<option value="<?php echo $data->job ?>"><?php echo $data->job ?></option>
												<?php endwhile ?>
											</select>
										</div>

										<div class="form-group">
											<label for="inputgrup" class="label-name">KATEGORI</label>
											<select class="form-select" id="kategori" name="kategori" placeholder="Pilih Kategori" required>
												<option value="0">Pilih Kategori</option>
											</select>
										</div>

										<div class="form-group">
											<label for="inputgrup" class="label-name">START DATE</label>
											<input type="datetime-local" class="form-control" name="start_date" required>
										</div>
					
										<div class="form-group">
											<label for="inputgrup" class="label-name">END DATE</label>
											<input type="datetime-local" class="form-control" name="end_date" required>
										</div>
					
										<div class="form-group">
											<label for="inputgrup" class="label-name">AGENDA</label>
											<select class="form-select" name="agenda" placeholder="Pilih Agenda" required>
												<option selected value="">Pilih Agenda</option>
												<option value="AGENDA">AGENDA</option>
												<option value="NON AGENDA">NON AGENDA</option>
											</select>
										</div>

										<div class="form-group">
											<label for="formFile" class="label-name">FILE LAMPIRAN</label>
											<input type="file" class="form-control" name="file">
										</div>
									</div>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="modal-btn-cancel" data-bs-dismiss="modal">Cancel</button>
								<button type="submit" class="modal-btn-add">Add</button>
							</div>
						</form>
					</div>
					</div>
				</div>
				<?php } ?>
			</div>

			<ul class="box-info">
				<li>
					<i class='bx bxs-file-blank' ></i>
					<a class="text" href="myJoblist.php">
						<center><h3>My Job</h3></center>
					</a>
				</li>
				<li>
					<i class='bx bxs-file'></i>
					<a class="text" href="groupJoblist.php">
						<center><h3>Group Job</h3></center>
					</a>
				</li>
				<li>
					<i class='bx bxs-data' ></i>
					<a class="text" href="joblist.php">
						<center><h3>All Job</h3></center>
					</a>
				</li>
			</ul>
			
			<div class="table-data">
				<div style="width: 100%;">
					<span><h3>Joblist</h3></span>
                    <div class="card">
						<div class="card-header">
							<a class="btn btn-primary" href="export.php" role="button">Export</a>
						</div>
						<div class="card-body">
							<form action="joblist.php" method="get">
								<div class="row g-3 align-items-center">
									<div class="col-auto">
										<input type="date" class="form-control" name="dari" >
									</div>
									<div class="col-auto">
										-
									</div>
									<div class="col-auto">
										<input type="date" class="form-control" name="ke" >
									</div>
									<div class="col-auto" style="margin-top: 6px;">
										<button class="bx bx-search-alt-2" type="submit"></button>
									</div>
									<div class="col-auto" style="margin-top: 6px;">
										<button class="bx bx-refresh" onclick="window.location.href='myjoblist.php'"></button>
									</div>
								</div>
							</form>
                            <table id="example" class="table table-striped" style="width:100%">
                                <thead style="text-align-last:center;">
                                    <tr>
                                    <th>NO</th>
                                    <th>JOBLIST
                                        <select id="joblistFilter" class="table-filter" onchange="filterTable()"style="border-radius: 8px;">
                                        <option value="all"></option>
                                        <option value="ADMINISTRASI">ADMINISTRASI</option>
                                        <option value="ALL GRUP">ALL GRUP</option>
                                        <option value="ARSIP">ARSIP</option>
                                        <option value="BINALAVOTAS">BINALAVOTAS</option>
                                        <option value="BINAPENTA&PASKER">BINAPENTA & PASKER</option>
                                        <option value="BINWASNAKER&PHI">BINWASNAKER & PHI</option>
                                        <option value="DEVELOPMENT&DWH">DEVELOPMENT & DWH</option>
                                        <option value="DISPOSISI">DISPOSISI</option>
                                        <option value="INTERNAL">INTERNAL</option>
                                        <option value="PROJECT">PROJECT</option>
                                        </select>
                                    </th>
                                    <th>STATUS
                                        <select id="statusFilter" class="table-filter" onchange="filterTable()" style="border-radius: 8px;">
                                        <option value="all"></option>
                                        <option value="OPEN">OPEN</option>
                                        <option value="CLOSE">CLOSE</option>
                                        <option value="REPORT">REPORT</option>
                                        <option value="PROCESS">PROCESS</option>
                                        <option value="SUNDUL">SUNDUL</option>
                                        <option value="USULAN">USULAN</option>
                                        <option value="INFORMASI">INFORMASI</option>
                                        <option value="MONITOR">MONITOR</option>
                                        </select>
                                    </th>
                                    <th>START DATE</th>
                                    <th>END DATE</th>
                                    <th>CATEGORY
                                        <select id="categoryFilter" class="table-filter" onchange="filterTable()" style="border-radius: 8px;">
                                        <option value="all"></option>
                                        <option value="TUGAS">TUGAS</option>
                                        <option value="RAPAT">RAPAT</option>
                                        <option value="DINAS">DINAS</option>
                                        </select>
                                    </th>
                                    <th>PIC</th>
                                    <th>ACTION</th>
                                    </tr>
                                </thead>

                                <tbody style="text-align-last:center;">
								<?php
									if (isset($_GET['dari']) && !empty($_GET['dari'])) {
										$query = "SELECT * FROM joblist WHERE start_date >= '".$_GET['dari']."'";
									} elseif (isset($_GET['dari']) && isset($_GET['ke'])) {
										$query = "SELECT * FROM joblist WHERE (start_date BETWEEN '".$_GET['dari']."' and '".$_GET['ke']."') OR (end_date BETWEEN '".$_GET['dari']."' and '".$_GET['ke']."')";
									} else {
										$username = $_SESSION['username'];
										$initial = "SELECT * FROM user WHERE username='$username'";
										$hasil = $db->query($initial);
										$data = $hasil->fetch_assoc();

										$query = "SELECT * FROM joblist WHERE PIC LIKE '%".$data['initial_name']."%'";
									}

									$result = $db->query($query);

									while ($row = $result->fetch_assoc()) {
										?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td>
                                                <div class="badge bg-secondary text-uppercase"><?php echo $row['grup']; ?></div>
                                                <div><?php echo $row['judul']; ?></div>
                                                <div><p>Input By: <?php echo strtoupper($row['input_by']); ?></p></div>
                                                <div>
                                                    <?php
                                                    if ($row['report_by'] != '') {
                                                        echo strtoupper('<p>Report By: ' . $row['report_by'] . '</p>');
                                                    }
                                                    ?>
                                                </div>
                                            </td>
                                            <td>
												<?php
												$status = $row['status'];

												$statusClass = '';
												$statusText = '';

												switch ($status) {
													case 'OPEN':
														$statusClass = 'bg-success';
														$statusText = 'OPEN';
														break;
													case 'REPORT':
														$statusClass = 'bg-warning';
														$statusText = 'REPORT';
														break;
													case 'CLOSE':
														$statusClass = 'bg-danger';
														$statusText = 'CLOSE';
														break;
													case 'PROCESS':
														$statusClass = 'bg-primary';
														$statusText = 'PROCESS';
														break;
													case 'SUNDUL':
														$statusClass = 'bg-secondary';
														$statusText = 'SUNDUL';
														break;
													case 'USULAN':
														$statusClass = 'bg-info';
														$statusText = 'USULAN';
														break;
													case 'INFORMASI':
														$statusClass = 'bg-light text-dark';
														$statusText = 'INFORMASI';
														break;
													case 'MONITOR':
														$statusClass = 'bg-dark text-white';
														$statusText = 'MONITOR';
														break;
												}

												echo '<span class="badge rounded-pill ' . $statusClass . '">' . $statusText . '</span>';
												?>
											</td>
                                            <td><?php echo $row['start_date']; ?></td>
                                            <td><?php echo $row['end_date']; ?></td>
                                            <td>
												<?php
												$job = $row['job'];

												$jobClass = '';
												$jobText = '';

												switch ($job) {
													case 'TUGAS':
														$jobClass = 'bg-success';
														$jobText = 'TUGAS';
														break;
													case 'RAPAT':
														$jobClass = 'bg-danger';
														$jobText = 'RAPAT';
														break;
													case 'DINAS':
														$jobClass = 'bg-warning';
														$jobText = 'DINAS';
														break;
												}

												echo '<span class="badge rounded-pill ' . $jobClass . '">' . $jobText . '</span>';
												?>
											</td>
											<td><?php echo strtoupper( $row['PIC']); ?></td>
											<td>
												<a href="" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#infoModal<?php echo $row['id']; ?>"><i class='bx bxs-info-square' ></i></a>
												<!-- Info Modal -->
												<div class="modal fade bd-example-modal-lg" id="infoModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
													<div class="modal-dialog modal-lg">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title" id="exampleModalLabel">Detail Joblist</h5>
															<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
														</div>
														<form>
															<div class="modal-body">
																<div class="container-fluid">
																	<div class="row">
																	<div class="col-md-6">
																		<div class="form-group">
																			<label for="inputgrup" class="label-name">GRUP</label>
																			<input type="text" class="form-control" name="grup" value="<?php echo $row['grup']; ?>" readonly>
																		</div>
													
																		<div class="form-group">
																			<label for="inputgrup" class="label-name">JUDUL</label>
																			<input type="text" class="form-control" name="judul" value="<?php echo $row['judul']; ?>" readonly>
																		</div>
													
																		<div class="form-group">
																			<label for="inputgrup" class="label-name">DESKRIPSI</label>
																			<textarea class="form-control" name="deskripsi" rows="3" readonly><?php echo $row['deskripsi']; ?></textarea>
																		</div>

																		<div class="form-group">
																			<label for="inputgrup" class="label-name">PIC</label>
																			<input type="text" class="form-control" name="PIC" value="<?php echo $row['PIC']; ?>" readonly>
																		</div>

																		<div class="form-group">
																			<label for="inputgrup" class="label-name">STATUS</label>
																			<input type="text" class="form-control" name="status" value="<?php echo $row['status']; ?>" readonly>
																		</div>

																		<div class="form-group">
																			<label for="inputjob" class="label-name">JOB</label>
																			<input type="text" class="form-control" name="job" value="<?php echo $row['job']; ?>" readonly>
																		</div>

																		<div class="form-group">
																			<label for="inputkategori" class="label-name">KATEGORI</label>
																			<input type="text" class="form-control" name="kategori" value="<?php echo $row['kategori']; ?>" readonly>
																		</div>
																	</div>
																	<div class="col-md-6">
																		<div class="form-group">
																			<label for="inputgrup" class="label-name">START DATE</label>
																			<input type="datetime-local" class="form-control" name="start_date" value="<?php echo $row['start_date']; ?>" readonly>
																		</div>
													
																		<div class="form-group">
																			<label for="inputgrup" class="label-name">END DATE</label>
																			<input type="datetime-local" class="form-control" name="end_date" value="<?php echo $row['end_date']; ?>" readonly>
																		</div>
													
																		<div class="form-group">
																			<label for="inputgrup" class="label-name">AGENDA</label>
																			<input type="text" class="form-control" name="agenda" value="<?php echo $row['agenda']; ?>" readonly>
																		</div>

																		<div class="form-group">
																			<label for="formFile" class="label-name">FILE LAMPIRAN</label>
																			<!-- check if file_lampiran = '' -->
																			<?php if($row['file_lampiran'] == ''){ ?>
																				<!-- <input type="text" class="form-control" name="file_lampiran" value="Tidak ada file lampiran" > -->
																			<?php }else{ ?>
																				<a href="../files/lampiran/<?php echo $row['file_lampiran']; ?>" target="_blank" class="form-control btn btn-sm">Lihat File</a>
																			<?php } ?>
																		</div>
																		<div class="form-group">
																			<label for="formFile" class="label-name">FILE REPORT</label>
																			<?php if($row['file_report'] == ''){ ?>
																				<!-- <input type="text" class="form-control" name="file_report" value="Tidak ada file lampiran" > -->
																			<?php }else{ ?>
																				<a href="../files/report/<?php echo $row['file_report']; ?>" target="_blank" class="form-control btn btn-sm">Lihat File</a>
																			<?php } ?>
																		</div>
																		<div class="form-group">
																			<label for="inputgrup" class="label-name">CATATAN LAPORAN</label>
																			<textarea class="form-control" name="catatan" rows="3" readonly><?php echo $row['catatan']; ?></textarea>
																		</div>
																	</div>
																	</div>
																</div>
															</div>
															<div class="modal-footer">
															</div>
														</form>
													</div>
													</div>
												</div>
												<?php if ($_SESSION['role'] == 'Pegawai') { ?>
												<a href="" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['id']; ?>"><i class='bx bxs-edit' ></i></a>
												<!-- Edit Modal -->
												<div class="modal fade bd-example-modal-lg" id="editModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
													<div class="modal-dialog modal-lg">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title" id="exampleModalLabel">Edit Joblist</h5>
															<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
														</div>
														<form method="POST" action="action/editJob.php" enctype="multipart/form-data">
															<div class="modal-body">
																<div class="container-fluid">
																	<div class="row">
																	<div class="col-md-6">
																		<div class="form-group">
																			<label for="inputgrup" class="label-name">GRUP</label>
																			<input type="text" class="form-control" name="grup" value="<?php echo $row['grup']; ?>" readonly>
																		</div>
													
																		<div class="form-group">
																			<label for="inputgrup" class="label-name">JUDUL</label>
																			<input type="text" class="form-control" name="judul" value="<?php echo $row['judul']; ?>" readonly>
																		</div>
													
																		<div class="form-group">
																			<label for="inputgrup" class="label-name">DESKRIPSI</label>
																			<textarea class="form-control" name="deskripsi" rows="3" readonly><?php echo $row['deskripsi']; ?></textarea>
																		</div>

																		<div class="form-group">
																			<label for="inputgrup" class="label-name">PIC</label>
																			<input type="text" class="form-control" name="PIC" value="<?php echo $row['PIC']; ?>" readonly>
																		</div>

																		<div class="form-group">
																			<label for="inputgrup" class="label-name">STATUS</label>
																			<select class="form-select" name="status" id="status">
																				<option default disabled>Pilih Status</option>
																				<option <?= $row['status'] == 'OPEN' ? 'selected' : '' ?> value="OPEN" disabled>OPEN</option>
																				<option <?= $row['status'] == 'PROCESS' ? 'selected' : '' ?> value="PROCESS" disabled>PROCESS</option>
																				<option <?= $row['status'] == 'REPORT' ? 'selected' : '' ?> value="REPORT">REPORT</option>
																				<option <?= $row['status'] == 'CLOSE' ? 'selected' : '' ?> value="CLOSE" disabled>CLOSE</option>
																				<option <?= $row['status'] == 'SUNDUL' ? 'selected' : '' ?> value="SUNDUL" disabled>SUNDUL</option>
																				<option <?= $row['status'] == 'USULAN' ? 'selected' : '' ?> value="USULAN" disabled>USULAN</option>
																				<option <?= $row['status'] == 'INFORMASI' ? 'selected' : '' ?> value="INFORMASI" disabled>INFORMASI</option>
																				<option <?= $row['status'] == 'MONITOR' ? 'selected' : '' ?> value="MONITOR" disabled>MONITOR</option>
																			</select>
																		</div>

																		<div class="form-group">
																			<label for="job" class="label-name">JOB</label>
																			<select class="form-select" id="job" name="id_job" disabled>
																				<option value="0">Pilih Job</option>
																				<option <?= $row['job'] == 'RAPAT' ? 'selected' : '' ?> value="RAPAT">RAPAT</option>
																				<option <?= $row['job'] == 'TUGAS' ? 'selected' : '' ?> value="TUGAS">TUGAS</option>
																				<option <?= $row['job'] == 'DINAS' ? 'selected' : '' ?> value="DINAS">DINAS</option>
																			</select>
																		</div>

																		<div class="form-group">
																			<label for="inputkategori" class="label-name">KATEGORI</label>
																			<input type="text" class="form-control" name="kategori" value="<?php echo $row['kategori']; ?>" readonly>
																		</div>
																	</div>
																	<div class="col-md-6">
																		<div class="form-group">
																			<label for="inputgrup" class="label-name">END DATE</label>
																			<input type="date" class="form-control" name="end_date" value="<?php echo $row['end_date']; ?>" readonly>
																		</div>
																		
																		<div class="form-group">
																			<label for="inputgrup" class="label-name">TARGET TIME</label>
																			<input type="time" class="form-control" name="target_time" value="<?php echo $row['target_time']; ?>" readonly>
																		</div>
													
																		<div class="form-group">
																			<label for="inputgrup" class="label-name">AGENDA</label>
																			<input type="text" class="form-control" name="agenda" value="<?php echo $row['agenda']; ?>" readonly>
																		</div>

																		<div class="form-group">
																			<label for="formFile" class="label-name">FILE LAMPIRAN</label>
																			<input type="file" class="form-control" name="file" readonly>
																		</div>

																		<div class="form-group">
																			<label for="formFile" class="label-name">FILE LAPORAN</label>
																			<input type="file" class="form-control" name="fileReport">
																		</div>

																		<div class="form-group">
																			<label for="inputgrup" class="label-name">CATATAN LAPORAN</label>
																			<textarea class="form-control" name="catatan" rows="3"><?php echo $row['catatan']; ?></textarea>
																		</div>
																	</div>
																	</div>
																</div>
															</div>
															<div class="modal-footer">
																<button type="submit" class="modal-btn-add" name="save">Save</button>
															</div>
														</form>
													</div>
													</div>
												</div>
												<?php } else if ($_SESSION['role'] == 'Ketua') { ?>
												<a href="" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['id']; ?>"><i class='bx bxs-edit' ></i></a>
												<!-- Edit Modal -->
												<div class="modal fade bd-example-modal-lg" id="editModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
													<div class="modal-dialog modal-lg">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title" id="exampleModalLabel">Edit Joblist</h5>
															<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
														</div>
														<form method="POST" action="action/editJob.php" enctype="multipart/form-data">
															<div class="modal-body">
																<div class="container-fluid">
																	<div class="row">
																	<div class="col-md-6">
																		<div class="form-group">
																			<label for="inputgrup" class="label-name">GRUP</label>
																			<select class="form-select" name="grup" id="inputgrup">
																				<option default value="" disabled>Pilih Grup</option>
																				<option <?= $row['grup'] == 'ADMINISTRASI' ? 'selected' : '' ?> value="ADMINISTRASI">ADMINISTRASI</option>
																				<option <?= $row['grup'] == 'ALL GRUP' ? 'selected' : '' ?> value="ALL GRUP">ALL GRUP</option>
																				<option <?= $row['grup'] == 'ARSIP' ? 'selected' : '' ?> value="ARSIP">ARSIP</option>
																				<option <?= $row['grup'] == 'BINALAVOTAS' ? 'selected' : '' ?> value="BINALAVOTAS">BINALAVOTAS</option>
																				<option <?= $row['grup'] == 'BINAPENTA & PASKER' ? 'selected' : '' ?> value="BINAPENTA & PASKER">BINAPENTA & PASKER</option>
																				<option <?= $row['grup'] == 'BINWASKER & PHI' ? 'selected' : '' ?> value="BINWASKER & PHI">BINWASKER & PHI</option>
																				<option <?= $row['grup'] == 'DEVELOPMENT & DWH' ? 'selected' : '' ?> value="DEVELOPMENT & DWH">DEVELOPMENT & DWH</option>
																				<option <?= $row['grup'] == 'DISPOSISI' ? 'selected' : '' ?> value="DISPOSISI">DISPOSISI</option>
																				<option <?= $row['grup'] == 'INTERNAL' ? 'selected' : '' ?> value="INTERNAL">INTERNAL</option>
																				<option <?= $row['grup'] == 'PROJECT' ? 'selected' : '' ?> value="PROJECT">PROJECT</option>
																			</select>
																		</div>
													
																		<div class="form-group">
																			<label for="inputgrup" class="label-name">JUDUL</label>
																			<input type="text" class="form-control" name="judul" value="<?php echo $row['judul']; ?>">
																		</div>
													
																		<div class="form-group">
																			<label for="inputgrup" class="label-name">DESKRIPSI</label>
																			<textarea class="form-control" name="deskripsi" rows="3" ><?php echo $row['deskripsi']; ?></textarea>
																		</div>

																		<div class="form-group">
																			<label for="inputgrup" class="label-name">PIC</label>
																			<select id="PIC" name="PIC[]" class="selectpicker form-control" multiple aria-label="size 3 select example" placeholder="Pilih PIC" required>
																				<?php
																				$data = "SELECT * FROM user";
																				$hasil = $db->query($data);

																				while ($pic = $hasil->fetch_assoc()) {
																				?>
																					<option value="<?php echo $pic['initial_name']; ?>"><?php echo $pic['nama_lengkap'] . ", " . $pic['initial_name']; ?></option>
																				<?php
																				}
																				?>
																			</select>
																		</div>

																		<div class="form-group">
																			<label for="inputgrup" class="label-name">STATUS</label>
																			<select class="form-select" name="status" id="status">
																				<option default disabled>Pilih Status</option>
																				<option <?= $row['status'] == 'OPEN' ? 'selected' : '' ?> value="OPEN">OPEN</option>
																				<option <?= $row['status'] == 'PROCESS' ? 'selected' : '' ?> value="PROCESS">PROCESS</option>
																				<option <?= $row['status'] == 'REPORT' ? 'selected' : '' ?> value="REPORT">REPORT</option>
																				<option <?= $row['status'] == 'CLOSE' ? 'selected' : '' ?> value="CLOSE">CLOSE</option>
																				<option <?= $row['status'] == 'SUNDUL' ? 'selected' : '' ?> value="SUNDUL" disabled>SUNDUL</option>
																				<option <?= $row['status'] == 'USULAN' ? 'selected' : '' ?> value="USULAN" disabled>USULAN</option>
																				<option <?= $row['status'] == 'INFORMASI' ? 'selected' : '' ?> value="INFORMASI" disabled>INFORMASI</option>
																				<option <?= $row['status'] == 'MONITOR' ? 'selected' : '' ?> value="MONITOR" disabled>MONITOR</option>
																			</select>
																		</div>

																		<div class="form-group">
																			<label for="job" class="label-name">JOB</label>
																			<select class="form-select" id="job" name="job" disabled>
																				<option selected value="">Pilih Job</option>
																				<option <?= $row['job'] == 'TUGAS' ? 'selected' : '' ?> value="TUGAS">TUGAS</option>
																				<option <?= $row['job'] == 'RAPAT' ? 'selected' : '' ?> value="RAPAT">RAPAT</option>
																				<option <?= $row['job'] == 'DINAS' ? 'selected' : '' ?> value="DINAS">DINAS</option>
																			</select>
																		</div>
																		
																		<div class="form-group">
																			<label for="inputgrup" class="label-name">KATEGORI</label>
																			<select class="form-select" name="kategori" placeholder="Pilih Kategori" disabled>
																				<option selected value="">Pilih Kategori</option>
																				<option <?= $row['kategori'] == 'TUGAS INDVIDU' ? 'selected' : '' ?> value="TUGAS INDVIDU">TUGAS INDVIDU</option>
																				<option <?= $row['kategori'] == 'TUGAS GRUP' ? 'selected' : '' ?> value="TUGAS GRUP">TUGAS GRUP</option>
																				<option <?= $row['kategori'] == 'RAPAT HARIAN' ? 'selected' : '' ?> value="RAPAT HARIAN">RAPAT HARIAN</option>
																				<option <?= $row['kategori'] == 'RAPAT MINGGUAN' ? 'selected' : '' ?> value="RAPAT MINGGUAN">RAPAT MINGGUAN</option>
																				<option <?= $row['kategori'] == 'RAPAT BULANAN' ? 'selected' : '' ?> value="RAPAT BULANAN">RAPAT BULANAN</option>
																				<option <?= $row['kategori'] == 'RAPAT TAHUNAN' ? 'selected' : '' ?> value="RAPAT TAHUNAN">RAPAT TAHUNAN</option>
																				<option <?= $row['kategori'] == 'DINAS HARIAN' ? 'selected' : '' ?> value="DINAS HARIAN">DINAS HARIAN</option>
																				<option <?= $row['kategori'] == 'DINAS MINGGUAN' ? 'selected' : '' ?> value="DINAS MINGGUAN">DINAS MINGGUAN</option>
																				<option <?= $row['kategori'] == 'DINAS BULANAN' ? 'selected' : '' ?> value="DINAS BULANAN">DINAS BULANAN</option>
																			</select>
																		</div>
																	</div>
																	<div class="col-md-6">
																		<div class="form-group">
																			<label for="inputgrup" class="label-name">END DATE</label>
																			<input type="datetime-local" class="form-control" name="end_date" value="<?php echo $row['end_date']; ?>">
																		</div>
													
																		<div class="form-group">
																			<label for="inputgrup" class="label-name">AGENDA</label>
																			<select class="form-select" name="agenda" id="inputagenda">
																				<option default>Pilih Agenda</option>
																				<option <?= $row['agenda'] == 'AGENDA' ? 'selected' : '' ?> value="AGENDA">AGENDA</option>
																				<option <?= $row['agenda'] == 'NON AGENDA' ? 'selected' : '' ?> value="NON AGENDA">NON AGENDA</option>
																			</select>
																		</div>

																		<div class="form-group">
																			<label for="formFile" class="label-name">FILE LAMPIRAN</label>
																			<input type="file" class="form-control" name="file">
																		</div>

																		<div class="form-group">
																			<label for="formFile" class="label-name">FILE LAPORAN</label>
																			<input type="file" class="form-control" name="fileReport">
																		</div>

																		<div class="form-group">
																			<label for="inputgrup" class="label-name">CATATAN LAPORAN</label>
																			<textarea class="form-control" name="catatan" rows="3"><?php echo $row['catatan']; ?></textarea>
																		</div>
																	</div>
																	</div>
																</div>
															</div>
															<div class="modal-footer">
																
																<button type="submit" class="modal-btn-add" name="save">Save</button>
															</div>
														</form>
													</div>
													</div>
												</div>
												<?php } else { ?>
												<a href="" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['id']; ?>"><i class='bx bxs-edit' ></i></a>
												<!-- Edit Modal -->
												<div class="modal fade bd-example-modal-lg" id="editModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
													<div class="modal-dialog modal-lg">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title" id="exampleModalLabel">Edit Joblist</h5>
															<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
														</div>
														<form method="POST" action="action/editJob.php" enctype="multipart/form-data">
															<div class="modal-body">
																<div class="container-fluid">
																	<div class="row">
																	<div class="col-md-6">
																		<div class="form-group">
																			<label for="inputgrup" class="label-name">GRUP</label>
																			<select class="form-select" name="grup" id="inputgrup">
																				<option default value="" disabled>Pilih Grup</option>
																				<option <?= $row['grup'] == 'ADMINISTRASI' ? 'selected' : '' ?> value="ADMINISTRASI">ADMINISTRASI</option>
																				<option <?= $row['grup'] == 'ALL GRUP' ? 'selected' : '' ?> value="ALL GRUP">ALL GRUP</option>
																				<option <?= $row['grup'] == 'ARSIP' ? 'selected' : '' ?> value="ARSIP">ARSIP</option>
																				<option <?= $row['grup'] == 'BINALAVOTAS' ? 'selected' : '' ?> value="BINALAVOTAS">BINALAVOTAS</option>
																				<option <?= $row['grup'] == 'BINAPENTA & PASKER' ? 'selected' : '' ?> value="BINAPENTA & PASKER">BINAPENTA & PASKER</option>
																				<option <?= $row['grup'] == 'BINWASKER & PHI' ? 'selected' : '' ?> value="BINWASKER & PHI">BINWASKER & PHI</option>
																				<option <?= $row['grup'] == 'DEVELOPMENT & DWH' ? 'selected' : '' ?> value="DEVELOPMENT & DWH">DEVELOPMENT & DWH</option>
																				<option <?= $row['grup'] == 'DISPOSISI' ? 'selected' : '' ?> value="DISPOSISI">DISPOSISI</option>
																				<option <?= $row['grup'] == 'INTERNAL' ? 'selected' : '' ?> value="INTERNAL">INTERNAL</option>
																				<option <?= $row['grup'] == 'PROJECT' ? 'selected' : '' ?> value="PROJECT">PROJECT</option>
																			</select>
																		</div>
													
																		<div class="form-group">
																			<label for="inputgrup" class="label-name">JUDUL</label>
																			<input type="text" class="form-control" name="judul" value="<?php echo $row['judul']; ?>">
																		</div>
													
																		<div class="form-group">
																			<label for="inputgrup" class="label-name">DESKRIPSI</label>
																			<textarea class="form-control" name="deskripsi" rows="3" ><?php echo $row['deskripsi']; ?></textarea>
																		</div>

																		<div class="form-group">
																			<label for="inputgrup" class="label-name">PIC</label>
																			<select id="PIC" name="PIC[]" class="selectpicker form-control" multiple aria-label="size 3 select example" placeholder="Pilih PIC" required>
																				<?php
																				$data = "SELECT * FROM user";
																				$hasil = $db->query($data);

																				while ($pic = $hasil->fetch_assoc()) {
																				?>
																					<option value="<?php echo $pic['initial_name']; ?>"><?php echo $pic['nama_lengkap'] . ", " . $pic['initial_name']; ?></option>
																				<?php
																				}
																				?>
																			</select>
																		</div>

																		<div class="form-group">
																			<label for="inputgrup" class="label-name">STATUS</label>
																			<select class="form-select" name="status" id="status">
																				<option default disabled>Pilih Status</option>
																				<option <?= $row['status'] == 'OPEN' ? 'selected' : '' ?> value="OPEN">OPEN</option>
																				<option <?= $row['status'] == 'PROCESS' ? 'selected' : '' ?> value="PROCESS">PROCESS</option>
																				<option <?= $row['status'] == 'REPORT' ? 'selected' : '' ?> value="REPORT">REPORT</option>
																				<option <?= $row['status'] == 'CLOSE' ? 'selected' : '' ?> value="CLOSE">CLOSE</option>
																				<option <?= $row['status'] == 'SUNDUL' ? 'selected' : '' ?> value="SUNDUL">SUNDUL</option>
																				<option <?= $row['status'] == 'USULAN' ? 'selected' : '' ?> value="USULAN">USULAN</option>
																				<option <?= $row['status'] == 'INFORMASI' ? 'selected' : '' ?> value="INFORMASI">INFORMASI</option>
																				<option <?= $row['status'] == 'MONITOR' ? 'selected' : '' ?> value="MONITOR">MONITOR</option>
																			</select>
																		</div>

																		<div class="form-group">
																			<label for="job" class="label-name">JOB</label>
																			<select class="form-select" name="job">
																				<option selected value="">Pilih Job</option>
																				<option <?= $row['job'] == 'TUGAS' ? 'selected' : '' ?> value="TUGAS">TUGAS</option>
																				<option <?= $row['job'] == 'RAPAT' ? 'selected' : '' ?> value="RAPAT">RAPAT</option>
																				<option <?= $row['job'] == 'DINAS' ? 'selected' : '' ?> value="DINAS">DINAS</option>
																			</select>
																		</div>

																		<div class="form-group">
																			<label for="inputgrup" class="label-name">KATEGORI</label>
																			<select class="form-select" name="kategori" placeholder="Pilih Kategori">
																				<option selected value="">Pilih Kategori</option>
																				<option <?= $row['kategori'] == 'TUGAS INDIVIDU' ? 'selected' : '' ?> value="TUGAS INDIVIDU">TUGAS INDIVIDU</option>
																				<option <?= $row['kategori'] == 'TUGAS GRUP' ? 'selected' : '' ?> value="TUGAS GRUP">TUGAS GRUP</option>
																				<option <?= $row['kategori'] == 'RAPAT HARIAN' ? 'selected' : '' ?> value="RAPAT HARIAN">RAPAT HARIAN</option>
																				<option <?= $row['kategori'] == 'RAPAT MINGGUAN' ? 'selected' : '' ?> value="RAPAT MINGGUAN">RAPAT MINGGUAN</option>
																				<option <?= $row['kategori'] == 'RAPAT BULANAN' ? 'selected' : '' ?> value="RAPAT BULANAN">RAPAT BULANAN</option>
																				<option <?= $row['kategori'] == 'RAPAT TAHUNAN' ? 'selected' : '' ?> value="RAPAT TAHUNAN">RAPAT TAHUNAN</option>
																				<option <?= $row['kategori'] == 'DINAS HARIAN' ? 'selected' : '' ?> value="DINAS HARIAN">DINAS HARIAN</option>
																				<option <?= $row['kategori'] == 'DINAS MINGGUAN' ? 'selected' : '' ?> value="DINAS MINGGUAN">DINAS MINGGUAN</option>
																				<option <?= $row['kategori'] == 'DINAS BULANAN' ? 'selected' : '' ?> value="DINAS BULANAN">DINAS BULANAN</option>
																			</select>
																		</div>
																	</div>
																	<div class="col-md-6">
																		<div class="form-group">
																			<label for="inputgrup" class="label-name">END DATE</label>
																			<input type="datetime-local" class="form-control" name="end_date" value="<?php echo $row['end_date']; ?>">
																		</div>
													
																		<div class="form-group">
																			<label for="inputgrup" class="label-name">AGENDA</label>
																			<select class="form-select" name="agenda" id="inputagenda">
																				<option default>Pilih Agenda</option>
																				<option <?= $row['agenda'] == 'AGENDA' ? 'selected' : '' ?> value="AGENDA">AGENDA</option>
																				<option <?= $row['agenda'] == 'NON AGENDA' ? 'selected' : '' ?> value="NON AGENDA">NON AGENDA</option>
																			</select>
																		</div>

																		<div class="form-group">
																			<label for="formFile" class="label-name">FILE LAMPIRAN</label>
																			<input type="file" class="form-control" name="file">
																		</div>

																		<div class="form-group">
																			<label for="formFile" class="label-name">FILE LAPORAN</label>
																			<input type="file" class="form-control" name="fileReport">
																		</div>

																		<div class="form-group">
																			<label for="inputgrup" class="label-name">CATATAN LAPORAN</label>
																			<textarea class="form-control" name="catatan" rows="3"><?php echo $row['catatan']; ?></textarea>
																		</div>
																	</div>
																	</div>
																</div>
															</div>
															<div class="modal-footer">
																<button type="submit" class="modal-btn-add" name="save">Save</button>
															</div>
														</form>
													</div>
													</div>
												</div>
												<a href="action/delJob.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')"><i class='bx bxs-trash' ></i></a>
												<?php } ?>
											</td>
										</tr>
									<?php
									}
									?>
                                </tbody>
                            </table> 
                    </div>
						</div>
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

	function filterTable() {
		var joblistFilter = document.getElementById("joblistFilter").value;
		var statusFilter = document.getElementById("statusFilter").value;
		var categoryFilter = document.getElementById("categoryFilter").value;

		var tableRows = document.querySelectorAll("#example tbody tr");

		tableRows.forEach(function(row) {
		var columns = row.querySelectorAll("td");
		var joblist = columns[1].querySelector(".badge").textContent.toUpperCase();
		var status = columns[2].querySelector(".badge").textContent.toLowerCase();
		var category = columns[5].querySelector(".badge").textContent.toUpperCase();

		if (
			(joblistFilter === "all" || joblist === joblistFilter.toUpperCase()) &&
			(statusFilter === "all" || status === statusFilter) &&
			(categoryFilter === "all" || category === categoryFilter.toUpperCase())
		) {
			row.style.display = "";
		} else {
			row.style.display = "none";
		}
		});
	}
	</script>

	<!-- Vendor JS Files -->
	<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script>
		var job = document.getElementById('job');
		job.onchange = function () {
			var xhr = new XMLHttpRequest();

			xhr.open('GET', './action/getKategori.php?job=' + job.value)

			xhr.onload = function() {
				kategori.innerHTML = xhr.responseText
    		}
    	xhr.send()
		}
	</script>
	
	
	<!-- Bootstrap JS File -->
	<script defer src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script defer src="../assets/js/script.js"></script>
	<script defer src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
	<script defer src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

	<!-- Multiselect JS File -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js" integrity="sha512-FHZVRMUW9FsXobt+ONiix6Z0tIkxvQfxtCSirkKc5Sb4TKHmqq1dZa8DphF0XqKb3ldLu/wgMa8mT6uXiLlRlw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	
	
</body>
</html>
