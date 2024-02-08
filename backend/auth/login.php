<?php
include("config.php");
// login.php

// Fungsi untuk memberikan respons langsung redirect
function redirectUser($role)
{
    switch ($role) {
        case 'guru':
            header('Location: ../../public_html/guru/dashboard_guru.php');
            exit;
        case 'admin':
            header('Location: dashboard_admin.php');
            exit;
        case 'wali_murid':
            header('Location: dashboard_wali_murid.php');
            exit;
        default:
            header('Location: ../../public_html/waliMurid/dashboard_walimurid.php');
            exit;
    }
}

// Proses login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Lakukan verifikasi login menggunakan prepared statement untuk menghindari SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $role = $user['role'];

        // Inisialisasi sesi
        session_start();

        // Set data pengguna dalam sesi
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $role;

        // Redirect user
        redirectUser($role);
    } else {
        // Jika login gagal, kirim ke halaman login dengan pesan error
        $error = "Login gagal. Periksa kredensial Anda.";
        header("Location: login_page.php?error=" . urlencode($error));
        exit();
    }

    $stmt->close();
} else {
    // Redirect jika halaman diakses secara langsung
    header("Location: login_page.php");
    exit();
}

$conn->close();
