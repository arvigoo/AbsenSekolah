<?php
include("../auth/config.php");

// Ambil data dari form
$id = $_POST["id"];
$nip = $_POST["nip"];
$nama = $_POST["nama"];
$email = $_POST["email"];
$tanggal_lahir = $_POST["tanggal_lahir"];

// Cek apakah ID sudah ada data di tabel guru
$sqlCheckExistingData = "SELECT * FROM guru WHERE id = '$id'";
$resultCheckExistingData = $conn->query($sqlCheckExistingData);

if ($resultCheckExistingData->num_rows > 0) {
    // Jika sudah ada data, lakukan proses edit
    $sqlEditGuru = "UPDATE guru SET NIP = '$nip', nama = '$nama', email = '$email', tanggal_lahir = '$tanggal_lahir' WHERE id = '$id'";
} else {
    // Jika belum ada data, lakukan proses insert
    $sqlEditGuru = "INSERT INTO guru (id, NIP, nama, email, tanggal_lahir) VALUES ('$id', '$nip', '$nama', '$email', '$tanggal_lahir')";
}

if ($conn->query($sqlEditGuru) === TRUE) {
    // Data berhasil disimpan atau diupdate
    echo "<script>alert('Data guru berhasil disimpan.');</script>";
    header("Location: ../../public_html/guru/data_guru.php");
    exit();
} else {
    // Terjadi error
    echo "Error: " . $sqlEditGuru . "<br>" . $conn->error;
}

// Tutup koneksi
$conn->close();
?>
