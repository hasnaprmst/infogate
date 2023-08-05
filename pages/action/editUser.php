<?php
session_start();
require_once('../auth/db_login.php');

$nama_lengkap = $_POST['nama_lengkap'];
$role = $_POST['role'];
$username = $_POST['username'];

if (isset($_POST['submit'])){
    $query = "UPDATE user SET nama_lengkap='$nama_lengkap', role='$role' WHERE username='$username'";
    $result = $db->query($query);

    if ($result) {
        $_SESSION['notification'] = array(
            'type' => 'success',
            'message' => '<i class="bi bi-check-circle-fill"></i> &nbsp Data successfully changed!'
        );
        header('Location: ../allUser.php');
        exit();
    } else {
        $_SESSION['notification'] = array(
            'type' => 'danger',
            'message' => '<i class="bi bi-exclamation-triangle-fill"></i> &nbsp Sorry, Data could not be saved successfully! ' . $db->error
        );
        header('Location: ../allUser.php');
        exit();
    }
}

?>