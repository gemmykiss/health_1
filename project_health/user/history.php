<?php
require_once '../config/db.php';
session_start(); // Start session

if (!isset($_SESSION['user'])) {
    // If no user session, redirect to login
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user']; // Use user session data
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>กรอกข้อมูลสุขภาพ</title>

    <!-- Custom fonts for this template-->
    <link rel="shortcut icon" href="./image/logo.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        /* Add your custom styles here */
        .error-message {
            color: red;
        }
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
                        <h1 class="h3 mb-0 text-gray-800">แบบฟอร์มบันทึกข้อมูลสุภาพ</h1>&nbsp; &nbsp;
                        <h1 class="h3 mb-0 text-gray-800">สวัสดี <?php echo $user['name']; ?>!</h1>
                    </div>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">ข้อมูลทั่วไป</h1>

                    <!-- General Information Form -->
                    <form action="process_general_info.php" method="post">
                        <div class="form-group">
                            <label for="age">อายุ:</label>
                            <input type="text" name="age" id="age" class="form-control" required>
                        </div>

                        <div class="form-group">
                        <label for="gender">เพศ:</label>
                        <select name="gender" id="gender" class="form-control" required>
                            <option value="ชาย">ชาย</option>
                            <option value="หญิง">หญิง</option>
                            <option value="อื่นๆ">อื่นๆ</option>
                        </select>
                    </div>
                        <div class="form-group">
                            <label for="weight">น้ำหนัก:</label>
                            <input type="text" name="weight" id="weight" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="height">ส่วนสูง:</label>
                            <input type="text" name="height" id="height" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="exercise_frequency">การออกกำลังกาย 1 สัปดาห์เฉลี่ยกี่ครั้งครั้งละกีนาที:</label>
                            <input type="text" name="exercise_frequency" id="exercise_frequency" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="health_condition">โรคประจำตัว:</label>
                            <input type="text" name="health_condition" id="health_condition" class="form-control">
                        </div>

                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="has_medical_history" name="has_medical_history">
                            <label class="form-check-label" for="has_medical_history">มีประวัติการรักษา</label>
                        </div>

                        <!-- ฟอร์มเพิ่มเติมเมื่อมีประวัติการรักษา -->
                        <div id="medicalHistoryForm" style="display: none;">
                            <div class="form-group">
                                <label for="treatment_history">ประวัติการรักษา:</label>
                                <textarea name="treatment_history" id="treatment_history" class="form-control"></textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                    </form>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php
            include '../footer.php';
            ?>

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

    <!-- Custom validation script -->
    <style>
    /* Add your custom styles here */
    .error-message {
        color: #6666FF;
    }
</style>

    <script>

      
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelector('form').addEventListener('submit', function (event) {
                var ageInput = document.getElementById('age');
                var weightInput = document.getElementById('weight');
                var heightInput = document.getElementById('height');

                var ageValue = ageInput.value.trim();
                var weightValue = weightInput.value.trim();
                var heightValue = heightInput.value.trim();

                var isValid = true;
                var errorMessage = "กรุณากรอกข้อมูลเป็นเลข";

                if (!isNumeric(ageValue)) {
                    isValid = false;
                    displayErrorMessage(ageInput, errorMessage);
                }

                if (!isNumeric(weightValue)) {
                    isValid = false;
                    displayErrorMessage(weightInput, errorMessage);
                }

                if (!isNumeric(heightValue)) {
                    isValid = false;
                    displayErrorMessage(heightInput, errorMessage);
                }

                if (!isValid) {
                    event.preventDefault();
                }
            });

            function isNumeric(value) {
                return /^\d+$/.test(value);
            }

            function displayErrorMessage(element, message) {
                var errorMessageElement = document.createElement('div');
                errorMessageElement.className = 'error-message';
                errorMessageElement.textContent = message;

                // Remove existing error message, if any
                var existingErrorMessage = element.nextElementSibling;
                if (existingErrorMessage && existingErrorMessage.classList.contains('error-message')) {
                    existingErrorMessage.remove();
                }

                element.insertAdjacentElement('afterend', errorMessageElement);
            }
        });
    </script>
</body>

</html>
