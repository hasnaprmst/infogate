<?php
session_start();
require_once('../auth/db_login.php');

$nama_lengkap = $_POST['nama_lengkap'];
$role = $_POST['role'];
$username = $_POST['username'];
$grup1 = $_POST['grup1'];
$grup2 = $_POST['grup2'];

if (isset($_POST['add'])){
    $query = "INSERT INTO user (nama_lengkap, role,  username, password, grup1, grup2) VALUES ('$nama_lengkap', '$role', '$username', '1234', '$grup1', '$grup2')";
    $result = $db->query($query);

    if ($result) {
        $_SESSION['notification'] = array(
            'type' => 'success',
            'message' => '<i class="bi bi-check-circle-fill"></i> &nbsp Data successfully added!'
    );
        header('Location: ../allUser.php');
        exit();
    } else {
        $_SESSION['notification'] = array(
            'type' => 'danger',
            'message' => '<i class="bi bi-exclamation-triangle-fill"></i> &nbsp Sorry, Data could not be saved successfully!'
    );
        header('Location: ../allUser.php');
        exit();
    }
}

?>