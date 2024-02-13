<?php
require_once '../config/db.php';
session_start(); // Start session

// Include your database access code or functions file
// require_once 'path/to/your/functions.php';

if (!isset($_SESSION['user'])) {
    // If no user session, redirect to login
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user']; // Use user session data

// Example function to retrieve general information by user ID
function getGeneralInfoByUserId($userId) {
    // Connect to the database (modify database credentials accordingly)
    $conn = new mysqli("localhost", "root", "", "health");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to retrieve general information based on user ID
    $sql = "SELECT * FROM general_info WHERE user_id = $userId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch result as an associative array
        $row = $result->fetch_assoc();
        $conn->close();
        return $row;
    } else {
        $conn->close();
        return null;
    }
}

// Retrieve general information data for the user
$generalInfo = getGeneralInfoByUserId($user['id']);
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <!-- Include your head content here -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>โปรไฟล์ของ <?php echo $user['name']; ?></title>

    <!-- Custom fonts for this template-->
    <link rel="shortcut icon" href="./image/logo.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        /* Add your custom styles here */
    </style>
</head>

<body id="page-top">



    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php
        include "header/header.php";
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

                    <div class="input-group">
                        <h1 class="h3 mb-0 text-gray-800">โปรไฟล์ของ <?php echo $user['name']; ?></h1>
                    </div>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">ข้อมูลทั่วไป</h1>

                    <!-- Profile Information -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="m-0 font-weight-bold text-primary">ข้อมูลส่วนตัว</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3">
                                    <img class="img-fluid rounded-circle" src="https://placekitten.com/200/200" alt="Profile Image">
                                </div>
                                <div class="col-lg-9">
                                    <p><strong>ชื่อ:</strong> <?php echo $user['name']; ?></p>

                                    <!-- Add more profile information as needed -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- General Information -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="m-0 font-weight-bold text-primary">ข้อมูลทั่วไป</h5>
                        </div>
                        <div class="card-body">
                            <?php if ($generalInfo) : ?>
                                <p><strong>อายุ:</strong> <?php echo $generalInfo['age']; ?> ปี</p>
                                <p><strong>น้ำหนัก:</strong> <?php echo $generalInfo['weight']; ?> กิโลกรัม</p>
                                <p><strong>ส่วนสูง:</strong> <?php echo $generalInfo['height']; ?> เซนติเมตร</p>
                                <p><strong>การออกกำลังกาย:</strong> <?php echo $generalInfo['exercise_frequency']; ?></p>
                                <p><strong>โรคประจำตัว:</strong> <?php echo $generalInfo['health_condition']; ?></p>
                                <?php if ($generalInfo['has_medical_history']) : ?>
                                    <p><strong>มีประวัติการรักษา:</strong> <?php echo $generalInfo['treatment_history']; ?></p>
                                <?php endif; ?>
                                <p><strong>BMI:</strong> <?php echo $generalInfo['bmi']; ?></p>
                                <p><strong>เฉลี่ย:</strong> <?php echo $generalInfo['bmi_category']; ?></p>
                            <?php else : ?>
                                <p>ไม่พบข้อมูลทั่วไป</p>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

</body>

</html>
