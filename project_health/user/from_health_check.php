<?php
require_once '../config/db.php';
session_start(); // เริ่ม session

if (!isset($_SESSION['user'])) {
    // ถ้าไม่มี session ของผู้ใช้ ให้ redirect ไปที่หน้า login
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user']; // ใช้ข้อมูล session ของผู้ใช้

// ตรวจสอบว่า 'appointment_number' ถูกตั้งค่าใน URL parameters หรือไม่
if (isset($_GET['appointment_number'])) {
    $appointmentNumber = $_GET['appointment_number'];

    // ดึงข้อมูลเพิ่มเติมจากตาราง appointment
    $appointmentInfoQuery = $conn->prepare("SELECT * FROM appointment WHERE appointment_number = :appointment_number");
    $appointmentInfoQuery->bindParam(':appointment_number', $appointmentNumber);
    $appointmentInfoQuery->execute();
    $appointmentInfo = $appointmentInfoQuery->fetch(PDO::FETCH_ASSOC);

    // ตรวจสอบว่ามีข้อมูลใน $appointmentInfo หรือไม่
    if ($appointmentInfo) {
        // ตอนนี้คุณสามารถใช้ $appointmentInfo['appointment_number'] ในโค้ดของคุณได้
        // เช่น คุณสามารถแสดงหรือใช้ในการประมวลผลต่อไป
        $appointmentNumber = $appointmentInfo['appointment_number'];
    } else {
        // จัดการกรณีที่ไม่พบข้อมูล $appointmentInfo
        // คุณอาจต้องแสดงข้อความผิดพลาดหรือดำเนินการอื่นๆ
        echo "ไม่พบข้อมูลการนัดหมาย";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ตรวจสอบว่าฟอร์มถูกส่งหรือไม่
    if (isset($_POST['checkup_status'])) {
        $checkupStatus = $_POST['checkup_status'];

        // เตรียมและ execute คำสั่ง SQL เพื่อแทรกข้อมูลเข้าสู่ตาราง user_checkup
        $insertStatement = $conn->prepare("INSERT INTO user_checkup (user_id, name, id_topic, checkup_subject, checkup_level, check_up_times, checkup_details) 
                                           VALUES (:user_id, :name, :id_topic, :checkup_subject, :checkup_level, :check_up_times, :checkup_details)");

        foreach ($checkupStatus as $checkupId) {
            // ดึงข้อมูลผู้ใช้จากตาราง general_info
            $userInfoQuery = $conn->prepare("SELECT * FROM general_info WHERE user_id = :user_id ORDER BY date DESC LIMIT 1");
            $userInfoQuery->bindParam(':user_id', $user['id']);
            $userInfoQuery->execute();
            $userInfo = $userInfoQuery->fetch(PDO::FETCH_ASSOC);

            // ตรวจสอบว่ามีข้อมูลใน $userInfo หรือไม่
            if ($userInfo) {
                // ตอนนี้คุณสามารถใช้ $userInfo['checkup_level'] ในโค้ดของคุณได้
                $checkupLevel = $userInfo['checkup_level'];
            } else {
                // จัดการกรณีที่ไม่พบข้อมูล $userInfo
                // คุณอาจต้องกำหนดค่าเริ่มต้นหรือดำเนินการอื่นๆ
                $checkupLevel = "default_value";
            }

            // คุณสามารถตั้งค่า check_up_times เป็นค่าที่ต้องการที่นี่
            $checkUpTimes = $appointmentNumber;

            // ดึงข้อมูลการตรวจจากตาราง health_checkup
            $checkupInfoQuery = $conn->prepare("SELECT * FROM health_checkup WHERE id_topic = :checkupId");
            $checkupInfoQuery->bindParam(':checkupId', $checkupId);
            $checkupInfoQuery->execute();
            $checkupInfo = $checkupInfoQuery->fetch(PDO::FETCH_ASSOC);

            if ($checkupInfo) {
                // ตอนนี้คุณสามารถใช้ $checkupInfo['checkup_subject'] และ $checkupInfo['checkup_level'] ในโค้ดของคุณได้
                $insertStatement->bindParam(':user_id', $user['id']);
                $insertStatement->bindParam(':name', $user['name']);
                $insertStatement->bindParam(':id_topic', $checkupId);
                $insertStatement->bindParam(':checkup_subject', $checkupInfo['checkup_subject']);
                $insertStatement->bindParam(':checkup_level', $checkupLevel);
                $insertStatement->bindParam(':check_up_times', $checkUpTimes);

                // เพิ่ม checkup_details จากตาราง set_test
                $setTestQuery = $conn->prepare("SELECT checkup_details FROM set_test WHERE id_topic = :checkupId");
                $setTestQuery->bindParam(':checkupId', $checkupId);
                $setTestQuery->execute();
                $setTestInfo = $setTestQuery->fetch(PDO::FETCH_ASSOC);

                if ($setTestInfo) {
                    $insertStatement->bindParam(':checkup_details', $setTestInfo['checkup_details']);
                } else {
                    // จัดการกรณีที่ไม่พบข้อมูล $setTestInfo
                    // คุณอาจต้องกำหนดค่าเริ่มต้นหรือดำเนินการอื่นๆ
                    $insertStatement->bindParam(':checkup_details', "default_details");
                }

                $insertStatement->execute();
            }
        }

        echo '<html>
        <head>
            <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
        </head>
        <style>
            body {
                text-align: center;
                padding: 40px 0;
                background: #6666FF;
            }
            h1 {
                color: #6666FF; /* Updated color */
                font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
                font-weight: 900;
                font-size: 40px;
                margin-bottom: 10px;
            }
            p {
                color: #6666FF; /* Updated color */
                font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
                font-size:20px;
                margin: 0;
            }
            i {
                color: #6666FF;
                font-size: 100px;
                line-height: 200px;
                margin-left:-15px;
            }
            .card {
                background: white;
                padding: 60px;
                border-radius: 4px;
                box-shadow: 0 2px 3px #C8D0D8;
                display: inline-block;
                margin: 0 auto;
                animation: fadeOut 5s ease-in-out;
            }
            .btn-custom {
                background-color: #6666FF; /* Updated color to #6666FF */
                color: white;
                border: none;
                padding: 10px 20px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                margin-top: 20px;
                cursor: pointer;
                border-radius: 4px;
            }
            .btn-custom:hover {
                background-color: #5555CC; /* Darker color on hover */
            }
            @keyframes fadeOut {
                0% {opacity: 1;}
                100% {opacity: 0;}
            }
        </style>
        <body>
            <div class="card">
                <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
                    <i class="checkmark">✓</i>
                </div>
                <h1>Success</h1> 
                <p>We received your data;<br/> thank you!</p>
                <button class="btn-custom" onclick="redirectToDashboard()">OK</button>
            </div>
            <script>
                function redirectToDashboard() {
                    window.location.href = "user_dashboard.php";
                }
            </script>
        </body>
    </html>';
        exit();
    }
}

// ... (โค้ด PHP ที่มีอยู่) ...
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
    <style>
        body {
            background-color: #ffffff; /* Set the background color for the entire body */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #ffffff; /* Set the background color for the table */
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }
    </style>


<style>
    /* Add this CSS rule for the button style */
    .btn-purple {
        background-color: purple;
        color: white;
        border: none;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
        border-radius: 4px;
    }

    /* Add a hover effect */
    .btn-purple:hover {
        background-color: darkpurple;
    }
</style>
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
                <!-- ... (your existing topbar content) ... -->
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Display Data Table -->
                    <h1 class="h3 mb-4 text-gray-800">ข้อมูลทั่วไป</h1>
                    <form action="" method="post"> <!-- Removed action attribute, as the form is on the same page -->
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ลำดับ</th>
                                    <th scope="col">เรื่องที่ตรวจ</th>
                                    <th scope="col">รายละเอียด</th>
                                    <th scope="col">การตรวจ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Fetch data from database and display in the table
                                $query = "SELECT * FROM set_test WHERE sect = :appointment_number";
                                $result = $conn->prepare($query);
                                $result->bindParam(':appointment_number', $appointmentNumber);
                                $result->execute();

                                if ($result->rowCount() > 0) {
                                    $counter = 1;
                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<tr>";
                                        echo "<td>{$counter}</td>";
                                        echo "<td>{$row['checkup_subject']}</td>";
                                        echo "<td>{$row['checkup_details']}</td>";
                                        echo "<td><input type='checkbox' name='checkup_status[]' value='{$row['id_topic']}'></td>";
                                        echo "</tr>";
                                        $counter++;
                                    }

                                    echo "<tr><td colspan='4'><button class='btn btn-primary btn-sm' type='submit'>บันทึกการตรวจ</button></td></tr>";

                                } else {
                                    echo "<tr><td colspan='4'>No data available</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </form>
                    <!-- End Data Table -->
                </div>
                </div><?php
            include '../footer.php';
            ?>
                
                <!-- End of Main Content -->
            </div>
            
            <!-- End of Content Wrapper -->
        </div>
        
        
        <!-- End of Page Wrapper -->

        
        

        <!-- Bootstrap core JavaScript-->
        <script src="../vendor/jquery/jquery.min.js"></script>
        <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- Core plugin JavaScript-->
        <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
        <!-- Custom scripts for all pages-->
        <script src="../js/sb-admin-2.min.js"></script>
    </body>

</html>
