<?php
// Include file koneksi atau tulis koneksi ke database di sini
include("../auth/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $username = $_POST["username"];
    $password = ($_POST["password"]); // Gunakan password_hash untuk mengamankan password
    $role = "guru";

    // Query untuk insert data ke dalam tabel users
    $sqlInsertUser = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";

    if ($conn->query($sqlInsertUser) === TRUE) {
        echo "User berhasil ditambahkan.";
        echo "<script>alert('Data berhasil disimpan.');</script>";


        // Redirect kembali ke halaman data_guru.php
        header("Location: ../../public_html/admin/data_guru.php");
        exit();
    } else {
        echo "Error: " . $sqlInsertUser . "<br>" . $conn->error;
    }

    // Tutup koneksi
    $conn->close();
}
