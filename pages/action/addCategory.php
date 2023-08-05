<?php
session_start();
require_once('../auth/db_login.php');

$kategori = $_POST['kategori'];
$id_job = $_POST['id_job'];

if (isset($_POST['add'])){
    $query = "INSERT INTO kategori (id_job, kategori) VALUES ('$id_job', '$kategori')";
    $result = $db->query($query);

    if ($result) {
        $_SESSION['notification'] = array(
            'type' => 'success',
            'message' => '<i class="bi bi-check-circle-fill"></i> &nbsp Data successfully added!'
    );
        header('Location: ../masterPekerjaan.php');
        exit();
    } else {
        $_SESSION['notification'] = array(
            'type' => 'danger',
            'message' => '<i class="bi bi-exclamation-triangle-fill"></i> &nbsp Sorry, Data could not be saved successfully!'
    );
        header('Location: ../masterPekerjaan.php');
        exit();
    }
}

?>