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
$sql = "SELECT * FROM `details_student` Where studentid = $studentid ";
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
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">ข้อมูล</h1>
          </div>
          <div class="card-body text-center shadow"><img class="rounded-circle mb-3 mt-4" src="./image_student/<?php echo $row['images']; ?>" width="160" height="160" /></div><br>

          <form class="user" action method="post">
            <div class="form-group row">
              <div class="col-sm-4 mb-3 mb-sm-0">
              <input type="text" class="form-control t1" name="gender" value="<?php echo $row['gender']; ?>" readonly>
              </div>
              <div class="col-sm-4 mb-3 mb-sm-0">
                <input type="text" class="form-control t1" name="firstname" value="<?php echo $row['firstname']; ?>" readonly>
              </div>
              <div class="col-sm-4">
                <input type="text" class="form-control t1" name="lastname" value="<?php echo $row['lastname']; ?>" readonly>
              </div>
            </div>
            <div class="form-group">
              <input type="text" class="form-control t1" name="nickname" value="<?php echo $row['nickname']; ?>" readonly>
            </div>
            <div class="form-group">
              <input type="text" class="form-control t1" name="studentid" maxlength="10" value="<?php echo $row['studentid']; ?>" readonly>
            </div>
            <div class="form-group row">
              <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="date" class="form-control t1" name="birthday" value="<?php echo $row['birtday']; ?>" readonly >
              </div>
              <div class="col-sm-6 col-6">
                <div class="input-group">
                  <input type="text" class="form-control t1" name="age" value="<?php echo $row['age']; ?>" readonly>
                  <span class="input-group-text">ปี</span>
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

        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin-2.min.js"></script>

</body>

</html>