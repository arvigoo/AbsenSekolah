<?php
// absensi.php
include("../../backend/auth/config.php");
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get class ID from the URL parameter
if (isset($_GET['id'])) {
    $class_id = $_GET['id'];

    // Query to retrieve class name and subject name
    $sqlGetClassInfo = "SELECT kelas.nama_kelas, mata_pelajaran.nama, guru_mata_pelajaran.mata_pelajaran_id
                        FROM kelas
                        INNER JOIN guru_mata_pelajaran ON kelas.id = guru_mata_pelajaran.kelas
                        INNER JOIN mata_pelajaran ON guru_mata_pelajaran.mata_pelajaran_id = mata_pelajaran.id
                        WHERE kelas.id = '$class_id'";

    $resultClassInfo = $conn->query($sqlGetClassInfo);

    if ($resultClassInfo->num_rows > 0) {
        $rowClassInfo = $resultClassInfo->fetch_assoc();
        $class_name = $rowClassInfo['nama_kelas'];
        $subject_name = $rowClassInfo['nama'];
        $subject_id = $rowClassInfo['mata_pelajaran_id'];
    } else {
        // Handle the case where class information is not found
        // You might want to redirect or display an error message
        header("Location: dashboard_guru.php");
        exit();
    }

    // Query to retrieve student data for the selected class
    $sqlGetStudents = "SELECT murid.NISN, murid.nama_lengkap 
                       FROM murid
                       INNER JOIN detail_kelas ON murid.NISN = detail_kelas.siswa_NISN
                       WHERE detail_kelas.kelas_id = '$class_id'";

    $resultGetStudents = $conn->query($sqlGetStudents);

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['absen_button'])) {
        // Get the current date
        $attendance_date = date('Y-m-d');
        // Get the class_id from the hidden input field
        $class_id = $_POST['class_id'];

        // Assuming you have a form with input fields named 'nisn', 'status', 'attendance_date', etc.
        foreach ($_POST['attendance_action'] as $nisn => $status) {
            // Insert attendance record into the database
            $sqlInsertAttendance = "INSERT INTO absen_mata_pelajaran (tanggal, mata_pelajaran_id, murid_NISN, status, kelas_id)
                                VALUES ('$attendance_date', '$subject_id', '$nisn', '$status', '$class_id')";

            if ($conn->query($sqlInsertAttendance) === TRUE) {
                echo "Attendance recorded successfully";
            } else {
                echo "Error: " . $sqlInsertAttendance . "<br>" . $conn->error;
            }
        }
    }

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
                    <div class="container-fluid">
                        <h1 class="h3 mb-4 text-gray-800">Absensi Mata Pelajaran <?php echo $subject_name; ?> Kelas <?php echo $class_name ?></h1>
                        <a href='data_absensi.php'>Lihat Data Absensi</a>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card shadow mb-4">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <form method="POST" action="">
                                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>Student ID</th>
                                                            <th>Student Name</th>
                                                            <th>Action</th> <!-- New column for action -->
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php while ($rowStudent = $resultGetStudents->fetch_assoc()) : ?>
                                                            <tr>
                                                                <td><?php echo $rowStudent['NISN']; ?></td>
                                                                <td><?php echo $rowStudent['nama_lengkap']; ?></td>
                                                                <td>
                                                                    <select class="form-control" name="attendance_action[<?php echo $rowStudent['NISN']; ?>]" id="attendance_action_<?php echo $rowStudent['NISN']; ?>">
                                                                        <option value="Hadir">Hadir</option>
                                                                        <option value="Alfa">Alfa</option>
                                                                        <option value="Sakit">Sakit</option>
                                                                        <option value="Izin">Izin</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                        <?php endwhile; ?>
                                                    </tbody>
                                                </table>
                                                <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">

                                                <button type="submit" class="btn btn-primary" name="absen_button">Absen</button>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
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
<?php
} else {
    // Redirect if class ID is not provided
    header("Location: dashboard_guru.php");
    exit();
}
