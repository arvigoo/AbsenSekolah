<?php
include("../auth/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $id_guru = $_POST['id_guru'];
    $id_mapel = $_POST['id_mapel'];
    $id_kelas = $_POST['id_kelas'];


    // Query untuk menyimpan data guru mata pelajaran ke database
    $sqlTambahGuruMapel = "INSERT INTO guru_mata_pelajaran (guru_id, mata_pelajaran_id, kelas) VALUES ('$id_guru', '$id_mapel', '$id_kelas')";

    if ($conn->query($sqlTambahGuruMapel) === TRUE) {
        $success = "Data guru mata pelajaran berhasil ditambahkan.";
        header("Location: input_rolepel?success=" . urlencode($success));
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
