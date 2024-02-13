<?php
require_once '../config/db.php';
session_start(); // เริ่ม session


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
    <link rel="shortcut icon" href="../image/logo.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        /* Custom styles */
        .modal-body .alert {
            margin-bottom: 15px;
        }

        /* Styles for the success message */
        .success-message {
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 5px;
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
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
                        <h1 class="h3 mb-0 text-gray-800">เพิ่มหัวข้อการตรวจ</h1>&nbsp; &nbsp;
                    </div>
                </nav>
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">ข้อมูลทั่วไป</h1>
                    <!-- add Modal Trigger Button -->
                    <div class="row">
                        <div class="col-md-4">
                            <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#healthCheckupModal">เพิ่มชุดตรวจ</button>
                        </div>
                    </div>
                    <!-- add Modal -->
                    <div class="modal fade" id="healthCheckupModal" tabindex="-1" role="dialog" aria-labelledby="healthCheckupModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="healthCheckupModalLabel">กรอกข้อมูลหัวข้อ</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <?php
                                    // เช็คว่ามี session success และมีค่าเป็น true หรือไม่
                                    if (isset($_SESSION['success']) && $_SESSION['success'] === true) {
                                        echo '<div class="success-message">บันทึกข้อมูลสำเร็จแล้ว</div>';
                                        // หลังจากแสดงข้อความแล้วให้ลบ session success ทิ้ง
                                        unset($_SESSION['success']);
                                    }
                                    ?>
                                    <!-- add Checkup Form -->
                                    <form action='add_data/add_itemdata.php' method="post">
                                        <div class="form-group">
                                            <label for="checkup_subject">เรื่องที่ตรวจ</label>
                                            <input type="text" class="form-control" id="checkup_subject" name="checkup_subject">
                                        </div>
                                        <div class="form-group">
                                            <label for="checkup_details">รายละเอียด</label>
                                            <input type="text" class="form-control" id="checkup_details" name="checkup_details">
                                        </div>
                                        
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                                    <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                                </div>
                                </form>



                                
                            </div>
                        </div>
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
