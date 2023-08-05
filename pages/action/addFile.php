<?php
require_once('../auth/db_login.php');
session_start();

$jenis_file = $_POST['jenis_file'];
$informasi_file = $_POST['informasi_file'];

$ekstensi_diperbolehkan = array('pdf', 'csv', 'doc', 'docx');
$nama = $_FILES['file']['name'];
$x = explode('.', $nama);
$ekstensi = strtolower(end($x));
$ukuran = $_FILES['file']['size'];
$file_tmp = $_FILES['file']['tmp_name'];

$username = $_SESSION['username'];
$initial = "SELECT * FROM user WHERE username='$username'";
$hasil = $db->query($initial);
$data = $hasil->fetch_assoc();

$query = "SELECT * FROM bankfile";
$result = $db->query($query);

if (in_array($ekstensi, $ekstensi_diperbolehkan)) {
    if ($ukuran < 1044070) {
        // Fixed the file path by adding a directory separator before the filename
        move_uploaded_file($file_tmp, '../../files/bankfile/' . $nama);
        // Fixed the array index for the $data variable in the query
        $query = "INSERT INTO bankfile (jenis_file, informasi_file, file_lampiran, input_by) VALUES ('$jenis_file', '$informasi_file', '$nama', '{$data['initial_name']}')";
        $db->query($query);

        $_SESSION['notification'] = array(
            'type' => 'success',
            'message' => '<i class="bi bi-check-circle-fill"></i> &nbsp Data successfully added!'
        );
        header('Location: ../bankfile.php');
        exit();
    } else {
        $_SESSION['notification'] = array(
            'type' => 'danger',
            'message' => '<i class="bi bi-exclamation-triangle-fill"></i> &nbsp Sorry, the file size is too big'
        );
        header('Location: ../bankfile.php');
        exit();
    }
} else {
    $_SESSION['notification'] = array(
        'type' => 'danger',
        'message' => '<i class="bi bi-exclamation-triangle-fill"></i> &nbsp Invalid file type. Only PDF, CSV, DOC, and DOCX files are allowed.'
    );
    header('Location: ../bankfile.php');
    exit();
}
?>
