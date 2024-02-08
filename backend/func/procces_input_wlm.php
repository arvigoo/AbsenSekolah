<?php
include("../auth/config.php");

// Ambil data dari form
$id = $_POST["user_id"];
$murid = $_POST["murid_nisn"];
$nama = $_POST["nama"];
$email = $_POST["email"];
$tanggal_lahir = $_POST["tanggal_lahir"];

// Cek apakah ID sudah ada data di tabel guru
$sqlCheckExistingData = "SELECT * FROM walimurid WHERE id = '$id'";
$resultCheckExistingData = $conn->query($sqlCheckExistingData);

if ($resultCheckExistingData->num_rows > 0) {
    // Jika sudah ada data, lakukan proses edit
    $sqlEditGuru = "UPDATE guru SET NIP = '$nip', nama = '$nama', email = '$email', tanggal_lahir = '$tanggal_lahir' WHERE id = '$id'";
} else {
    // Jika belum ada data, lakukan proses insert
    $sqlEditGuru = "INSERT INTO walimurid (user_id,murid_NISN, nama, email) VALUES ('$id', '$murid', '$nama', '$email')";
}

if ($conn->query($sqlEditGuru) === TRUE) {
    // Data berhasil disimpan atau diupdate
    echo "<script>alert('Data guru berhasil disimpan.');</script>";
    header("Location: ../../public_html/admin/tabel_walimurid.php");
    exit();
} else {
    // Terjadi error
    echo "Error: " . $sqlEditGuru . "<br>" . $conn->error;
}

// Tutup koneksi
$conn->close();
