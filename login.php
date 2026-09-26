<?php

require_once("private/database.php");

// Atur session cookie yang aman (gunakan HTTPS agar flag 'secure' aktif)
session_set_cookie_params([
    'lifetime' => 0,
    'path'     => '/',
    'domain'   => '',
    'secure'   => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
    'httponly' => true,
    'samesite' => 'Strict'
]);
session_start();

// Buat token CSRF jika belum ada
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Konfigurasi rate limiting    
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['last_attempt'] = time();
}
$attempt_limit = 3;      // Batas maksimum percobaan gagal
$block_time    = 30;    // Waktu blok (dalam detik), misal 30 detik

// Konfigurasi reCAPTCHA (pakai kunci test Google untuk localhost)
$recaptcha_site_key   = "6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI";
$recaptcha_secret_key = "6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe";


$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Jika sudah mencapai batas gagal dan belum melewati waktu blok
    if ($_SESSION['login_attempts'] >= $attempt_limit &&
        (time() - $_SESSION['last_attempt']) < $block_time) {
        $remaining = $block_time - (time() - $_SESSION['last_attempt']);
        $message = "Terlalu banyak percobaan gagal. Silakan coba lagi dalam {$remaining} detik.";
    } else {
        // Reset counter jika telah melewati block time
        if ((time() - $_SESSION['last_attempt']) >= $block_time) {
            $_SESSION['login_attempts'] = 0;
        }
        
        // Validasi token CSRF
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $message = "Invalid CSRF token.";
        } else {
            // Jika jumlah login gagal sudah mencapai batas, periksa reCAPTCHA
            if ($_SESSION['login_attempts'] >= $attempt_limit) {
                $captcha = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : "";
                if (empty($captcha)) {
                    $message = "Silakan verifikasi captcha.";
                } else {
                    $verifyResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$recaptcha_secret_key}&response={$captcha}&remoteip=".$_SERVER['REMOTE_ADDR']);
                    $responseData = json_decode($verifyResponse);
                    if (!$responseData->success) {
                        $message = "Verifikasi captcha gagal.";
                    }
                }
            }
            
            // Jika tidak ada pesan error dari captcha, lanjutkan validasi input
            if (empty($message)) {
                $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
                $password = $_POST['password'];
    
                if (!$email || empty($password)) {
                    $message = "Email dan password harus diisi dengan benar.";
                } else {
                    $sql = "SELECT * FROM users WHERE email = :email";
                    $stmt = $db->prepare($sql);
                    $stmt->bindValue(':email', $email);
                    $stmt->execute();
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
                    if ($user && password_verify($password, $user['password'])) {
                        // Reset counter jika sukses
                        $_SESSION['login_attempts'] = 0;
        
                        // Regenerasi session untuk menghindari session fixation
                        session_regenerate_id(true);
                        $_SESSION['user'] = $user['nama'];
        
                        // Perbarui CSRF token setelah login
                        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                        header("Location: index.php");
                        exit;
                    } else {
                        $_SESSION['login_attempts']++;
                        $_SESSION['last_attempt'] = time();
                        $message = "Email atau password salah.";
                    }
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
    <title>Login Pengguna</title>
    <link rel="shortcut icon" href="images/logotangerangselatan.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <?php
    // Jika jumlah gagal telah mencapai batas, kita sertakan API reCAPTCHA
    if ($_SESSION['login_attempts'] >= $attempt_limit) {
        echo '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
    }
    ?>
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
        .login-container {
            background-color: #fff;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
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
        .register-link {
            text-align: center;
            margin-top: 15px;
        }
        .register-link a {
            color: #4caf50;
            text-decoration: none;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
        .logo {
            display: block;
            margin: 0 auto 20px;
            width: 100px;
            height: auto;
        }
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animated {
            animation-duration: 1s;
            animation-fill-mode: both;
        }
        .fadeInDown { animation-name: fadeInDown; }
        .fadeInUp { animation-name: fadeInUp; }
    </style>
</head>
<body>
    <div class="login-container">
        <img src="images/logotangerangselatan.png" alt="Logo" class="logo">
        <h2 class="animated fadeInDown">Login Masyarakat</h2>
        <form method="POST" class="animated fadeInUp">
            <!-- Sertakan token CSRF -->
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="email" name="email" class="input-field" placeholder="Email" required><br>
            <div class="password-container">
                <input type="password" name="password" id="password" class="input-field" placeholder="Password" required>
                <span class="toggle-password" onclick="togglePassword()">
                    <i id="password-icon" class="fa fa-eye-slash"></i>
                </span>
            </div>
            <?php
            // Bisa tampilkan widget reCAPTCHA jika sudah mencapai batas gagal
            if ($_SESSION['login_attempts'] >= $attempt_limit) {
                echo '<div class="g-recaptcha" data-sitekey="'.$recaptcha_site_key.'"></div><br>';
            }
            ?>
            <button type="submit" class="btn">Login</button>
        </form>
        <div class="register-link">
            <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
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
    <?php if ($message): ?>
    <script>
        alert("<?php echo addslashes($message); ?>");
    </script>
    <?php endif; ?>
</body>
</html>