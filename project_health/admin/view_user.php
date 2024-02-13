<?php
require_once '../config/db.php';
session_start(); // Start session

// Fetch user_id values along with the latest date from general_info table
$queryUserDates = "SELECT user_id, MAX(date) AS latest_date FROM general_info GROUP BY user_id";
$resultUserDates = $conn->query($queryUserDates);
$userDates = $resultUserDates->fetchAll(PDO::FETCH_ASSOC);

// Function to fetch user details based on user_id and latest date from user table
function getUserDetails($conn, $userId)
{
    $query = "SELECT * FROM user WHERE id = :userId";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Function to fetch general_info details based on user_id and latest date
function getGeneralInfoDetails($conn, $userId, $latestDate)
{
    $query = "SELECT * FROM general_info WHERE user_id = :userId AND date = :latestDate";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':latestDate', $latestDate, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission
    if (isset($_POST['user_id'])) {
        $selectedUserId = $_POST['user_id'];
        
        // Check if latest_date is sent
        $selectedUserLatestDate = isset($_POST['latest_date']) ? $_POST['latest_date'] : '';

        // Get user details for the selected user from the user table
        $userDetails = getUserDetails($conn, $selectedUserId);

        // Get general_info details for the selected user and latest date
        $generalInfoDetails = getGeneralInfoDetails($conn, $selectedUserId, $selectedUserLatestDate);
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
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <div class="input-group">
                        <h1 class="h3 mb-0 text-gray-800">ดูโปรไฟล์ผู้ใช้งาน</h1>&nbsp; &nbsp;
                    </div>
                </nav>
                <!-- End of Topbar -->


                
                        


                        <div class="col-lg-8">
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="card shadow">
                                        <div class="card-header py-3">
                                            <p class="text-primary m-0 fw-bold">Select User</p>
                                        </div>
                                        <div class="card-body">
                                            <form method="post" action="">
                                                <div class="mb-3">
                                                    <label class="form-label" for="user_id"><strong>Select User</strong></label>
                                                    <select id="user_id" class="form-control" name="user_id" onchange="updateLatestDate()">
                                                        <?php
                                                        foreach ($userDates as $userDate) {
                                                            echo "<option value='{$userDate['user_id']}' data-latest-date='{$userDate['latest_date']}'>{$userDate['user_id']}</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <!-- เพิ่ม hidden input สำหรับ latest_date -->
                                                <input type="hidden" id="latest_date" name="latest_date" value="">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="card shadow">
                                        <div class="card-header py-3">
                                            <p class="text-primary m-0 fw-bold">User Details</p>
                                        </div>
                                        <div class="card-body">
                                        <?php
                                        // Display user details
                                        if (isset($userDetails) && isset($generalInfoDetails)) {
                                            
                                            echo "<p><strong>Name:</strong> {$userDetails['name']}</p>";
                                            
                                            echo "<p><strong>Latest Date:</strong> {$generalInfoDetails['date']}</p>";
                                            echo "<p><strong>Age:</strong> {$generalInfoDetails['age']}</p>";
                                            echo "<p><strong>Weight:</strong> {$generalInfoDetails['weight']}</p>";
                                            echo "<p><strong>Height:</strong> {$generalInfoDetails['height']}</p>";
                                            echo "<p><strong>BMI:</strong> {$generalInfoDetails['bmi']}</p>";
                                            echo "<p><strong>BMI Category:</strong> {$generalInfoDetails['bmi_category']}</p>";
                                        }
                                        ?>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
            include '../footer.php';
            ?>
                </div>




                <!-- Bootstrap core JavaScript-->
                <script src="../vendor/jquery/jquery.min.js"></script>
                <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
                <!-- Core plugin JavaScript-->
                <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
                <!-- Custom scripts for all pages-->
                <script src="../js/sb-admin-2.min.js"></script>
                <!-- เพิ่ม script สำหรับการอัปเดต latest_date -->
                <script>
                    function updateLatestDate() {
                        var select = document.getElementById('user_id');
                        var hiddenInput = document.getElementById('latest_date');
                        var selectedOption = select.options[select.selectedIndex];
                        hiddenInput.value = selectedOption.getAttribute('data-latest-date');
                    }
                </script>
            </body>

            </html>
