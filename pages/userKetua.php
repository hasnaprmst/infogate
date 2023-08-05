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
                                                <input type="text" class="form-control" name="nama_lengkap" id="inputnama" placeholder="Masukan Nama Lengkap">
                                            </div>
                        
                                            <div class="form-group">
                                                <label for="inputrole" class="label-name">ROLE</label>
                                                <select class="form-select" id="inputrole" name="role" placeholder="Pilih Role">
                                                    <option selected value="">Pilih Role</option>
                                                    <option value="Pegawai">Pegawai</option>
                                                    <option value="Ketua">Ketua</option>
                                                    <option value="Atasan">Atasan</option>
                                                    <!-- <option value="Admin">Admin</option> -->
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputgrup" class="label-name">GRUP 1</label>
                                                <select id="grup1" name="grup1" class="form-select" placeholder="Pilih Grup">
                                                    <option value="">Pilih Grup</option>	
                                                    <option value="BINALAVOTAS">BINALAVOTAS</option>
                                                    <option value="BINAPENTA & PASKER">BINAPENTA & PASKER</option>
                                                    <option value="BINWASNAKER & PHI">BINWASNAKER & PHI</option>
                                                    <option value="DEVELOPMENT & DWH">DEVELOPMENT & DWH</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputgrup" class="label-name">GRUP 2</label>
                                                <select id="grup2" name="grup2" class="form-select" placeholder="Pilih Grup">
                                                    <option value="">Pilih Grup</option>	
                                                    <option value="BINALAVOTAS">BINALAVOTAS</option>
                                                    <option value="BINAPENTA & PASKER">BINAPENTA & PASKER</option>
                                                    <option value="BINWASNAKER & PHI">BINWASNAKER & PHI</option>
                                                    <option value="DEVELOPMENT & DWH">DEVELOPMENT & DWH</option>
                                                </select>
                                            </div>
                    
                                            <div class="form-group">
                                                <label for="inputusername" class="label-name">USERNAME</label>
                                                <input type="text" class="form-control" id="inputusername" name="username" placeholder="Masukan Username">
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
			<div class="table-data">
				<div style="width: 100%;">
					<table id="example" class="table table-striped " style="width:100%">
						<thead style="text-align:center;">
							<tr>
								<th>NO</th>
								<th>NAMA LENGKAP</th>
								<th>ROLE</th>
								<th>USERNAME</th>
								<th>INISIAL</th>
								<th>ACTION</th>
							</tr>
						</thead>
						<tbody>
                            <?php
                                $query = "SELECT * FROM `user` WHERE role='ketua' OR role='atasan'";
                                $result = $db->query($query);
                                $no = 0;

                                while ($row = $result->fetch_assoc()) {
                                    $no++;
							?>
								<tr>
									<td><?php echo $no; ?></td>
									<td><?php echo $row['nama_lengkap']; ?></td>
									<td><?php echo $row['role']; ?></td>
									<td><?php echo $row['username']; ?></td>
									<td><?php echo strtoupper($row['initial_name']); ?></td>
									<td>
										<a href="" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $row['id']; ?>"><i class='bx bxs-edit' ></i></a>
										<a href="action/delUser.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')"><i class='bx bxs-trash' ></i></a>
										
										<!-- Edit Modal -->
										<div class="modal fade bd-example-modal-md" id="exampleModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
											<div class="modal-dialog modal-md">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
													<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
												</div>
												<form method="POST" action="action/editUser.php" enctype="multipart/form-data">
													<div class="modal-body">
														<div class="form-row">
															<div class="col">
																<div class="form-group">
																	<label for="inputnama" class="label-name">NAMA LENGKAP</label>
																	<input type="text" class="form-control" name="nama_lengkap" id="inputnama" value="<?php echo $row['nama_lengkap']; ?>">
																</div>
											
																<div class="form-group">
																	<label for="inputrole" class="label-name">ROLE</label>
																	<select class="form-select" id="inputrole" name="role">
																		<option default>Pilih Role</option>
																		<option <?= ($row['role'] == 'Pegawai') ? 'selected' : '' ?> value="Pegawai">Pegawai</option>
																		<option <?= ($row['role'] == 'Ketua') ? 'selected' : '' ?> value="Ketua">Ketua</option>
																		<option <?= ($row['role'] == 'Atasan') ? 'selected' : '' ?> value="Atasan">Atasan</option>
																		<option <?= ($row['role'] == 'Admin') ? 'selected' : '' ?> value="Admin">Admin</option>
																	</select>
																</div>
										
																<div class="form-group">
																	<label for="inputusername" class="label-name">USERNAME</label>
																	<input type="text" class="form-control" id="inputusername" name="username" readonly value="<?php echo $row['username']; ?>">
																</div>
															</div>
														</div>
													</div>
													<div class="modal-footer">
														<button type="button" class="modal-btn-cancel" data-bs-dismiss="modal">Cancel</button>
														<button type="submit" class="modal-btn-add" name="submit" value="save">Save</button>
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
