<?php
require_once '../config/db.php';
session_start(); // Start session

if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
    // If no user session or no 'id' in the user session, redirect to login
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user']; // Use user session data

$appointmentsQuery = $conn->prepare("SELECT * FROM appointment ");
$appointmentsQuery->execute();
$appointments = $appointmentsQuery->fetchAll(PDO::FETCH_ASSOC);

// Fetch user information from general_info table
$userInfoQuery = $conn->prepare("SELECT *, CASE WHEN has_medical_history = 1 THEN 'มี' ELSE 'ไม่มี' END AS medical_history_status FROM general_info WHERE user_id = :user_id ORDER BY date DESC LIMIT 1");
$userInfoQuery->bindParam(':user_id', $user['id']);
$userInfoQuery->execute();
$userInfo = $userInfoQuery->fetch(PDO::FETCH_ASSOC);



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
        .col:hover {
            background-color: #f0f0f0; /* Hover background color */
        }

        .container-py {
            background-color: #ffffff; /* Container background color */
            padding: 2rem; /* Adjust padding as needed */
            border-radius: 10px; /* Adjust border-radius as needed */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add shadow */
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Include Header -->
        <?php include "header/header.php";
        
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
                <h1 class="h3 mb-0 text-gray-800">แบบฟอร์มบันทึกข้อโรคประจำตัว</h1>&nbsp; &nbsp;
                <h1 class="h3 mb-0 text-gray-800">สวัสดี <?php echo $user['name']; ?>!</h1> 
                &nbsp;&nbsp;&nbsp;<img class="img-fluid rounded-circle" src="<?= $user['profile_picture'] ?? 'dogs/image2.jpeg'; ?>" alt="Profile Image" style="width: 40px; height: 40px;">
                </div>

                </nav>


                
        <div class="container-fluid">
        <h3 class="text-dark mb-4">Profile</h3>
        <div class="row mb-3">
            <div class="col-lg-4">
                <div class="card mb-3">
            
                <div class="card-body text-center shadow"><img class="rounded-circle mb-3 mt-4" id="profileImagePreview" src="<?= $user['profile_picture'] ?? 'dogs/image2.jpeg'; ?>" width="250" height="225" />
                <form action="uploads/upload_profile_picture.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                 <input type="file" name="profile_picture" id="profile_picture" onchange="previewImage(this)">
                 </div>
                <div class="mb-3"> <button type="submit" class="btn btn-primary btn-sm">อัพโหลดรูป</button>
                                    </div>
                </div>
            </div>
        </div>
        
        
        
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

        
    
                <!-- End of Topbar -->
                <div class="col-lg-6 mb-4 " >
    <div class="card shadow mb-4" style="width: 610px; height: 400px;">
        <div class="card-header py-3">
            <h6 class="text-primary fw-bold m-0">ข้อมูลทั่วไป</h6>

        </div>
        <div class="container-fluid">
                    <!-- Display a message if user information is missing -->
                    <?php if (!$userInfo): ?>
                        <div class="alert alert-warning" role="alert">
                            ข้อมูลทั่วไปของคุณยังไม่ครบถ้วน กรุณา<a href="history.php">เพิ่มข้อมูล</a>ก่อนใช้งาน
                        </div>
                    <?php else: ?>
                        <!-- ... (Your existing page content) ... -->
                    <?php endif; ?>

                </div>
            
    
    <!-- ... (Your existing script imports) ... -->

        
        
    <div class="card-body">
    <?php if (!$userInfo): ?>
        <p>ไม่พบข้อมูล</p>
    <?php else: ?>
        <form>
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label class="form-label" for="username"><strong>อายุ:</strong></label>
                        <input id="username" class="form-control" type="text" placeholder="<?= $userInfo['age']; ?>" name="username" readonly />
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label class="form-label" for="email"><strong>โรคประจำตัว:</strong></label>
                        <input id="email" class="form-control" type="text" placeholder="<?= $userInfo['medical_history_status']; ?>" name="email" readonly />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label class="form-label" for="first_name"><strong>BMI ระดับ:</strong></label>
                        <input id="first_name" class="form-control" type="text" placeholder="<?= $userInfo['bmi']; ?>" name="first_name" readonly />
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label class="form-label" for="last_name"><strong>เฉลี่ยร่างกาย</strong></label>
                        <input id="last_name" class="form-control" type="text" placeholder="<?= $userInfo['bmi_category']; ?>" name="last_name" readonly />
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="mb-3">
                    <label class="form-label" for="last_name"><strong>การบันทึกล่าสุด</strong></label>
                    <input id="last_name" class="form-control" type="text" placeholder="<?= $userInfo['date']; ?>" name="last_name" readonly />
                </div>
            </div>
        </form>
    <?php endif; ?>
</div>
</div>
</div>


                &nbsp;&nbsp;
                <!-- Health Check Form -->
                    <?php if ($userInfo): ?>
                        <div class="container-py py-4 py-xl-5">
                            <div class="row mb-5">
                                <div class="col-md-8 col-xl-6 text-center mx-auto">
                                    <h2><span style="color: rgb(0, 0, 4);">บันทึกสุขภาพ</span></h2>
                                    <p class="w-lg-50"><span style="color: rgb(0, 0, 0);">ชุดตรวจสุขภาพที่มีขณะนี้</span></p>
                                </div>
                            </div>
                            <div class="row gy-4 row-cols-1 row-cols-md-2 row-cols-xl-3">
                                <?php foreach ($appointments as $appointment): ?>
                                    <?php
                                    // Check if the appointment_number is already in user_checkup for the current user
                                    $checkupExistsQuery = $conn->prepare("SELECT * FROM user_checkup WHERE user_id = :user_id AND check_up_times = :appointment_number");
                                    $checkupExistsQuery->bindParam(':user_id', $user['id']);
                                    $checkupExistsQuery->bindParam(':appointment_number', $appointment['appointment_number']);
                                    $checkupExistsQuery->execute();
                                    $checkupExists = $checkupExistsQuery->fetch(PDO::FETCH_ASSOC);

                                    // Skip displaying if the checkup exists for the user
                                    if ($checkupExists) {
                                        continue;
                                    }
                                    ?>
                                    <div class="container-py py-4 py-xl-5">
                                        <div class="row mb-3">
                                            <span class="badge rounded-pill bg-primary mb-2" style="font-size: larger; color: white;"> แจ้งเตือน </span>
                                            <h4>เอกสารตรวจเช็คสุขภาพชุดที่  &nbsp;<span style="color: rgb(0, 0, 0);"><?= $appointment['appointment_number']; ?></span></h4>
                                            <h4><span style="color: rgb(0, 0, 0);">นัดหมายเรื่อง &nbsp;<?= $appointment['topic']; ?></span></h4>
                                            <!-- Add a link or button to navigate to the health check form -->
                                            <a href="from_health_check.php?appointment_number=<?= $appointment['appointment_number']; ?>" class="btn btn-primary">กรอกบันทึกสุขภาพ</a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <!-- ... (Your existing page content) ... -->
                
            </div>
        </div>
        </div>
        <!-- ... (Your existing script imports) ... -->

        <!-- Footer -->
        <?php
            include '../footer.php';
            ?>
    
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
