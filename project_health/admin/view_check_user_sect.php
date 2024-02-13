<?php
require_once '../config/db.php';
session_start();

// ฟังก์ชันในการดึงค่า sect ที่ไม่ซ้ำจากตาราง set_test
function fetchUniqueSectValues()
{
    global $conn;

    $data = array();

    // ดำเนินการค้นหา SQL เพื่อดึงค่า sect ที่ไม่ซ้ำจาก set_test
    $sql = "SELECT DISTINCT sect FROM set_test ORDER BY sect ASC";
    $result = $conn->query($sql);

    // ตรวจสอบว่าคิวรีเสร็จสมบูรณ์หรือไม่
    if ($result) {
        // ดึงข้อมูลจากผลลัพธ์
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row['sect'];
        }

        // ปิดผลลัพธ์
        $result->closeCursor();
    }

    return $data;
}

// ฟังก์ชันในการดึงข้อมูลสำหรับ sect ที่กำหนด
function fetchDataForSect($sect)
{
    global $conn;

    $data = array();

    // ดำเนินการค้นหา SQL เพื่อดึงข้อมูลสำหรับ sect ที่กำหนดจาก set_test
    $sql = "SELECT id_topic, topic_sect, checkup_subject, checkup_details FROM set_test WHERE sect = :sect ORDER BY id_topic ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':sect', $sect);
    $stmt->execute();

    // ตรวจสอบว่าคิวรีเสร็จสมบูรณ์หรือไม่
    if ($stmt) {
        // ดึงข้อมูลจากผลลัพธ์
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        // ปิดผลลัพธ์
        $stmt->closeCursor();
    }

    return $data;
}

// ดึงค่า sect ที่ไม่ซ้ำ
$uniqueSectValues = fetchUniqueSectValues();
?>

<!DOCTYPE html>
<html lang="th">

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
        <!-- รวม Header -->
        <?php include "header/header.php"; ?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <!-- ... (เนื้อหา topbar ที่มีอยู่ในขณะนี้) ... -->
                <!-- สิ้นสุดของ Topbar -->
                <!-- เริ่มต้นเนื้อหาหลัก -->
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">ข้อมูลทั่วไป</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <form method="post" action="add_data/add_test_set.php">
                                <div class="form-row mb-3">
                                    <?php
                                    // ตรวจสอบว่ามีค่า sect ที่ไม่ซ้ำหรือไม่
                                    if (!empty($uniqueSectValues)) {
                                        foreach ($uniqueSectValues as $sect) {
                                            echo "<div class='col-md-3 mb-2'>";
                                            $sectData = fetchDataForSect($sect);
                                            $topicSect = (!empty($sectData) && !empty($sectData[0]['topic_sect'])) ? $sectData[0]['topic_sect'] : "ไม่พบข้อมูล";

                                            // ปุ่มเพื่อเรียก modal
                                            echo "<button type='button' class='btn btn-primary btn-block' data-toggle='modal' data-target='#modal{$sect}'>ชุดตรวจที่: {$sect} - {$topicSect}</button>";

                                            // โมดัลสำหรับแต่ละ sect
                                            echo "<div class='modal fade' id='modal{$sect}' tabindex='-1' role='dialog' aria-labelledby='modal{$sect}Label' aria-hidden='true'>";
                                            echo "<div class='modal-dialog' role='document'>";
                                            echo "<div class='modal-content'>";
                                            echo "<div class='modal-header'>";
                                            echo "<h5 class='modal-title' id='modal{$sect}Label'>ข้อมูลชุดตรวจที่ {$sect}</h5>";
                                            echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                                            echo "<span aria-hidden='true'>&times;</span>";
                                            echo "</button>";
                                            echo "</div>";

                                            // ตัวเนื้อหาของโมดัล
                                            echo "<div class='modal-body'>";

                                            // แสดงข้อมูลสำหรับ sect นั้น
                                            if (!empty($sectData)) {
                                                echo "<table class='table table-bordered'>";
                                                echo "<thead>";
                                                echo "<tr>";
                                                echo "<th>ID ผู้ใช้</th>";
                                                echo "<th>ชื่อ</th>";
                                                echo "<th>รายละเอียดการตรวจ</th>";
                                                "</tr>";
                                                "</thead>";
                                                echo "<tbody>";

                                                // ดึง user_id และ name จาก user_checkup ที่ check_up_times เท่ากับ sect
                                                $sqlUserCheckup = "SELECT DISTINCT user_id, name FROM user_checkup WHERE check_up_times = :sect ORDER BY user_id ASC";
                                                $stmtUserCheckup = $conn->prepare($sqlUserCheckup);
                                                $stmtUserCheckup->bindParam(':sect', $sect);
                                                $stmtUserCheckup->execute();

                                                // ดึงและแสดง user_id และ name
                                                while ($userCheckupRow = $stmtUserCheckup->fetch(PDO::FETCH_ASSOC)) {
                                                    $user_id = $userCheckupRow['user_id']; // Define $user_id here
                                                    echo "<tr>";
                                                    echo "<td>{$userCheckupRow['user_id']}</td>";
                                                    echo "<td>{$userCheckupRow['name']}</td>";

                                                    // เพิ่มปุ่มลิงค์ดูรายละเอียดการตรวจ
                                                    echo "<td><a class='btn btn-primary' href='view_checkup_user_detel.php?user_id={$user_id}&sect={$sect}'>ดูรายละเอียด</a></td>";


                                                    echo "</tr>";
                                                }

                                                // ปิด statement
                                                $stmtUserCheckup->closeCursor();

                                                echo "</tbody>";
                                                echo "</table>";
                                            } else {
                                                echo "ไม่พบข้อมูลชุดตรวจสำหรับ {$sect}";
                                            }

                                            echo "</div>";

                                            // ส่วนท้ายของโมดัล
                                            echo "<div class='modal-footer'>";
                                            echo "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>";
                                            echo "</div>";

                                            echo "</div>";
                                            echo "</div>";
                                            echo "</div>";

                                            echo "</div>";
                                        }
                                    } else {
                                        echo "<div class='col-md-12'>ไม่พบข้อมูลชุดตรวจ</div>";
                                    }
                                    ?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>
</body>

</html>
