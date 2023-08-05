<?php
session_start();
require_once('../auth/db_login.php');

$id_kat = $_POST['id_kat'];
$kategori = $_POST['kategori'];

if (isset($_POST['save'])){
    $query = "UPDATE kategori SET kategori='$kategori' WHERE id_kat='$id_kat'";
    $result = $db->query($query);

    if ($result) {
        $_SESSION['notification'] = array(
            'type' => 'success',
            'message' => '<i class="bi bi-check-circle-fill"></i> &nbsp Data successfully changed!'
        );
        header('Location: ../masterPekerjaan.php');
        exit();
    } else {
        $_SESSION['notification'] = array(
            'type' => 'danger',
            'message' => '<i class="bi bi-exclamation-triangle-fill"></i> &nbsp Sorry, Data could not be saved successfully!' . $db->error
        );
        header('Location: ../masterPekerjaan.php');
        exit();
    }
}
?>
