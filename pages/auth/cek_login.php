<?php
// active session
session_start();

// connect database
require_once('db_login.php');

// assign username and password from login form
$username = $_POST['username'];
$password = $_POST['password'];

// selection user data from database
$login = $db->query("SELECT * FROM user WHERE username='$username' AND password='$password'");

// count the amount of user data
$result = mysqli_num_rows($login);

// if user data is more than 0, then login is success
if ($result > 0) {

    // Fetch the user data from the database
    $query = "SELECT * FROM user WHERE username='$username'";
    $hasil = $db->query($query);
    $user = $hasil->fetch_assoc();
    
    // Set session variables
    $_SESSION['user'] = $username;
    $_SESSION['username'] = $username;
    $_SESSION['role'] = $user['role'];
    
    // Log the user's activity
    $nama = $user['nama_lengkap'];
    $machineName = gethostname();   //for get current system name 
    $uip = gethostbyname($machineName); //For get ipaddress
    $query = "INSERT INTO `user_log`(username, nama_lengkap, user_ip) values('".$_SESSION['user']."', '$nama', '$uip')";
    $db->query($query);

    $nama_lengkap = $user['nama_lengkap'];
    // Redirect the user to the appropriate page based on their role
    if ($_SESSION['role'] == 'Admin') {
        $_SESSION['notification'] = array(
            'type' => 'success',
            'message' => '<i class="bi bi-check-circle-fill"></i> &nbsp Selamat Datang, '.$nama_lengkap.'!'
        );
        header('Location: ../userAdmin.php');
        exit();
    } else {
        $_SESSION['notification'] = array(
            'type' => 'success',
            'message' => '<i class="bi bi-check-circle-fill"></i> &nbsp Selamat Datang, '.$nama_lengkap.'!'
        );
        header('Location: ../dashboard.php');
        exit();
    }
} else {
    // redirect to login page
    $_SESSION['notification'] = array(
        'type' => 'danger',
        'message' => '<i class="bi bi-exclamation-triangle-fill"></i> &nbsp Username or Password is wrong!'
    );
    header('Location: ../login.php');
}



?>
