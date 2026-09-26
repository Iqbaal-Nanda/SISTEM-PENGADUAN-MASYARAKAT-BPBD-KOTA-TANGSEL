<?php
// File: admin/check_new_reports.php

// Memastikan file database dan auth di-include
// Sesuaikan path jika struktur folder Anda berbeda
require_once("database.php"); // Asumsi file ini menghubungkan ke database dan membuat objek $db
require_once("auth.php"); // Asumsi file ini memulai session dan mengatur variabel $id_admin

// Mengatur header agar browser tahu responsnya adalah JSON
header('Content-Type: application/json');

$total_laporan_menunggu = 0;

try {
    // Logika untuk menghitung laporan yang statusnya "Menunggu"
    // Ini mereplikasi logika hitungan yang sudah ada di admin/index.php
    if (isset($id_admin) && $id_admin > 0) {
        // Jika admin bukan super admin, hitung laporan menunggu yang ditujukan kepadanya
        $sql = "SELECT COUNT(*) FROM laporan WHERE status = \"Menunggu\" AND laporan.tujuan = :id_admin";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id_admin', $id_admin);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $total_laporan_menunggu = $row[0];
    } else {
        // Jika super admin, hitung semua laporan menunggu
        $sql = "SELECT COUNT(*) FROM laporan WHERE status = \"Menunggu\"";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $total_laporan_menunggu = $row[0];
    }

    // Mengembalikan jumlah laporan menunggu dalam format JSON
    echo json_encode(['count' => $total_laporan_menunggu]);
} catch (PDOException $e) {
    // Menangani error database jika terjadi
    error_log("Database Error in check_new_reports.php: " . $e->getMessage());
    echo json_encode(['error' => 'Database error']);
}

// Pastikan tidak ada output lain setelah ini
exit();
