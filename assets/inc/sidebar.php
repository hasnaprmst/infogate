<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<section id="sidebar">
	<a href="dashboard.php" class="brand">
		<i class='bx bx-compass'></i>
		<span class="text">INFOGATE</span>
	</a>
	<ul class="side-menu top">
		<li <?php if($thisPage == "Dashboard") echo "class='active'"; ?>>
			<?php if ($_SESSION['role'] == 'Admin') : ?>
				<a href="userAdmin.php">
					<i class='bx bx-grid-alt'></i>
					<span class="text">Dashboard</span>
				</a>
			<?php else : ?>
				<a href="dashboard.php">
					<i class='bx bx-grid-alt'></i>
					<span class="text">Dashboard</span>
				</a>
			<?php endif; ?>	
		</li>
		
		<li <?php if($thisPage == "Profile") echo "class='active'"; ?>>
			<a href="profile.php">
				<i class='bx bx-user' ></i>
				<span class="text">Profile</span>
			</a>
		</li>
		<?php if ($_SESSION['role'] == 'Atasan' || $_SESSION['role'] == 'Admin') { ?>
			<li <?php if($thisPage == "Master Data") echo "class='active'"; ?>>
			<a href="masterData.php">
				<i class='bx bx-data'></i>
				<span class="text">Master Data</span>
			</a>
		</li>
		<li <?php if($thisPage == "Master Pekerjaan") echo "class='active'"; ?>>
			<a href="masterPekerjaan.php">
				<i class='bx bx-cylinder' ></i>
				<span class="text">Master Pekerjaan</span>
			</a>
		</li>
		<?php } ?>
		<li <?php if($thisPage == "Log History") echo "class='active'"; ?>>
			<a href="loghistory.php">
				<i class='bx bx-time' ></i>
				<span class="text">Log History</span>
			</a>
		</li>
		<li <?php if($thisPage == "Joblist" || $thisPage == "Group Joblist"  || $thisPage == "My Joblist" ) echo "class='active'"; ?>>
			<a href="joblist.php">
				<i class='bx bx-task' ></i>
				<span class="text">Joblist</span>
			</a>
		</li>
		<li <?php if($thisPage == "Bank File") echo "class='active'"; ?>>
			<a href="bankfile.php">
				<i class='bx bx-folder' ></i>
				<span class="text">Bank File</span>
			</a>
		</li>
		<?php if ($_SESSION['role'] == 'Atasan' || $_SESSION['role'] == 'Admin') { ?>
			<li <?php if($thisPage == "Report") echo "class='active'"; ?>>
				<a href="report.php">
					<i class='bx bxs-report' ></i>
					<span class="text">Report</span>
				</a>
			</li>
		<?php } ?>
	</ul>
	<ul class="side-menu">
	
		<li>
			<a href="auth/logout.php" class="logout">
				<i class='bx bx-log-out' ></i>
				<span class="text">Logout</span>
			</a>
		</li>
	</ul>
</section>
</body>
</html>