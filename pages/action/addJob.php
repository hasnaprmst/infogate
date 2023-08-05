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

$username = $_SESSION['username'];
$initial = "SELECT * FROM user WHERE username='$username'";
$hasil = $db->query($initial);
$data = $hasil->fetch_assoc();

$pic = implode(', ', $_POST['PIC']);

$nama = '';
if ($_FILES['file']['name']) {
    $ekstensi_diperbolehkan = array('jpg', 'png', 'doc', 'docx', 'pdf', 'csv');
    $nama = $_FILES['file']['name'];
    $x = explode('.', $nama);
    $ekstensi = strtolower(end($x));
    $ukuran = $_FILES['file']['size'];
    $file_tmp = $_FILES['file']['tmp_name'];

    if (in_array($ekstensi, $ekstensi_diperbolehkan)) {
        if ($ukuran < 1044070) {
            move_uploaded_file($file_tmp, '../../files/lampiran/' . $nama);
        } else {
            $_SESSION['notification'] = array(
                'type' => 'danger',
                'message' => '<i class="bi bi-exclamation-triangle-fill"></i> &nbsp File size is too big!'
            );
            header('Location: ../joblist.php');
            exit();
        }
    } else {
        $_SESSION['notification'] = array(
            'type' => 'danger',
            'message' => '<i class="bi bi-exclamation-triangle-fill"></i> &nbsp File extension is not allowed!'
        );
        header('Location: ../joblist.php');
        exit();
    }
}

$query = "INSERT INTO joblist (grup, judul, deskripsi, PIC, status, job, kategori, start_date, end_date, agenda, file_lampiran, input_by) VALUES ('$grup', '$judul', '$deskripsi', '$pic', '$status', '$job', '$kategori', '$start_date', '$end_date', '$agenda', '$nama', '$data[initial_name]')";
$result = $db->query($query);

if ($result) {
    $_SESSION['notification'] = array(
        'type' => 'success',
        'message' => '<i class="bi bi-check-circle-fill"></i> &nbsp Data successfully added!'
    );
    header('Location: ../joblist.php');
    exit();
} else {
    $_SESSION['notification'] = array(
        'type' => 'danger',
        'message' => '<i class="bi bi-exclamation-triangle-fill"></i> &nbsp Sorry, Data could not be saved successfully!'
    );
    header('Location: ../joblist.php');
    exit();
}
?>
