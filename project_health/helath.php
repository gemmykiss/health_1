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
$sql = "SELECT * FROM `accidnet_test` Where studentid = $studentid ";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);


?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content>
  <meta name="author" content>

  <!-- Custom fonts for this template-->
  <link href="./css/all.min.css" rel="stylesheet" type="text/css">


  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link rel="stylesheet" href="../css/fonts.css">
  <link rel="stylesheet" href="../css/bg.css">
  <!-- animation -->
  <link rel="stylesheet" href="../css/animation.css">

  <link rel="shortcut icon" href="./image/logo.png" type="image/x-icon">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@300&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>

  <title>ศูนย์ความเป็นเลิศการพัฒนาเด็กประฐมวัย คณะพยาบาลศาสตร์ ม.ขอนแก่น</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="./css/sb-admin-2.min.css" rel="stylesheet">

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

          <!-- Topbar Search -->
          <div class="input-group">
            <h1 class="h3 mb-0 text-gray-800">รายละเอียด</h1>

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">

              <!-- Nav Item - Search Dropdown (Visible Only XS) -->
              <li class="nav-item dropdown no-arrow d-sm-none">
                <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-search fa-fw"></i>
                </a>
                <!-- Dropdown - Messages -->
                <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                  <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                      <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                      <div class="input-group-append">
                        <button class="btn btn-primary" type="button">
                          <i class="fas fa-search fa-sm"></i>
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
              </li>

              <div class="topbar-divider d-none d-sm-block"></div>

            </ul>
        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-start justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">ข้อมูลสุขภาพ</h1>
          </div>

          <div class="card-body text-left shadow">
            <div class="form-group">
              <label for="red_neck">คอแดง: <span><?php echo $row['red_neck']; ?></span></label>
            </div>
            <div class="form-group">
              <label for="burn_wound">แผลร้อนใน: <span><?php echo $row['Burn_wound']; ?></span></label>
            </div>
            <div class="form-group">
              <label for="snot">มีน้ำมูก: <span><?php echo $row['snot']; ?></span></label>
            </div>
            <div class="form-group">
              <label for="cough">ไอ: <span><?php echo $row['cough']; ?></span></label>
            </div>
            <div class="form-group">
              <label for="red_eyes">ตาแดง/ตาแฉะ: <span><?php echo $row['Red_eyes/watery_eyes']; ?></span></label>
            </div>
            <div class="form-group">
              <label for="red_spots">มีจุดแดงฝ่ามือ/ฝ่าเท้า: <span><?php echo $row['Red spots_on_palms/soles_of_feet']; ?></span></label>
            </div>
            <div class="form-group">
              <label for="diarrhea">ท้องเสีย: <span><?php echo $row['diarrhea']; ?></span></label>
            </div>
            <div class="form-group">
              <label for="accident">ได้รับอุบัติเหตุ: <span><?php echo $row['accident']; ?></span></label>
            </div>
          </div>
          <!-- Footer -->
          <?php
          include './footer.php'
          ?>
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
              <h5 class="modal-title" id="exampleModalLabel">Ready to
                Leave?</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="login.html">Logout</a>
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

</body>

</html>