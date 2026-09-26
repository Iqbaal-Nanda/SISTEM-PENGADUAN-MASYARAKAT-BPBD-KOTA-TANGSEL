<?php
session_start();
require_once("../private/database.php");
require_once("../private/auth.php");

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['user_id']);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Pengaduan BPBD</title>
    <link rel="shortcut icon" href="images/logotangerangselatan.png">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link href="css/style.css" rel="stylesheet">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.js"></script>
</head>

<body>
    <div class="container">
        <h1 class="text-center">Selamat Datang di Website Pengaduan BPBD</h1>

        <?php if ($isLoggedIn): ?>
            <p class="text-center">Halo, <?php echo htmlspecialchars($_SESSION['username']); ?>! <a href="logout.php">Logout</a></p>
        <?php else: ?>
            <p class="text-center">Silakan <a href="login.php">Login</a> atau <a href="register.php">Daftar</a></p>
        <?php endif; ?>

        <!-- Additional content can go here -->

    </div>
</body>
</html>