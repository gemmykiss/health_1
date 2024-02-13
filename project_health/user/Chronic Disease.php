<?php
require_once '../config/db.php';
session_start();

if (!isset($_SESSION['user'])) {
    // If no user session, redirect to login
    header("Location: login.php");
    exit();
}
$user = $_SESSION['user']; // Use user session data

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and process form data
    $chronicDisease = $_POST['chronic_disease'] ?? '';
    $procedures = $_POST['procedures'] ?? '';
    $treatmentHistory = $_POST['treatment_history'] ?? '';
    $complications = isset($_POST['complications']) ? implode(', ', $_POST['complications']) : '';

    // Validate the data (add more validation as needed)
    if (empty($chronicDisease)) {
        $error = "กรุณากรอกข้อมูลโรคประจำตัว";
    } else {
        // Check if complications checkbox is checked
        if (isset($_POST['complications']) && !empty($_POST['complications'])) {
            // Check if the complication details are provided
            if (empty($complications)) {
                $error = "กรุณากรอกข้อมูลเพิ่มเติมในช่อง 'อาการแทรกซ้อนคืออะไร'";
            } else {
                // Save the data to the database (replace with your database logic)
                $saveQuery = $conn->prepare("INSERT INTO chronic_disease_info (user_id, name, chronic_disease, procedures, treatment_history, complications) VALUES (:user_id, :name, :chronic_disease, :procedures, :treatment_history, :complications)");
                $saveQuery->bindParam(':user_id', $user['id']);
                $saveQuery->bindParam(':name', $user['name']);  // Add this line to include user's name
                $saveQuery->bindParam(':chronic_disease', $chronicDisease);
                $saveQuery->bindParam(':procedures', $procedures);
                $saveQuery->bindParam(':treatment_history', $treatmentHistory);
                $saveQuery->bindParam(':complications', $complications);

                if ($saveQuery->execute()) {
                    $success = "บันทึกข้อมูลโรคประจำตัวเรียบร้อย";
                } else {
                    $error = "เกิดข้อผิดพลาดในการบันทึกข้อมูล";
                }
            }
        } else {
            // Save the data to the database without complication details
            $saveQuery = $conn->prepare("INSERT INTO chronic_disease_info (user_id, name, chronic_disease, procedures, treatment_history, complications) VALUES (:user_id, :name, :chronic_disease, :procedures, :treatment_history, :complications)");
            $saveQuery->bindParam(':user_id', $user['id']);
            $saveQuery->bindParam(':name', $user['name']);  // Add this line to include user's name
            $saveQuery->bindParam(':chronic_disease', $chronicDisease);
            $saveQuery->bindParam(':procedures', $procedures);
            $saveQuery->bindParam(':treatment_history', $treatmentHistory);
            $saveQuery->bindParam(':complications', $complications);

            if ($saveQuery->execute()) {
                $success = "บันทึกข้อมูลโรคประจำตัวเรียบร้อย";
            } else {
                $error = "เกิดข้อผิดพลาดในการบันทึกข้อมูล";
            }
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
    <title>คณะพยาบาลศาสตร์ ม.ขอนแก่น</title>

    <!-- Custom fonts for this template-->
    <link rel="shortcut icon" href="../image/logo.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Include Header -->
        <?php include "header/header.php"; ?>

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
                        <h1 class="h3 mb-0 text-gray-800">แบบฟอร์มบันทึกข้อมูลโรคประจำตัว(ถ้ามี)</h1>&nbsp; &nbsp;
                        <h1 class="h3 mb-0 text-gray-800">สวัสดี <?php echo $user['name']; ?>!</h1>
                        &nbsp;&nbsp;&nbsp;<img class="img-fluid rounded-circle" src="<?= $user['profile_picture'] ?? 'dogs/image2.jpeg'; ?>" alt="Profile Image" style="width: 40px; height: 40px;">
                    </div>
                </nav>

                <!-- Chronic Disease Form -->
                <div class="container-fluid">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($success)): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $success; ?>
                        </div>
                    <?php endif; ?>

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <form method="POST">
                                <div class="mb-3">
                                    <label for="chronic_disease" class="form-label">โรคประจำตัว</label>
                                    <input type="text" class="form-control" id="chronic_disease" name="chronic_disease">
                                </div>

                                <div class="mb-3">
                                    <label for="procedures" class="form-label">ประวัติการรักษาที่มี</label>
                                    <input type="text" class="form-control" id="procedures" name="procedures">
                                </div>

                                <div class="mb-3">
                                    <label for="treatment_history" class="form-label">ระยะเวลาที่เป็น</label>
                                    <input type="text" class="form-control" id="treatment_history" name="treatment_history">
                                </div>

                                <div class="mb-3">
                                    
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="complication1" name="complications[]" value="Complication1">
                                        <label class="form-check-label" for="complication1">อาการแทรกซ้อน 1</label>
                                    </div>
                                    <!-- Add more complications checkboxes as needed -->
                                </div>

                                <!-- Display complication details if checkbox is checked -->
                                <div class="mb-3">
                                    <label for="complication_details">อาการแทรกซ้อนคืออะไร</label>
                                    <input type="text" class="form-control" id="complication_details" name="complication_details">
                                </div>

                                <button type="submit" class="btn btn-primary">บันทึก</button>
                            </form>
                        </div>
                    
                </div>
                <!-- End Chronic Disease Form -->
            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->

        <!-- Footer -->
        <?php include '../footer.php'; ?>

        <!-- Bootstrap core JavaScript-->
        <script src="../vendor/jquery/jquery.min.js"></script>
        <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- Core plugin JavaScript-->
        <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
        <!-- Custom scripts for all pages-->
        <script src="../js/sb-admin-2.min.js"></script>
    </body>
</html>
