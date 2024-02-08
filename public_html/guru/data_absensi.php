<?php
// data_absensi.php
include("../../backend/auth/config.php");
session_start();

if (isset($_SESSION['user_id'])) {
    // Pengguna sudah login
    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];
} else {
    // Pengguna belum login, mungkin perlu diarahkan ke halaman login
    header("Location: login.php");
    exit();
}

// Your database queries to get attendance data based on class level here
// Your database query to get class list
// $class_query = "SELECT DISTINCT detail_kelas.kelas_id, kelas.nama_kelas 
//                 FROM detail_kelas 
//                 INNER JOIN kelas ON detail_kelas.kelas_id = kelas.id";
// $class_result = $conn->query($class_query);

$class_query = "SELECT kelas.id, kelas.nama_kelas, guru_mata_pelajaran.mata_pelajaran_id, mata_pelajaran.nama
                 FROM kelas
                 INNER JOIN guru_mata_pelajaran ON kelas.id = guru_mata_pelajaran.kelas
                 INNER JOIN mata_pelajaran ON guru_mata_pelajaran.mata_pelajaran_id = mata_pelajaran.id
                 WHERE guru_mata_pelajaran.guru_id = '$user_id'";
$class_result = $conn->query($class_query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Data Absensi</title>
    <!-- Bootstrap core CSS -->
    <link href="../fm/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../fm/css/sb-admin-2.min.css" rel="stylesheet">
    <!-- Custom fonts for this template -->
    <link href="../fm/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this page -->
    <link href="../fm/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

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
                <a class="nav-link" href="dashboard_guru.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Nav Item - Data Kelas -->
            <li class="nav-item">
                <a class="nav-link" href="absensi.php">
                    <i class="fas fa-fw fa-school"></i>
                    <span>Absensi</span>
                </a>
            </li>

            <!-- Nav Item - Data Siswa -->


        </ul>
        <!-- End of Sidebar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?php //echo $user['username']; 
                                    ?>
                                </span>
                                <img class="img-profile rounded-circle" src="path/to/user_image.jpg">
                            </a>
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
                <div class="container-fluid">

                    <?php
                    // ... (kode sebelumnya)

                    // Menu 1: Daftar Kelas
                    if ($class_result->num_rows > 0) {
                        while ($class_row = $class_result->fetch_assoc()) {
                            $class_id = $class_row['id'];
                            $class_name = $class_row['nama_kelas'];
                    ?>
                            <div class="card mb-4">
                                <div class="card-header">
                                    <a href="?class_id=<?php echo $class_id; ?>"><?php echo "1. Daftar Kelas - $class_name"; ?></a>
                                </div>
                                <!-- ... (kode selanjutnya) ... -->
                            </div>
                    <?php
                        }
                    }
                    ?>


                    <?php
                    // Menu 2: Daftar Mata Pelajaran
                    if (isset($_GET['class_id'])) {
                        $selected_class_id = $_GET['class_id'];
                        $subject_query = "SELECT DISTINCT mata_pelajaran.nama
                            FROM mata_pelajaran
                            INNER JOIN guru_mata_pelajaran ON mata_pelajaran.id = guru_mata_pelajaran.mata_pelajaran_id
                            INNER JOIN detail_kelas ON guru_mata_pelajaran.kelas = detail_kelas.kelas_id
                            WHERE detail_kelas.kelas_id = '$selected_class_id'";
                        $subject_result = $conn->query($subject_query);
                    ?>
                        <div class="card mb-4">
                            <div class="card-header">
                                <a href="?class_id=<?php echo $selected_class_id; ?>"><?php echo "2. Daftar Mata Pelajaran untuk Kelas $class_name"; ?></a>
                            </div>
                            <div class="card-body">
                                <ul>
                                    <?php
                                    while ($subject_row = $subject_result->fetch_assoc()) {
                                        $subject_name = $subject_row['nama'];
                                    ?>
                                        <li><a href="?class_id=<?php echo $selected_class_id; ?>&subject_name=<?php echo $subject_name; ?>"><?php echo $subject_name; ?></a></li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    <?php
                    }
                    ?>


                    <?php
                    // Menu 3: Daftar Tanggal
                    if (isset($_GET['class_id']) && isset($_GET['subject_name'])) {
                        $selected_class_id = $_GET['class_id'];
                        $selected_subject_name = $_GET['subject_name'];
                        $date_query = "SELECT DISTINCT tanggal
                                        FROM absen_mata_pelajaran
                                        WHERE kelas_id = '$selected_class_id'
                                        AND mata_pelajaran_id = (
                                            SELECT id FROM mata_pelajaran WHERE nama = '$selected_subject_name'
                                        )";
                        $date_result = $conn->query($date_query);
                    ?>
                        <div class="card mb-4">
                            <div class="card-header">
                                <a href="?class_id=<?php echo $selected_class_id; ?>&subject_name=<?php echo $selected_subject_name; ?>"><?php echo "3. Daftar Tanggal untuk Kelas $class_name, Mata Pelajaran $selected_subject_name"; ?></a>
                            </div>
                            <div class="card-body">
                                <ul>
                                    <?php
                                    while ($date_row = $date_result->fetch_assoc()) {
                                        $attendance_date = $date_row['tanggal'];
                                    ?>
                                        <li><a href="?class_id=<?php echo $selected_class_id; ?>&subject_name=<?php echo $selected_subject_name; ?>&attendance_date=<?php echo $attendance_date; ?>"><?php echo $attendance_date; ?></a></li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    <?php
                    }
                    ?>


                    <?php
                    // Menu 4: Data Absensi
                    if (isset($_GET['class_id']) && isset($_GET['subject_name']) && isset($_GET['attendance_date'])) {
                        $selected_class_id = $_GET['class_id'];
                        $selected_subject_name = $_GET['subject_name'];
                        $selected_attendance_date = $_GET['attendance_date'];
                        $attendance_query = "SELECT murid.NISN, murid.nama_lengkap, absen_mata_pelajaran.status
                        FROM murid
                        INNER JOIN absen_mata_pelajaran ON murid.NISN = absen_mata_pelajaran.murid_NISN
                        WHERE absen_mata_pelajaran.kelas_id = '$selected_class_id'
                        AND absen_mata_pelajaran.mata_pelajaran_id = (
                            SELECT id FROM mata_pelajaran WHERE nama = '$selected_subject_name'
                        )
                        AND absen_mata_pelajaran.tanggal = '$selected_attendance_date'";
                        $attendance_result = $conn->query($attendance_query);
                    ?>
                        <div class="card mb-4">
                            <div class="card-header">
                                <?php echo "4. Data Absensi untuk Kelas $selected_class_id, Mata Pelajaran $selected_subject_name, Tanggal $selected_attendance_date"; ?>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Student ID</th>
                                            <th>Student Name</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($attendance_row = $attendance_result->fetch_assoc()) {
                                            $nisn = $attendance_row['NISN'];
                                            $student_name = $attendance_row['nama_lengkap'];
                                            $status = $attendance_row['status'];
                                        ?>
                                            <tr>
                                                <td><?php echo $nisn; ?></td>
                                                <td><?php echo $student_name; ?></td>
                                                <td><?php echo $status; ?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php
                    }
                    ?>

                </div>
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
</body>

</html>