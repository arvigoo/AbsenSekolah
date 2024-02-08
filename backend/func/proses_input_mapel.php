<?php
include("../auth/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $kode_mapel = $_POST['kode_mapel'];
    $nama_mapel = $_POST['nama_mapel'];


    // Query untuk menyimpan data guru mata pelajaran ke database
    $sqlTambahGuruMapel = "INSERT INTO mata_pelajaran (kode, nama) VALUES ('$kode_mapel', '$nama_mapel')";

    if ($conn->query($sqlTambahGuruMapel) === TRUE) {
        $success = "Data guru mata pelajaran berhasil ditambahkan.";
        header("Location: ../../public_html/admin/dashboard_admin.php");
        exit();
    } else {
        $error = "Error: " . $sqlTambahGuruMapel . "<br>" . $conn->error;
        header("Location: input_guru_mapel.php?error=" . urlencode($error));
        exit();
    }
} else {
    // Redirect jika halaman diakses secara langsung
    header("Location: input_guru_mapel.php");
    exit();
}
