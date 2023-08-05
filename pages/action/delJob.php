<?php
require_once('../auth/db_login.php');

$query = "DELETE FROM joblist WHERE id='".$_GET['id']."'";
$result = $db->query($query);

if ($result) {
    $_SESSION['notification'] = array(
        'type' => 'success',
        'message' => '<i class="bi bi-check-circle-fill"></i> &nbsp Data was deleted successfully!'
    );
    header('Location: ../joblist.php');
    exit();
} else {
    $_SESSION['notification'] = array(
        'type' => 'danger',
        'message' => '<i class="bi bi-exclamation-triangle-fill"></i> &nbsp Sorry, data was not deleted successfully!'
    );
    header('Location: ../joblist.php');
    exit();
}
?>
