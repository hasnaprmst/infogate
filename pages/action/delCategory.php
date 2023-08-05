<?php
require_once('../auth/db_login.php');
session_start();

$id_kat = $_GET['id_kat'];

// Delete kategori
$query = "DELETE FROM kategori WHERE id_kat = '$id_kat'";
$result = $db->query($query);

if ($result) {
    echo '<script>alert("Data berhasil dihapus");</script>';
    echo '<script>window.location.href = "../masterPekerjaan.php";</script>';
} else {
    echo '<script>alert("Data gagal dihapus");</script>';
    echo '<script>window.location.href = "../masterPekerjaan.php";</script>';
}
?>
