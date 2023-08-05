<?php
session_start();
require_once('auth/db_login.php');
if(!isset($_SESSION['username'])){
    header('Location: login.php');
}

$username = $_SESSION['username'];
$login = $db->query("SELECT * FROM user WHERE username='$username'");

$result = $login->fetch_object();

$thisPage = "Dashboard";
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
	
	<!-- CSS for full calender -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" rel="stylesheet" />

	<!-- JS for jQuery -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<!-- JS for full calender -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>

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
					<center><h1>Dashboard</h1></center>
					<ul class="breadcrumb">
						<ul class="asd"></ul>
					</ul>
				</div>
				<a href="#" class="btn-download" disabled>
					<span class="text">
					<?php
					// set zona waktu ke Asia/Jakarta
					date_default_timezone_set('Asia/Jakarta');

					// menampilkan waktu saat ini di Indonesia dengan label WIB
					echo date('d-m-Y h:i:s A') ;
					?>
					</span>
				</a>
			</div>
			
			<div class="table-data">
				<div id="calendar"></div>
				<div style="width: 100%;">
					<span><h3>Today's Joblist</h3></span>
					<br>
					<table id="example" class="table table-striped " style="width:100%">
						<thead style="text-align:center;">
									<tr>
										<th>NO</th>
										<th>JOBLIST</th>
										<th>STATUS</th>
										<th>START DATE</th>
										<th>END DATE</th>
										<th>CATEGORY</th>
										<th>PIC</th>
										<th>ACTION</th>
									</tr>
						</thead>
						<tbody>
						<?php
						$query_param = $_SERVER['QUERY_STRING'];
						$query = "";
						if ($query_param) {
							$name = strtolower(explode("=", $query_param)[1]);
							$query = "SELECT * FROM joblist WHERE LOWER(judul) LIKE '%$name%";
						} else {
							$username = $_SESSION['username'];
							$initial = "SELECT * FROM user WHERE username='$username'";
							$hasil = $db->query($initial);
							$data = $hasil->fetch_assoc();

							$query = "SELECT * FROM joblist WHERE PIC LIKE '%".$data['initial_name']."%' AND (DATE(NOW()) BETWEEN DATE(start_date) AND DATE(end_date))";
						}
						$result = $db->query($query);
						$no = 1;

						while ($row = $result->fetch_assoc()) {
						?>
							<tr>
								<td><?php echo $no++; ?></td>
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
	$(document).ready(function() {
	display_events();
	});

	function display_events() {
		var events = new Array();
		$.ajax({
			url: 'action/displayCal.php',
			dataType: 'json',
			success: function(response) {

				var result = response.data;
				$.each(result, function(i, item) {
					events.push({
						id: result[i].id,
						title: result[i].title,
						pic: result[i].pic,
						start: result[i].start,
						end: result[i].end,
						color: result[i].color,
						grup: result[i].grup,
						judul: result[i].judul,
						deskripsi: result[i].deskripsi,
						title_kategori: result[i].title_kategori,
						sub_kategori: result[i].sub_kategori
					});
				})
				var calendar = $('#calendar').fullCalendar({
					defaultView: 'month',
					timeZone: 'local',
					select: function(start, end) {
						//alert(start);
						//alert(end);
						$('#start_date').val(moment(start).format('YYYY-MM-DD'));
						$('#end_date').val(moment(end).format('YYYY-MM-DD'));
					},
					events: events,
					eventRender: function(event, element) {
						// Menginisialisasi popover untuk setiap event
						element.popover({
							title: event.title_kategori,
							content: '<strong>PIC:</strong> ' + event.pic + '<br>' +
								'<strong>Kategori:</strong> ' + event.sub_kategori + '<br>' +
								'<strong>Grup:</strong> ' + event.grup + '<br>' +
								'<strong>Judul:</strong> ' + event.judul + '<br>' +
								'<strong>Deskripsi:</strong> ' + event.deskripsi + '<br>',
								// '<strong>Start Date:</strong> ' + moment(event.start).format('D MMMM YYYY HH:mm:ss') + '<br>' +
								// '<strong>End Date:</strong> ' + moment(event.end).format('D MMMM YYYY HH:mm:ss'),
							html: true,
							placement: 'top',
							trigger: 'hover'
						});
					}
				}); //end fullCalendar block	
			}, //end success block
			error: function(xhr, status) {
				alert(response.msg);
			}
		}); //end ajax block	
	}
	</script>
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.0/js/bootstrap.bundle.min.js"></script>

	<!-- <script defer src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
	<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js" integrity="sha512-FHZVRMUW9FsXobt+ONiix6Z0tIkxvQfxtCSirkKc5Sb4TKHmqq1dZa8DphF0XqKb3ldLu/wgMa8mT6uXiLlRlw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script defer src="../assets/js/script.js"></script>
	<script defer src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
	<script defer src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
	<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
	
</body>
</html>
