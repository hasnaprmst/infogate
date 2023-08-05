<?php
require_once('../auth/db_login.php');
session_start();

$grup = $_POST['grup'];
$judul = $_POST['judul'];
$deskripsi = $_POST['deskripsi'];
$status = $_POST['status'];
$job = $_POST['job'];
$kategori = $_POST['kategori'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$agenda = $_POST['agenda'];

$ekstensi_diperbolehkan = array('pdf');
$nama = $_FILES['file']['name'];
$x = explode('.', $nama);
$ekstensi = strtolower(end($x));
$ukuran = $_FILES['file']['size'];
$file_tmp = $_FILES['file']['tmp_name'];

$name = $_FILES['fileReport']['name'];
$size = $_FILES['fileReport']['size'];
$tmp = $_FILES['fileReport']['tmp_name'];

$username = $_SESSION['username'];
$initial = "SELECT * FROM user WHERE username='$username'";
$hasil = $db->query($initial);
$data = $hasil->fetch_assoc();

$query = "SELECT * FROM joblist WHERE judul=?";
$statement = $db->prepare($query);
$statement->bind_param("s", $judul);
$statement->execute();
$result = $statement->get_result();

if (isset($_POST['save'])) {
    if ($_SESSION['role'] == 'Pegawai') {
        move_uploaded_file($file_tmp, '../../files/lampiran/' . $nama);
        move_uploaded_file($tmp, '../../files/report/' . $name);

        $query = "UPDATE joblist SET status=?, file_report=?, catatan=?, report_by=? WHERE judul=?";
        $statement = $db->prepare($query);
        $statement->bind_param("sssss", $status, $name, $catatan, $data['initial_name'], $judul);
        $statement->execute();

        if ($statement->affected_rows > 0) {
            $_SESSION['notification'] = array(
                'type' => 'success',
                'message' => '<i class="bi bi-check-circle-fill"></i> &nbsp Data successfully changed!'
            );
            header('Location: ../joblist.php');
            exit();
        }
    } else {
        $pic = implode(', ', $_POST['PIC']);
        move_uploaded_file($file_tmp, '../../files/lampiran/' . $nama);
        move_uploaded_file($tmp, '../../files/report/' . $name);

        if ($status == 'REPORT') {
            $query = "UPDATE joblist SET grup=?, judul=?, deskripsi=?, PIC=?, status=?, job=?, kategori=?, end_date=?, agenda=?, file_lampiran=?, file_report=?, catatan=?, report_by=? WHERE judul=?";
            $statement = $db->prepare($query);
            $statement->bind_param("ssssssssssssss", $grup, $judul, $deskripsi, $pic, $status, $job, $kategori, $end_date, $agenda, $nama, $name, $catatan, $data['initial_name'], $judul);
            $statement->execute();

            if ($statement->affected_rows > 0) {
                $_SESSION['notification'] = array(
                    'type' => 'success',
                    'message' => '<i class="bi bi-check-circle-fill"></i> &nbsp Data successfully changed!'
                );
                header('Location: ../joblist.php');
                exit();
            }
        } else {
            $query = "UPDATE joblist SET grup=?, judul=?, deskripsi=?, PIC=?, status=?, job=?, kategori=?, end_date=?, agenda=?, file_lampiran=?, file_report=?, catatan=?, input_by=? WHERE judul=?";
            $statement = $db->prepare($query);
            $statement->bind_param("ssssssssssssss", $grup, $judul, $deskripsi, $pic, $status, $job, $kategori, $end_date, $agenda, $nama, $name, $catatan, $data['initial_name'], $judul);
            $statement->execute();

            if ($statement->affected_rows > 0) {
                $_SESSION['notification'] = array(
                    'type' => 'success',
                    'message' => '<i class="bi bi-check-circle-fill"></i> &nbsp Data successfully changed!'
                );
                header('Location: ../joblist.php');
                exit();
            }
        }
    }
} else {
    $_SESSION['notification'] = array(
        'type' => 'danger',
        'message' => '<i class="bi bi-exclamation-triangle-fill"></i> &nbsp Sorry, Data could not be saved successfully!' . $db->error
    );
    header('Location: ../joblist.php');
    exit();
}
?>
