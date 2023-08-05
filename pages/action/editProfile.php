<?php
require_once('../auth/db_login.php');
session_start();

$username = $_SESSION['username'];
$password = $_POST["password"];
$initial_name = $_POST["initial_name"];

if (isset($_POST['save'])) {
    $query = "UPDATE user SET password='$password', initial_name='$initial_name' WHERE username='$username'";
    $result = $db->query($query);

    if ($result) {
        $_SESSION['notification'] = array(
            'type' => 'success',
            'message' => '<i class="bi bi-check-circle-fill"></i> &nbsp Data successfully changed!'
        );
        header('Location: ../profile.php');
        exit();
    } else {
        $_SESSION['notification'] = array(
            'type' => 'danger',
            'message' => '<i class="bi bi-exclamation-triangle-fill"></i> &nbsp Data not successfully added! ' . $db->error
        );
        header('Location: ../profile.php');
        exit();
    }
}
?>
