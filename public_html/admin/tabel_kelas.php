<?php
include("../../backend/auth/config.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Tables</title>

    <!-- Custom fonts for this template -->
    <link href="../fm/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../fm/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../fm/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="user_dashboard.php">
                <div class="sidebar-brand-icon">
                    <!-- Ganti dengan tag <img> untuk menampilkan gambar dari path -->
                    <img src="../fm/img/logo.png" alt="Logo" style="width: 50px; height: 50px;">
                </div>
                <div class="sidebar-brand-text mx-3">Dashboard</div>
            </a>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="user_dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Nav Item - Data Kelas -->
            <li class="nav-item">
                <a class="nav-link" href="data_kelas.php">
                    <i class="fas fa-fw fa-school"></i>
                    <span>Data Kelas</span>
                </a>
            </li>

            <!-- Nav Item - Data Siswa -->
            <li class="nav-item">
                <a class="nav-link" href="data_siswa.php">
                    <i class="fas fa-fw fa-user-graduate"></i>
                    <span>Data Siswa</span>
                </a>
            </li>

            <!-- Nav Item - Data Guru -->
            <li class="nav-item">
                <a class="nav-link" href="data_guru.php">
                    <i class="fas fa-fw fa-chalkboard-teacher"></i>
                    <span>Data Guru</span>
                </a>
            </li>

            <!-- Nav Item - Data Mata Pelajaran -->
            <li class="nav-item">
                <a class="nav-link" href="data_mata_pelajaran.php">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Data Mata Pelajaran</span>
                </a>
            </li>

        </ul>

        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?php //echo $user['username']; 
                                    ?>
                                </span>
                                <img class="img-profile rounded-circle" src="path/to/user_image.jpg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="../fm/public/profile.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <!-- ... (Kode sebelumnya) ... -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <h2 class="mb-4">Data Kelas</h2>

                    <!-- Tabel Data Murid -->

                    <?php
                    $sqlKelas = "SELECT * FROM kelas ORDER BY tingkat, nama_kelas";
                    $resultKelas = $conn->query($sqlKelas);

                    if ($resultKelas->num_rows > 0) {
                        $tingkatArr = array();

                        while ($rowKelas = $resultKelas->fetch_assoc()) {
                            $tingkat = $rowKelas['tingkat'];

                            // Menyimpan satu data unik berdasarkan tingkat
                            $tingkatArr[$tingkat][] = $rowKelas;
                        }

                        // Menampilkan kelas berdasarkan tingkat
                        foreach ($tingkatArr as $tingkat => $kelasArr) {
                            echo "<div class='card shadow mb-4'>";
                            echo "<div class='card-header py-3'>";
                            echo "<h6 class='m-0 font-weight-bold text-primary'>Tingkat $tingkat</h6>";
                            echo "</div>";
                            echo "<div class='card-body'>";
                            echo "<div class='table-responsive'>";
                            echo "<table class='table table-bordered' width='100%' cellspacing='0'>";
                            echo "<thead>";
                            echo "<tr><th>Nama Kelas</th><th>Wali Kelas ID</th><th>Action</th></tr>";
                            echo "</thead>";
                            echo "<tbody>";

                            foreach ($kelasArr as $rowKelas) {
                                echo "<tr>";
                                echo "<td>" . $rowKelas['nama_kelas'] . "</td>";
                                echo "<td>" . $rowKelas['wali_kelas_id'] . "</td>";
                                echo "<td>
                                        <a href='../../backend/func/view_kelas.php?id=" . $rowKelas['id'] . "' class='btn btn-info btn-sm'><i class='fas fa-eye'></i> View</a>
                                        <a href='edit_kelas.php?id=" . $rowKelas['id'] . "' class='btn btn-warning btn-sm'><i class='fas fa-edit'></i> Edit</a>
                                        <a href='hapus_kelas.php?id=" . $rowKelas['id'] . "' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i> Hapus</a>
                                    </td>";
                                echo "</tr>";
                            }

                            echo "</tbody>";
                            echo "</table>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p class='text-center'>Tidak ada data kelas.</p>";
                    }
                    ?>



                </div>

                <!-- ... (Kode selanjutnya) ... -->



                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="text-center my-auto">
                        <span>Place sticky footer content here.</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="../fm/../fm/backend/logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../fm/vendor/jquery/jquery.min.js"></script>
    <script src="../fm/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../fm/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../fm/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../fm/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../fm/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../fm/js/demo/datatables-demo.js"></script>

    <!-- Inisialisasi DataTables -->
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>

</body>

</html>