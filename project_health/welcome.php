<?php
session_start();

if (!isset($_SESSION['studentid'])) {
  header("Location: index.php");
  exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";


$studentid = $_SESSION['studentid'];
$conn = mysqli_connect($servername, $username, $password, $dbname);
$sql = "SELECT * FROM `time` Where studentid = $studentid ";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="shortcut icon" href="./image/logo.png" type="image/x-icon">
  <title>
    ศูนย์ความเป็นเลิศการพัฒนาเด็กประฐมวัย คณะพยาบาลศาสตร์ ม.ขอนแก่น
  </title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />

  <!-- Custom styles for this template-->
  <link href="./css/sb-admin-2.min.css" rel="stylesheet" />
</head>

<body id="page-top">
  <!-- Page Wrapper -->
  <div id="wrapper">

    <?php
    include 'menu.php'
    ?>

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
            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
              </div>
            </li>
            <div class="topbar-divider d-none d-sm-block"></div>
            <!-- Nav Item - User Information -->
          </ul>
        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <!-- Page Heading -->
          <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
              <h1 class="h3 mb-0 text-gray-800">เวลาที่เข้า - เวลาออก</h1>
            </div>
            <div class="form-group row">

              <div class="container-fluid">
                <!-- Page Heading -->
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary text-center">ข้อมูลการเข้า-ออก</h6>
                  </div>
                  <div class="card-body text-center">
                    <!-- Row for เวลาเข้า -->
                    <div class="form-group row mb-3 justify-content-center">
                      <div class="col-sm-6">
                        <label for="loginTime">เวลาเข้า:</label>
                        <input type="text" class="form-control t1 text-center" name="loginTime" value="<?php echo $row['time_in']; ?>" readonly>
                      </div>
                    </div>

                    <!-- Row for เวลาออก -->
                    <div class="form-group row justify-content-center">
                      <div class="col-sm-6">
                        <label for="logoutTime">เวลาออก:</label>
                        <input type="text" class="form-control t1 text-center" name="logoutTime" value="<?php echo $row['time_out']; ?>" readonly>
                      </div>
                    </div>
                  </div>
                </div>
              </div>



              <!-- Bootstrap core JavaScript-->
              <script src="vendor/jquery/jquery.min.js"></script>
              <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

              <!-- Core plugin JavaScript-->
              <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

              <!-- Custom scripts for all pages-->
              <script src="js/sb-admin-2.min.js"></script>

              <!-- Page level plugins -->
              <script src="vendor/chart.js/Chart.min.js"></script>

              <!-- Page level custom scripts -->
              <script src="js/demo/chart-area-demo.js"></script>
              <script src="js/demo/chart-pie-demo.js"></script>
</body>

</html>