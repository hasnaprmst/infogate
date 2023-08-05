<?php
session_start();
require_once('auth/db_login.php');
if(!isset($_SESSION['username'])){
    header('Location: login.php');
}

$username = $_SESSION['username'];
$login = $db->query("SELECT * FROM user WHERE username='$username'");

$result = $login->fetch_object();

$thisPage = "Report";
?>

<!DOCTYPE html>
<html>
<head><meta charset="UTF-8">
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
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script src="https://www.gstatic.com/charts/loader.js"></script>
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
					<center><h1>Report</h1></center>
				</div>
			</div>
			<div class="table-data">
				<div id="grafik1" style="display:flexbox; width:100%; background: #ffff;"></div>
			</div>
			<div class="table-data">
			<div style="display: flex; width:100%; background: #ffff;">
                <div id="grafik2" style="width: 33%; height: 200px;"></div>
                <div id="grafik3" style="width: 33%; height: 200px;"></div>
                <div id="grafik4" style="width: 33%; height: 200px;"></div>
            </div>
			</div>
		</main>		
	</section>

	<?php

		$currentMonth = date('m');
		$currentYear = date('Y');

		$query1 = "SELECT SUBSTRING_INDEX(TRIM(SUBSTRING_INDEX(PIC, ',', numbers.n)), ' ', -1) AS initial_name, COUNT(*) AS count
		FROM joblist
		CROSS JOIN
		(SELECT 1 AS n UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4) AS numbers
		WHERE CHAR_LENGTH(PIC) - CHAR_LENGTH(REPLACE(PIC, ',', '')) >= numbers.n - 1
		AND MONTH(start_date) = $currentMonth
		AND YEAR(start_date) = $currentYear
		AND MONTH(end_date) = $currentMonth
		AND YEAR(end_date) = $currentYear
		GROUP BY initial_name";
		$result1 = $db->query($query1);

		$dataFromDatabase1 = array();
		while ($row = $result1->fetch_assoc()) {
			$initialName = $row['initial_name'];
			$count = $row['count'];
			$dataFromDatabase1[] = "['$initialName', $count]";
		}

		$query2 = "SELECT status, COUNT(*) AS count
					FROM joblist
					WHERE MONTH(start_date) = $currentMonth
					AND YEAR(start_date) = $currentYear
					AND MONTH(end_date) = $currentMonth
					AND YEAR(end_date) = $currentYear
					GROUP BY status";
		$result2 = $db->query($query2);

		$dataFromDatabase2 = array();
		while ($row = $result2->fetch_assoc()) {
			$status = $row['status'];
			$count = $row['count'];
			$dataFromDatabase2[] = "['$status', $count]";
		}

		$query3 = "SELECT grup, COUNT(*) AS count
			FROM joblist
			WHERE MONTH(start_date) = $currentMonth
			AND YEAR(start_date) = $currentYear
			AND MONTH(end_date) = $currentMonth
			AND YEAR(end_date) = $currentYear
			GROUP BY grup";
			$result3 = $db->query($query3);

			$dataFromDatabase3 = array();
			while ($row = $result3->fetch_assoc()) {
				$grup = $row['grup'];
				$count = $row['count'];
				$dataFromDatabase3[] = "['$grup', $count]";
		}

		$query4 = "SELECT kategori, COUNT(*) AS count
			FROM joblist
			WHERE MONTH(start_date) = $currentMonth
			AND YEAR(start_date) = $currentYear
			AND MONTH(end_date) = $currentMonth
			AND YEAR(end_date) = $currentYear
			GROUP BY kategori";
			$result4 = $db->query($query4);

			$dataFromDatabase4 = array();
			while ($row = $result4->fetch_assoc()) {
				$kategori = $row['kategori'];
				$count = $row['count'];
				$dataFromDatabase4[] = "['$kategori', $count]";
		}
	?>

<script>
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart1);
    google.charts.setOnLoadCallback(drawChart2);
    google.charts.setOnLoadCallback(drawChart3);
    google.charts.setOnLoadCallback(drawChart4);

    function drawChart1() {
        var dataFromDatabase = [
            <?php echo implode(",", $dataFromDatabase1); ?>
        ];

        // Membuat objek DataTable
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'InitialName', { role: "style" });
        data.addColumn('number', 'PIC');
        data.addRows(dataFromDatabase);

        var options = {
            title: 'PIC - Kinerja Pekerja',
            width: 1000,
            height: 250
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('grafik1'));
        chart.draw(data, options);
    }

    function drawChart2() {
        var dataFromDatabase = [
            <?php echo implode(",", $dataFromDatabase2); ?>
        ];

        // Membuat objek DataTable
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'status');
        data.addColumn('number', 'PIC');
        data.addRows(dataFromDatabase);

        var options = {
            title: 'Status - Job',
            width: 300,
            height: 250,
            pieHole: 0.4 // Mengatur bagian tengah pada grafik Doughnut
        };

        var chart = new google.visualization.PieChart(document.getElementById('grafik2'));
        chart.draw(data, options);
    }

	function drawChart3() {
        var dataFromDatabase = [
            <?php echo implode(",", $dataFromDatabase3); ?>
        ];

        // Membuat objek DataTable
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'grup');
        data.addColumn('number', 'PIC');
        data.addRows(dataFromDatabase);

        var options = {
            title: 'Grup - Job',
            width: 300,
            height: 250,
			pieHole: 0.4
		};

        var chart = new google.visualization.PieChart(document.getElementById('grafik3'));
        chart.draw(data, options);
    }

	function drawChart4() {
        var dataFromDatabase = [
            <?php echo implode(",", $dataFromDatabase4); ?>
        ];

        // Membuat objek DataTable
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'kategori');
        data.addColumn('number', 'PIC');
        data.addRows(dataFromDatabase);

        var options = {
            title: 'Kategori - Job',
            width: 300,
            height: 250,
			pieHole: 0.4
		};

        var chart = new google.visualization.PieChart(document.getElementById('grafik4'));
        chart.draw(data, options);
    }
</script>
    <script defer src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script defer src="../assets/js/script.js"></script>
	<script defer src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
	<script defer src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

	<!-- Multiselect JS File -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js" integrity="sha512-FHZVRMUW9FsXobt+ONiix6Z0tIkxvQfxtCSirkKc5Sb4TKHmqq1dZa8DphF0XqKb3ldLu/wgMa8mT6uXiLlRlw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	
</body>
</html>
