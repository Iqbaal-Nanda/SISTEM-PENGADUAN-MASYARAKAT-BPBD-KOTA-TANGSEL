<?php
require_once("private/database.php");

// Atur session cookie dengan flag Secure, HttpOnly, dan SameSite (gunakan HTTPS)
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
    'httponly' => true,
    'samesite' => 'Strict'
]);
session_start();

// Buat token CSRF jika belum ada
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Periksa token CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $message = "Invalid CSRF token.";
    } else {
        // Sanitasi dan validasi input
        $nama = trim($_POST['nama']);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password_input = $_POST['password'];

        if (!$nama || !$email || !$password_input) {
            $message = "Data tidak valid.";
        } else {
            // Cek apakah email sudah terdaftar
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':email', $email);
            $stmt->execute();
            if ($stmt->fetch(PDO::FETCH_ASSOC)) {
                $message = "Email sudah digunakan.";
            } else {
                $password = password_hash($password_input, PASSWORD_DEFAULT);

                $sql = "INSERT INTO users (nama, email, password) VALUES (:nama, :email, :password)";
                $stmt = $db->prepare($sql);
                $stmt->bindValue(':nama', $nama);
                $stmt->bindValue(':email', $email);
                $stmt->bindValue(':password', $password);

                try {
                    $stmt->execute();
                    $message = "Registrasi berhasil! Silakan login.";
                    // Buat token baru untuk permintaan berikutnya
                    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                } catch (PDOException $e) {
                    $message = "Terjadi kesalahan: " . $e->getMessage();
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Pengguna</title>
    <link rel="shortcut icon" href="images/logotangerangselatan.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .register-container {
            background-color: #fff;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .logo {
            display: block;
            margin: 0 auto 20px;
            width: 100px;
            height: auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .input-field {
            width: 100%;
            padding: 12px 15px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 16px;
            background-color: #f9f9f9;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        .input-field:focus {
            border-color: #4caf50;
            outline: none;
        }

        .password-container {
            position: relative;
            width: 100%;
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 18px;
            color: #888;
        }

        .toggle-password:hover {
            color: #4caf50;
        }

        .btn {
            display: block;
            margin: 20px auto;
            width: 100%;
            padding: 12px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .login-link {
            text-align: center;
            margin-top: 15px;
        }

        .login-link a {
            color: #4caf50;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        /* Animasi Fade In */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animated {
            animation-duration: 1s;
            animation-fill-mode: both;
        }

        .fadeInDown {
            animation-name: fadeInDown;
        }

        .fadeInUp {
            animation-name: fadeInUp;
        }
    </style>
</head>

<body>
    <div class="register-container">
        <img src="images/logotangerangselatan.png" alt="Logo" class="logo">
        <h2 class="animated fadeInDown">REGISTER</h2>
        <form method="POST" class="animated fadeInUp">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="text" name="nama" class="input-field" placeholder="Nama" required><br>
            <input type="email" name="email" class="input-field" placeholder="Email" required><br>
            <div class="password-container">
                <input type="password" name="password" id="password" class="input-field" placeholder="Password" required>
                <span class="toggle-password" onclick="togglePassword()">
                    <i id="password-icon" class="fa fa-eye-slash"></i>
                </span>
            </div>
            <button type="submit" class="btn">Daftar</button>
        </form>
        <div class="login-link">
            <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
        </div>
    </div>
    <script>
        function togglePassword() {
            const passwordField = document.getElementById("password");
            const passwordIcon = document.getElementById("password-icon");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                passwordIcon.classList.remove("fa-eye-slash");
                passwordIcon.classList.add("fa-eye");
            } else {
                passwordField.type = "password";
                passwordIcon.classList.remove("fa-eye");
                passwordIcon.classList.add("fa-eye-slash");
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <?php if ($message): ?>
        <script>
            alert("<?php echo addslashes($message); ?>");
            <?php if ($message === "Registrasi berhasil! Silakan login.") : ?>
                window.location.href = "login.php";
            <?php endif; ?>
        </script>
    <?php endif; ?>

</body>

</html>