<?php
session_start(); // เริ่ม session

require_once '../config/db.php';


// ฟังก์ชันสำหรับลบการนัดหมายตาม ID
function deleteAppointment($conn, $appointmentId)
{
    $query = "DELETE FROM appointment WHERE id_appointment = :id_appointment";
    $statement = $conn->prepare($query);
    $statement->bindParam(':id_appointment', $appointmentId);
    return $statement->execute();
}

// ตรวจสอบว่าปุ่มลบถูกคลิกหรือไม่
if (isset($_POST['delete_appointment']) && !empty($_POST['delete_appointment'])) {
    $appointmentIdToDelete = $_POST['delete_appointment'];
    deleteAppointment($conn, $appointmentIdToDelete);
    $_SESSION['success_message'] = 'ลบการส่งชุดตรวจเรียบร้อย';
    header('Location: appointment.php');
    exit();
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

    <style>
        /* Add this style to highlight rows on hover */
        .highlight-row:hover {
            background-color: #f2f2f2; /* เปลี่ยนสีตามต้องการ */
        }
    </style>

</head>

<body id="page-top">

    <?php
    // ตรวจสอบว่ามีข้อความสำเร็จใน session หรือไม่
    if (isset($_SESSION['success_message'])) {
        echo '<div class="alert alert-success" role="alert">';
        echo $_SESSION['success_message'];
        echo '</div>';

        // ลบข้อความสำเร็จจาก session
        unset($_SESSION['success_message']);
    }
    ?>

    <div id="wrapper">
        <!-- รวม Header -->
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
                        <h1 class="h3 mb-0 text-gray-800">ส่งแบบฟอร์มให้ผู้ใช้</h1>&nbsp; &nbsp;
                    </div>
                </nav>
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- เพิ่มเนื้อหาของคุณที่นี่ -->
                    <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="add_data/process_add_appointment.php" method="post">
                                    <div class="form-group">
                                        <label for="appointment_date">วันที่:</label>
                                        <input type="date" class="form-control" id="appointment_date" name="appointment_date" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="appointment_number">ชุดตรวจที่:</label>
                                        <input type="number" class="form-control" id="appointment_number" name="appointment_number" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="topic">ชื่อชุดตรวจ:</label>
                                        <input type="text" class="form-control" id="topic" name="topic" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">ส่งฟอร์มเอกสาร</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                </div>

                <!-- แสดงข้อมูลการนัดหมายในตาราง -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5>รายการที่ส่งฟอร์มชุดตรวจ</h5>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>วันที่</th>
                                                <th>ชุดตรวจ</th>
                                                <th>หัวข้อ</th>
                                                <th>ดำเนินการ</th> <!-- เพิ่มคอลัมน์นี้สำหรับปุ่มลบ -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // ดึงข้อมูลการนัดหมายจากฐานข้อมูล
                                            $query = "SELECT * FROM appointment";
                                            $result = $conn->query($query);

                                            if ($result->rowCount() > 0) {
                                                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                                    echo "<tr class='highlight-row'>";
                                                    echo "<td>" . $row['appointment_date'] . "</td>";
                                                    echo "<td>" . $row['appointment_number'] . "</td>";
                                                    echo "<td>" . $row['topic'] . "</td>";
                                                    echo "<td>";
                                                    
                                                    // เพิ่มการตรวจสอบก่อนที่จะใช้คีย์ 'id_appointment'
                                                    if (isset($row['id_appointment'])) {
                                                        // เพิ่มปุ่มลบพร้อมฟอร์มสำหรับส่ง ID การนัดหมาย
                                                        echo "<form action='' method='post'>";
                                                        echo "<input type='hidden' name='delete_appointment' value='" . $row['id_appointment'] . "'>";
                                                        echo "<button type='submit' class='btn btn-danger btn-sm'>ลบ</button>";
                                                        echo "</form>";
                                                    } else {
                                                        echo "ไม่พบ ID";
                                                    }
                                                    
                                                    echo "</td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr class='highlight-row'><td colspan='4'>ไม่มีรายการชุดตรวจที่ส่ง</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

</body>

</html>
