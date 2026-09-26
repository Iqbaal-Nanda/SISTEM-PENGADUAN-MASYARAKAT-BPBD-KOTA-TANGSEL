<?php
session_start();
require_once("database.php");

// Atasi Undefined
$nama = $email = $telpon = $alamat = $pengaduan = $koordinat = $is_valid = "";
$namaError = $emailError = $telponError = $alamatError = $pengaduanError = $koordinatError = "";

if (isset($_POST['submit'])) {
    $nomor     = $_POST['nomor'];
    $nama      = $_POST['nama'];
    $email     = $_POST['email'];
    $telpon    = $_POST['telpon'];
    $alamat    = $_POST['alamat'];
    $tujuan_form = $_POST['tujuan']; 
    $pengaduan = $_POST['pengaduan'];
    $koordinat = $_POST['koordinat'];
    // Variabel $kategori dari $_POST['kategori'] tidak ada di form lapor.php, jadi dihapus.

    // --- LOGIKA UNTUK MENENTUKAN JENIS LAPORAN AKHIR UNTUK KOLOM KATEGORI ---
    $jenis_laporan_akhir = $tujuan_form; // Default ambil dari nilai select
    // Jika 'tujuan' yang dipilih adalah 'lainnya' dan input 'tujuan_lain' tidak kosong,
    // gunakan nilai dari 'tujuan_lain' sebagai jenis laporan akhir.
    if ($tujuan_form === 'lainnya' && !empty($_POST['tujuan_lain'])) {
        $jenis_laporan_akhir = $_POST['tujuan_lain'];
    }
    // --- AKHIR LOGIKA ---


    $is_valid  = true;
    validate_input();

    // Proses upload foto
    $foto = $_FILES['foto'];
    $fotoName = time() . '_' . $foto['name']; // Nama file unik
    $fotoPath = '../uploads/' . $fotoName; // Lokasi penyimpanan file

    // Cek apakah ada file foto yang diunggah dan apakah berhasil diunggah
    if ($foto['error'] !== UPLOAD_ERR_NO_FILE) { // Cek jika ada file yang diunggah
        if (!move_uploaded_file($foto['tmp_name'], $fotoPath)) {
            $fotoError = "Gagal mengunggah foto";
            $is_valid = false;
        }
    } else {
        // Jika tidak ada file diunggah, set fotoName menjadi null atau string kosong
        $fotoName = null; // Atau $fotoName = ""; tergantung kebutuhan database
    }


    if ($is_valid) {
        // --- MODIFIKASI QUERY INSERT UNTUK MENYIMPAN JENIS LAPORAN KE KOLOM 'kategori' ---
        // Kolom 'tujuan' tetap ada di INSERT, diisi dengan nilai asli dari form field 'tujuan'
        $sql = "INSERT INTO `laporan`
                (`id`, `nama`, `email`, `telpon`, `alamat`, `tujuan`, `isi`, `foto`, `koordinat`, `kategori`, `tanggal`, `status`)
                VALUES
                (:nomor, :nama, :email, :telpon, :alamat, :tujuan_db, :isi, :foto, :koordinat, :kategori_db, CURRENT_TIMESTAMP, :status)";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':nomor', $nomor);
        $stmt->bindValue(':nama', $nama);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':telpon', $telpon);
        $stmt->bindValue(':alamat', htmlspecialchars($alamat));
        $stmt->bindValue(':tujuan_db', $tujuan_form); // Bind nilai asli dari form field 'tujuan' ke kolom DB 'tujuan'
        $stmt->bindValue(':isi', htmlspecialchars($pengaduan));
        $stmt->bindValue(':foto', $fotoName); // Bind the potentially null fotoName
        $stmt->bindValue(':koordinat', htmlspecialchars($koordinat));
        $stmt->bindValue(':kategori_db', $jenis_laporan_akhir); // Bind jenis laporan akhir ke kolom DB 'kategori'
        $stmt->bindValue(':status', "Menunggu");
        // --- AKHIR MODIFIKASI QUERY INSERT ---


        // Execute the statement and check for errors
        if ($stmt->execute()) {
            // Success
            header("Location: ../index?status=success");
            exit(); // Always exit after header redirect
        } else {
            // Error during execution
            $errorInfo = $stmt->errorInfo();
            // Log the error server-side for debugging
            error_log("Database Error: " . $errorInfo[2]);
            // Redirect back to lapor.php with an error flag
            header("Location: ../lapor.php?status=db_error");
            exit(); // Always exit after header redirect
        }
    } else {
        // Jika validasi gagal, redirect back to lapor page with errors
        header("Location: ../lapor.php?nomor=$nomor&nama=$nama&namaError=$namaError&email=$email&emailError=$emailError&telpon=$telpon&telponError=$telponError&alamat=$alamat&alamatError=$alamatError&pengaduan=$pengaduan&pengaduanError=$pengaduanError&koordinat=$koordinat&koordinatError=$koordinatError");
        exit(); // Always exit after header redirect
    }
}

// ---------------------------
// FUNGSI VALIDASI
// ---------------------------

function validate_input()
{
    global $nama, $email, $telpon, $alamat, $pengaduan, $koordinat, $is_valid;
    // echo "Validating input...<br>"; // Debugging line
    cek_nama($nama);
    cek_email($email);
    cek_telpon($telpon);
    cek_alamat($alamat);
    cek_pengaduan($pengaduan);
    cek_koordinat($koordinat);
    // echo "Validation finished. is_valid: " . ($is_valid ? 'true' : 'false') . "<br>"; // Debugging line
}

function cek_nama($nama)
{
    global $namaError, $is_valid;
    // echo "cek_nama      : ", $nama, "<br>"; // Debugging line
    if (!preg_match("/^[a-zA-Z ]*$/", $nama)) {
        $namaError = "Nama hanya boleh huruf dan spasi.";
        $is_valid = false;
    } else {
        $namaError = "";
    }
}

function cek_email($email)
{
    global $emailError, $is_valid;
    // echo "cek_email     : ", $email, "<br>"; // Debugging line
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = "Email tidak valid.";
        $is_valid = false;
    } else {
        $emailError = "";
    }
}

function cek_telpon($telpon)
{
    global $telponError, $is_valid;
    // echo "cek_telpon    : ", $telpon, "<br>"; // Debugging line
    if (!preg_match("/^[0-9]*$/", $telpon)) {
        $telponError = "Telpon hanya boleh angka.";
        $is_valid = false;
    } elseif (strlen($telpon) != 12) {
        $telponError = "Panjang telpon harus 12 digit.";
        $is_valid = false;
    } else {
        $telponError = "";
    }
}

function cek_alamat($alamat)
{
    global $alamatError, $is_valid;
    // echo "cek_alamat    : ", $alamat, "<br>"; // Debugging line
    if (!preg_match("/^[a-zA-Z0-9 ,.\-\/]*$/", $alamat)) {
        $alamatError = "Alamat hanya boleh huruf, angka, spasi, koma, titik, garis miring, dan tanda minus.";
        $is_valid = false;
    } else {
        $alamatError = "";
    }
}

function cek_pengaduan($pengaduan)
{
    global $pengaduanError, $is_valid;
    // echo "cek_pengaduan : ", $pengaduan, "<br>"; // Debugging line
    if (strlen($pengaduan) > 2048) {
        $pengaduanError = "Isi pengaduan tidak boleh lebih dari 2048 karakter.";
        $is_valid = false;
    } else {
        $pengaduanError = "";
    }
}

function cek_koordinat($koordinat)
{
    global $koordinatError, $is_valid;
    // echo "cek_koordinat : ", $koordinat, "<br>"; // Debugging line
    if (empty($koordinat)) {
        $koordinatError = "Koordinat harus diisi.";
        $is_valid = false;
    } else {
        $koordinatError = "";
    }
}
