<?php
session_start();
require_once('auth/db_login.php');

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'];
$login = $db->query("SELECT * FROM user WHERE username='$username'");
$result = $login->fetch_object();

$thisPage = "Joblist";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $thisPage; ?></title>

    <!-- Bootstrap CSS File -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">

    <!-- DataTables CSS File -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">

    <!-- Custom CSS File -->
    <link rel="stylesheet" href="../assets/css/style.css">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/png" href="../assets/img/logo.png">
</head>

<body>
    <div class="container">
        <h1></h1>
        <div class="data-tables datatable-dark">
            <div class="table-data">
                <div style="width: 100%;">
                    <div class="card">
                        <div class="card-header">
                        <a class="btn btn-primary" href="joblist.php" role="button">close</a>
                            <center><h4>Joblist</h4></center>
                        </div>
                        <div class="card-body">
                            <table id="example" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>JOB</th>
                                        <th>JOBLIST</th>
                                        <th>STATUS</th>
                                        <th>TARGET TIME</th>
                                        <th>CATEGORY</th>
                                        <th>PIC</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT * FROM joblist";
                                    $result = $db->query($query);

                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <tr>
                                                <td><?php echo $row['id']; ?></td>
                                                <td>
                                                    <div class="badge bg-secondary text-uppercase"><?php echo $row['grup']; ?></div>
                                                    <div><?php echo $row['judul']; ?></div>
                                                    <div><p>Input By: <?php echo strtoupper($row['input_by']); ?></p></div>
                                                    <?php if ($row['report_by'] != ''): ?>
                                                        <div><p>Report By: <?php echo strtoupper($row['report_by']); ?></p></div>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <div><?php echo $row['status']; ?></div>
                                                    <?php
                                                    $status = $row['status'];
                                                    $statusClass = '';
                                                    switch ($status) {
                                                        case 'OPEN':
                                                            $statusClass = 'badge bg-success';
                                                            break;
                                                        case 'REPORT':
                                                            $statusClass = 'badge bg-warning';
                                                            break;
                                                        case 'CLOSE':
                                                            $statusClass = 'badge bg-danger';
                                                            break;
                                                        case 'PROCESS':
                                                            $statusClass = 'badge bg-primary';
                                                            break;
                                                        case 'SUNDUL':
                                                            $statusClass = 'badge bg-secondary';
                                                            break;
                                                        case 'USULAN':
                                                            $statusClass = 'badge bg-info';
                                                            break;
                                                        case 'INFORMASI':
                                                            $statusClass = 'badge bg-light text-dark';
                                                            break;
                                                        case 'MONITOR':
                                                            $statusClass = 'badge bg-dark text-white';
                                                            break;
                                                            }
                                                        ?>
                                                <td><?php echo $row['end_date']; ?></td>
                                                <td>
                                                <?php
                                                    $kategori = $row['kategori'];
                                                    $kategoriClass = '';
                                                        switch ($kategori) {
                                                        case 'TUGAS':
                                                            $kategoriClass = 'badge rounded-pill bg-success';
                                                            break;
                                                        case 'RAPAT':
                                                            $kategoriClass = 'badge rounded-pill bg-danger';
                                                            break;
                                                        case 'DINAS':
                                                            $kategoriClass = 'badge rounded-pill bg-warning';
                                                            break;
                                                    }
                                                ?>
                                                <span class="<?php echo $kategoriClass; ?>"><?php echo $kategori; ?></span>
                                            </td>
                                            <td><?php echo strtoupper($row['PIC']); ?></td>
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
</div>

  <style>
    .dataTables_wrapper .dt-buttons .buttons-csv {
      background-color: #5bc0de;
      color: #ffffff;
      border: none;
      border-radius: 8px;
    }
    .dataTables_wrapper .dt-buttons .buttons-excel {
      background-color: #5cb85c;
      color: #ffffff;
      border: none;
      border-radius: 8px;
    }

    .dataTables_wrapper .dt-buttons .buttons-pdf {
      background-color: #d9534f;
      color: #ffffff;
      border: none;
      border-radius: 8px;
    }
    .dataTables_wrapper .dt-buttons .buttons-print {
      background-color: #f0ad4e;
      color: #ffffff;
      border: none;
      border-radius: 8px;
    }
  </style>
<!-- JavaScript Files -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>

<!-- DataTables Buttons JS -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.pdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script>
    $(document).ready(function() {
        $('#example').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
</script>
</body>
</html>