<?php
require_once('../auth/db_login.php');
session_start();

if (isset($_GET['job'])) {
    $job = $_GET['job'];
    $result = $db->query("SELECT * FROM kategori INNER JOIN job ON job.id = kategori.id_job WHERE job='$job'");
    ?>
    <option value="0">Pilih Kategori</option>
    <?php while ($data = $result->fetch_object()): ?>
        <option value="<?php echo $data->kategori ?>"><?php echo $data->kategori ?></option>
    <?php
    endwhile;
}
?>