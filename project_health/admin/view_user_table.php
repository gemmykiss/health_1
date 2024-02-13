<?php
require_once '../config/db.php';
session_start(); // Start session

// Query to retrieve the latest data for each user from general_info table
$query = "
    SELECT g1.*
    FROM `general_info` g1
    INNER JOIN (
        SELECT user_id, MAX(date) AS latest_date
        FROM `general_info`
        GROUP BY user_id
    ) g2 ON g1.user_id = g2.user_id AND g1.date = g2.latest_date
";
$result = $conn->query($query);

// Check if there are rows in the result
if ($result->rowCount() > 0) {
    // Fetch the data as an associative array
    $data = $result->fetchAll(PDO::FETCH_ASSOC);
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
    #dataTable {
      background-color: white;
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
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <div class="input-group">
                        <h1 class="h3 mb-0 text-gray-800">เลือกดูโปรไฟล์ผู้ใช้งาน</h1>&nbsp; &nbsp;
                    </div>
                </nav>
                <!-- End of Topbar -->

                <!-- Display data in a table -->
                <div class="container-fluid">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>อายุ</th>
                                    <th>น้ำหนัก</th>
                                    <th>ส่วนสูง</th>
                                    <th>การออกกำลังกาย</th>
                                    <th>โรคประจำตัว</th>
                                    <th>ประวัติการรักษา</th>
                                    <th>ค่า BMI</th>
                                    <th>ค่าร่างกายจาก BMI</th>
                                    <th>Dateวันที่บันทึกล่าสุด</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data as $row): ?>
                                    <tr>
                                        <td><?= $row['user_id']; ?></td>
                                        <td><?= $row['age']; ?></td>
                                        <td><?= $row['weight']; ?></td>
                                        <td><?= $row['height']; ?></td>
                                        <td><?= $row['exercise_frequency']; ?></td>
                                        <td><?= $row['health_condition']; ?></td>
                                        <td><?= $row['treatment_history']; ?></td>
                                        <td><?= $row['bmi']; ?></td>
                                        <td><?= $row['bmi_category']; ?></td>
                                        <td><?= $row['date']; ?></td>
                                        <td>
                                            <button class="btn btn-danger" onclick="deleteRow(<?= $row['user_id']; ?>)">Delete</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- End of data table -->

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
    <script>
        function deleteRow(userId) {
            if (confirm('คุณแน่ใจหรือไม่ที่ต้องการลบข้อมูลนี้?')) {
                $.ajax({
                    url: 'add_data/delete_record_user_table.php',
                    method: 'POST',
                    data: {user_id: userId},
                    success: function(response) {
                        if (response === 'success') {
                            location.reload();
                        } else {
                            alert('ล้มเหลวในการลบข้อมูล');
                        }
                    },
                    error: function() {
                        alert('เกิดข้อผิดพลาดในขณะพยายามลบข้อมูล');
                    }
                });
            }
        }
    </script>
</body>

</html>

<?php
} else {
    echo "No data found.";
}
?>
