<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Infogate</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;400;700&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
	<link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="../assets/vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
	<link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
	<link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">       

    <!-- Bootstrap CSS File -->
	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> -->

    <!-- Template Main CSS File -->
    <link href="../assets/css/style.css" rel="stylesheet">

    <!-- IMG File -->
    <link rel="shortcut icon" type="image/png" href="../assets/img/logo.png">
    
</head>
<body>
    <div class="overlay"></div>
    <form method="POST" action='auth/cek_login.php' class="box">
        <div class="alert">
            <?php
                if (isset($_SESSION['notification'])) {
                    $notification = $_SESSION['notification'];
                    $type = $notification['type'];
                    $message = $notification['message'];
                    unset($_SESSION['notification']);

                    echo '<div id="notification" class="alert alert-' . ($type == 'success' ? 'success' : 'danger') . ' alert-dismissible fade show" role="alert">';
                    echo $message;
                    echo '</div>';
                }
            ?>
        </div>
        <div class="header">
            <center><h2 style="margin-top: revert;">LOGIN</h2></center>
        </div>
        <div class="login-area">
            <input type="text" name="username" class="username" placeholder="Username" required>
            <input type="password" name="password" class="password" placeholder="Password" required>
            <input type="submit" class="submit" value="Login">
            <p style="font-size:16px;">
            <small>Gerbang Informasi - Pustik Crew - H&I
                    <br>
                    ©2023 Infogate
            </small>
        </div>
    </form>
    <script>
    setTimeout(function() {
        var notification = document.getElementById('notification');
        if (notification) {
            notification.style.display = 'none';
        }
    }, 1000); 
	</script>

    <!-- Template Main JS File -->
    <script src="../assets/js/script.js"></script>

</body>
</html>
