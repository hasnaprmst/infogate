<?php
session_start();
require_once('../auth/db_login.php');

if (isset($_GET['id'])) {
    $id_file = $_GET['id'];

    // Ambil informasi file dari database sebelum dihapus
    $query = "SELECT file_lampiran FROM bankfile WHERE id_file='$id_file'"; // perbaikan pada bagian ini
    $result = $db->query($query);
    $row = $result->fetch_assoc();
    $file_lampiran = $row['file_lampiran'];

    // Hapus file fisik dari direktori
    $file_path = '../files/bankfile/' . $file_lampiran;
    if (file_exists($file_path)) {
        unlink($file_path);
    }

    $query = "DELETE FROM bankfile WHERE id_file='$id_file'"; // perbaikan pada bagian ini
    $result = $db->query($query);

    if ($result) {
        $_SESSION['notification'] = array(
            'type' => 'success',
            'message' => '<i class="bi bi-check-circle-fill"></i> &nbsp Data was deleted successfully!'
        );
    } else {
        $_SESSION['notification'] = array(
            'type' => 'danger',
            'message' => '<i class="bi bi-exclamation-triangle-fill"></i> &nbsp Sorry, data was not deleted successfully!'
        );
    }
}

header('Location: ../bankfile.php');
exit();
?>
