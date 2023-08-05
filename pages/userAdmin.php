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
    
    <!-- JS for graph -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

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
                <div class="table-data" style="flex: flex; background-color: #fff" hidden>
            <?php
                    $binalavotas = mysqli_query($db, "SELECT COUNT(DISTINCT CONCAT(ul.username, u.grup1)) AS count FROM user_log ul INNER JOIN user u ON ul.username = u.username
											WHERE (u.grup1 = 'BINALAVOTAS' OR u.grup2 = 'BINALAVOTAS') AND DATE(ul.login_time) = CURDATE();");
					$jml_binalavotas = $binalavotas->fetch_assoc()['count'];

					$binapenta_pasker = mysqli_query($db, "SELECT COUNT(DISTINCT CONCAT(ul.username, u.grup1)) AS count FROM user_log ul INNER JOIN user u ON ul.username = u.username
											WHERE (u.grup1 = 'BINAPENTA & PASKER' OR u.grup2 = 'BINAPENTA & PASKER') AND DATE(ul.login_time) = CURDATE();");
					$jml_binapenta_pasker = $binapenta_pasker->fetch_assoc()['count'];

					$binwasnaker_phi = mysqli_query($db, "SELECT COUNT(DISTINCT CONCAT(ul.username, u.grup1)) AS count FROM user_log ul INNER JOIN user u ON ul.username = u.username
											WHERE (u.grup1 = 'BINWASNAKER & PHI' OR u.grup2 = 'BINWASNAKER & PHI') AND DATE(ul.login_time) = CURDATE();");
					$jml_binwasnaker_phi = $binwasnaker_phi->fetch_assoc()['count'];

					$development_dwh = mysqli_query($db, "SELECT COUNT(DISTINCT CONCAT(ul.username, u.grup1)) AS count FROM user_log ul INNER JOIN user u ON ul.username = u.username
											WHERE (u.grup1 = 'DEVELOPMENT & DWH' OR u.grup2 = 'DEVELOPMENT & DWH') AND DATE(ul.login_time) = CURDATE();");
					$jml_development_dwh = $development_dwh->fetch_assoc()['count'];


            ?>
            <?php
                    $alluserResult = mysqli_query($db, "SELECT COUNT(DISTINCT ul.username) AS count FROM user_log ul INNER JOIN user u ON ul.username = u.username
													WHERE u.role IN ('ketua', 'pegawai', 'atasan') AND DATE(ul.login_time) = CURDATE();");
					$alluserData = mysqli_fetch_assoc($alluserResult);
					$jml_alluser = $alluserData['count'];

					$pegawaiResult = mysqli_query($db, "SELECT COUNT(DISTINCT ul.username) AS count FROM user_log ul INNER JOIN user u ON ul.username = u.username
													WHERE u.role = 'pegawai' AND DATE(ul.login_time) = CURDATE();");
					$pegawaiData = mysqli_fetch_assoc($pegawaiResult);
					$jml_pegawai = $pegawaiData['count'];

					$ketuaResult = mysqli_query($db, "SELECT COUNT(DISTINCT ul.username) AS count FROM user_log ul INNER JOIN user u ON ul.username = u.username
													WHERE u.role = 'ketua' AND DATE(ul.login_time) = CURDATE();");
					$ketuaData = mysqli_fetch_assoc($ketuaResult);
					$jml_ketua = $ketuaData['count'];

					$atasanResult = mysqli_query($db, "SELECT COUNT(DISTINCT ul.username) AS count FROM user_log ul INNER JOIN user u ON ul.username = u.username
													WHERE u.role = 'atasan' AND DATE(ul.login_time) = CURDATE();");
					$atasanData = mysqli_fetch_assoc($atasanResult);
					$jml_atasan = $atasanData['count'];

            ?>
            <script type="text/javascript">
            google.charts.load("current", {packages:["corechart"]});
            google.charts.setOnLoadCallback(drawChart1);
            google.charts.setOnLoadCallback(drawChart2);

            function drawChart1() {
                var data = google.visualization.arrayToDataTable([
                ['Task', 'Hours per Day'],
                ['Binalavotas', <?php echo $jml_binalavotas ?>],
                ['Binapenta & Pasker', <?php echo $jml_binapenta_pasker ?>],
                ['Binwasnaker & PHI',  <?php echo $jml_binwasnaker_phi ?>],
                ['Development & DWH',  <?php echo $jml_development_dwh ?>]
                ]);

                var options = {
                title: 'Pegawai Login Per Unit Grup',
                pieHole: 0.4,
                };

                var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
                chart.draw(data, options);
            }
            
            function drawChart2() {
                var data = google.visualization.arrayToDataTable([
                    ["Element", "Density", { role: "style" } ],
                    ["All User", <?php echo $jml_alluser ?>, "color: #DC3912"],
                    ["Pegawai", <?php echo $jml_pegawai ?>, "color: #3366CC"],
                    ["Ketua", <?php echo $jml_ketua ?>, "color: #109618"],
                    ["Atasan", <?php echo $jml_atasan ?>, "color: #FF9900"]
                ]);

                var view = new google.visualization.DataView(data);
                view.setColumns([0, 1,
                                { calc: "stringify",
                                    sourceColumn: 1,
                                    type: "string",
                                    role: "annotation" },
                                2]);

                var options = {
                    title: "Pegawai Login Per Role",
                    width: 500,
                    height: 300,
                    bar: {groupWidth: "80%"},
                    legend: { position: "none" },
                };
                var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
                chart.draw(view, options);
                }
            </script>
            </div>
            <div style="display: flex; width:100%; background: #ffff;">
                <div id="donutchart" style="width: 48%; height: 300px;"></div>
                <div id="columnchart_values" style="width: 48%; height: 250px;"></div>
            </div>
                </div>
				
			</div>
			<?php include '../assets/inc/copyright.php';?>
									
		</main>		
	</section>	
	<script>
	$(document).ready(function() {
		display_events();
	}); //end document.ready block

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
	<!-- <script defer src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
	<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js" integrity="sha512-FHZVRMUW9FsXobt+ONiix6Z0tIkxvQfxtCSirkKc5Sb4TKHmqq1dZa8DphF0XqKb3ldLu/wgMa8mT6uXiLlRlw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script defer src="../assets/js/script.js"></script>
	<script defer src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
	<script defer src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
	<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
	
</body>
</html>
