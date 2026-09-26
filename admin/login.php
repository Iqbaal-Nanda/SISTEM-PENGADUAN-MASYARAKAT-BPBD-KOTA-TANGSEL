<?php
require_once("database.php");
// Proses dari form login
$message = "";
if (isset($_POST['login']) && $_POST['login'] == "Login") {
    $username = $_POST['username']; // simpan input dari username ke var username
    $password = $_POST['password']; // simpan input dari password ke var password

    // Query menggabungkan tabel admin dan divisi untuk mendapatkan nama divisi
    $sql = "SELECT a.*, d.nama_divisi 
            FROM admin a 
            INNER JOIN divisi d ON a.divisi = d.id_divisi
            WHERE a.username = :username 
              AND a.password = SHA2(:password, 0)
              AND a.divisi IN (0, 1)";

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':password', $password);
    $stmt->execute();
    $valid_user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($valid_user) {
        session_start();
        $_SESSION["admin"] = $username;
        // Simpan nama divisi ke session agar bisa digunakan di dashboard nanti
        $_SESSION["divisi"] = $valid_user["nama_divisi"];
        header("Location: index");
    } else {
        $message = "Username atau Password Salah";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="images/logotangerangselatan.png">
    <title>Login - Admin BPBD</title>
    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
    <!-- Custom fonts for this template-->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="css/admin.css" rel="stylesheet">
    <script src="js/gradient.js"></script>
</head>

<body id="gradient">
    <div class="container">
        <div class="card container card-login mx-auto mt-5">
            <img src="images/logotangerangselatan.png" alt="Logo" class="logo">
            <h3 class="text-center" style="padding-top:8px; font-family: 'Poppins', sans-serif; font-weight: 600;">Login</h3>
            <hr class="custom">
            <div class="card-body">
                <form method="post">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input class="form-control" id="username" type="text" name="username" aria-describedby="userHelp" placeholder="Enter Username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input class="form-control" id="password" name="password" type="password" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox"> Remember Password
                            </label>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-primary btn-block card-shadow-2" name="login" value="Login">
                </form>
            </div>
            <p class="text-center text-danger"><small><?php echo @$message; ?></small></p>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
</body>

</html>