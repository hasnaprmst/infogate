<?php
session_start();
require_once('auth/db_login.php');
if(!isset($_SESSION['username'])){
    header('Location: login.php');
}

$username = $_SESSION['username'];
$login = $db->query("SELECT * FROM user WHERE username='$username'");

$result = $login->fetch_object();

$thisPage = "Master Data";
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
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
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
					<center><h1>Master Data</h1></center>
				</div>
                <?php if ($_SESSION['role'] == 'Admin') { ?>
                    <!-- Button trigger modal -->
                    <button type="button" class="searchlist" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Add User
                    </button>
                    
                    <!-- Modal -->
                    <div class="modal fade bd-example-modal-md" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form method="POST" action="action/addUser.php" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="form-row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="inputnama" class="label-name">NAMA LENGKAP</label>
                                                <input type="text" class="form-control" name="nama_lengkap" id="inputnama" placeholder="Masukan Nama Lengkap" required>
                                            </div>
                        
                                            <div class="form-group">
                                                <label for="inputrole" class="label-name">ROLE</label>
                                                <select class="form-select" id="inputrole" name="role" placeholder="Pilih Role" required>
                                                    <option selected value="">Pilih Role</option>
                                                    <option value="Pegawai">Pegawai</option>
                                                    <option value="Ketua">Ketua</option>
                                                    <option value="Atasan">Atasan</option>
                                                    <!-- <option value="Admin">Admin</option> -->
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputgrup" class="label-name">GRUP 1</label>
                                                <select id="grup1" name="grup1" class="form-select" placeholder="Pilih Grup" required>
                                                    <option value="">Pilih Grup</option>	
                                                    <option value="BINALAVOTAS">BINALAVOTAS</option>
                                                    <option value="BINAPENTA&PASKER">BINAPENTA&PASKER</option>
                                                    <option value="BINWASNAKER&PHI">BINWASNAKER&PHI</option>
                                                    <option value="DEVELOPMENT&DWH">DEVELOPMENT&DWH</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputgrup" class="label-name">GRUP 2</label>
                                                <select id="grup2" name="grup2" class="form-select" placeholder="Pilih Grup">
                                                    <option value="">Pilih Grup</option>	
                                                    <option value="BINALAVOTAS">BINALAVOTAS</option>
                                                    <option value="BINAPENTA&PASKER">BINAPENTA&PASKER</option>
                                                    <option value="BINWASNAKER&PHI">BINWASNAKER&PHI</option>
                                                    <option value="DEVELOPMENT&DWH">DEVELOPMENT&DWH</option>
                                                </select>
                                            </div>
                    
                                            <div class="form-group">
                                                <label for="inputusername" class="label-name">USERNAME</label>
                                                <input type="text" class="form-control" id="inputusername" name="username" placeholder="Masukan Username" required>
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
				<?php } ?>
			</div>
			<ul class="box-info">
                <li>
					<i class='bx bxs-group'></i>
					<a class="text" href="allUser.php">
						<center><h3>All User</h3></center>
					</a>
				</li>
				<li>
					<i class='bx bxs-user'></i>
					<a class="text" href="userKetua.php">
						<center><h3>Ketua</h3></center>
					</a>
				</li>
				<li>
					<i class='bx bxs-user'></i>
					<a class="text" href="userPegawai.php">
						<center><h3>Pegawai</h3></center>
					</a>
				</li>
			</ul>
			<div class="table-data" style="flex: content;">
            <?php
                    $binalavotas = mysqli_query($db,"SELECT * FROM user WHERE grup1='BINALAVOTAS' or grup2='BINALAVOTAS'");
                    $jml_binalavotas = $binalavotas->num_rows;

                    $binapenta_pasker = mysqli_query($db,"SELECT * FROM user WHERE grup1='BINAPENTA & PASKER' or grup2='BINAPENTA & PASKER'");
                    $jml_binapenta_pasker = $binapenta_pasker->num_rows;

                    $binwasnaker_phi = mysqli_query($db,"SELECT * FROM user WHERE grup1='BINWASNAKER & PHI' or grup2='BINWASNAKER & PHI'");
                    $jml_binwasnaker_phi = $binwasnaker_phi->num_rows;

                    $development_dwh = mysqli_query($db,"SELECT * FROM user WHERE grup1='DEVELOPMENT & DWH' or grup2='DEVELOPMENT & DWH'");
                    $jml_development_dwh = $development_dwh->num_rows;
            ?>
            <?php
                    $alluser = mysqli_query($db, "SELECT * FROM user WHERE role IN ('ketua', 'pegawai', 'atasan')");
                    $jml_alluser = $alluser->num_rows;

                    $pegawai = mysqli_query($db,"SELECT * FROM user WHERE role='pegawai'");
                    $jml_pegawai = $pegawai->num_rows;

                    $ketua = mysqli_query($db,"SELECT * FROM user WHERE role='ketua'");
                    $jml_ketua = $ketua->num_rows;

                    $atasan = mysqli_query($db,"SELECT * FROM user WHERE role='atasan'");
                    $jml_atasan = $atasan->num_rows;
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
                title: 'Jumlah Pegawai Per Unit Grup',
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
                    title: "Jumlah Pegawai Per Role",
                    width: 511,
                    height: 300,
                    bar: {groupWidth: "95%"},
                    legend: { position: "none" },
                };
                var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
                chart.draw(view, options);
                }
            </script>
            </div>
                <div style="display: flex; width:100%; background: #ffff;">
                <div id="donutchart" style="width: 50%; height: 300px;"></div>
                <div id="columnchart_values" style="width: 50%; height: 250px;"></div>
            </div>

                </div>
                <br>
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
