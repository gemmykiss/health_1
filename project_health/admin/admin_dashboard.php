<?php
require_once '../config/db.php';
session_start();

$medicalHistoryCount = 0;

// ดึงจำนวนคนทั้งหมด
$sqlUserCount = "SELECT COUNT(*) AS total FROM user";
$resultUserCount = $conn->query($sqlUserCount);
$rowUserCount = $resultUserCount->fetch(PDO::FETCH_ASSOC);
$totalUsers = $rowUserCount['total'];

// ดึงจำนวนคนที่ตรวจแล้ว
$sqlCheckedCount = "SELECT COUNT(DISTINCT user_id) AS checked FROM user_checkup";
$resultCheckedCount = $conn->query($sqlCheckedCount);
$rowCheckedCount = $resultCheckedCount->fetch(PDO::FETCH_ASSOC);
$checkedUsers = $rowCheckedCount['checked'];


// การบันทึกชุดตรวจสุภาพของผู้ใช้งาน
$sqlSetTestCount = "SELECT user_id, COUNT(DISTINCT user_id) AS set_test_count FROM user_checkup ";
$resultSetTestCount = $conn->query($sqlSetTestCount);
$rowSetTestCount = $resultSetTestCount->fetch(PDO::FETCH_ASSOC);
$setTestCount = $rowSetTestCount['set_test_count'];



// คิวรีเพื่อนับจำนวนผู้ใช้ที่มีการอัพเดทข้อมูล
$sqlUpdateCount = "SELECT COUNT(DISTINCT user_id) AS updated_count FROM general_info";
$resultUpdateCount = $conn->query($sqlUpdateCount);
$rowUpdateCount = $resultUpdateCount->fetch(PDO::FETCH_ASSOC);
$updatedUserCount = $rowUpdateCount['updated_count'];


// ดึงข้อมูลจำนวน user ที่มีข้อมูลในตาราง google_fit_steps
$sqlUsersWithSteps = "SELECT COUNT(DISTINCT user_id) AS users_with_steps FROM google_fit_steps";
$resultUsersWithSteps = $conn->query($sqlUsersWithSteps);
$rowUsersWithSteps = $resultUsersWithSteps->fetch(PDO::FETCH_ASSOC);
$usersWithSteps = $rowUsersWithSteps['users_with_steps'];




// ดึงข้อมูลการตรวจล่าสุด
$sqlLatestCheckup = "SELECT user_id, MAX(check_up_times) AS latest_checkup FROM user_checkup GROUP BY user_id";
$resultLatestCheckup = $conn->query($sqlLatestCheckup);

// เก็บข้อมูลการตรวจล่าสุดไว้ใน associative array
$latestCheckupData = array();
while ($rowLatestCheckup = $resultLatestCheckup->fetch(PDO::FETCH_ASSOC)) {
    $latestCheckupData[$rowLatestCheckup['user_id']] = $rowLatestCheckup['latest_checkup'];
}

// ดึงข้อมูลจำนวนโปรไฟล์ผู้ใช้งาน
$sqlProfileCount = "SELECT COUNT(DISTINCT user_id) AS profile_count FROM general_info";
$resultProfileCount = $conn->query($sqlProfileCount);
$rowProfileCount = $resultProfileCount->fetch(PDO::FETCH_ASSOC);
$profileCount = $rowProfileCount['profile_count'];

// ดึงข้อมูลล่าสุดจากตาราง general_info ตาม user_id
$sqlLatestInfo = "SELECT user_id, MAX(date) AS latest_date FROM general_info GROUP BY user_id";
$resultLatestInfo = $conn->query($sqlLatestInfo);

// เก็บข้อมูลล่าสุดไว้ใน associative array
$latestInfoData = array();
while ($rowLatestInfo = $resultLatestInfo->fetch(PDO::FETCH_ASSOC)) {
    $latestInfoData[$rowLatestInfo['user_id']] = $rowLatestInfo['latest_date'];
}

// กำหนดกลุ่มอายุ
$ageGroups = array(
    'young' => array('label' => 'อายุน้อยกว่า 20 ปี', 'min' => 0, 'max' => 20, 'image' => 'https://cdn-icons-png.flaticon.com/256/2179/2179285.png'),
    'middle' => array('label' => 'อายุ 20-35 ปี', 'min' => 21, 'max' => 35, 'image' => 'https://cdn-icons-png.flaticon.com/256/2019/2019724.png'),
    'middle_aged' => array('label' => 'อายุ 36-45 ปี', 'min' => 36, 'max' => 45, 'image' => 'https://cdn-icons-png.flaticon.com/256/554/554744.png'),
    'senior' => array('label' => 'อายุ 46 ปีขึ้นไป', 'min' => 46, 'max' => PHP_INT_MAX, 'image' => 'https://cdn-icons-png.flaticon.com/256/4540/4540653.png'),
);

// นับจำนวนคนในแต่ละกลุ่มอายุ
$ageCount = array('young' => 0, 'middle' => 0, 'middle_aged' => 0, 'senior' => 0);

foreach ($latestInfoData as $userId => $latestDate) {
    // ดึงข้อมูลล่าสุดของผู้ใช้
    $sqlUserInfo = "SELECT user_id, age, has_medical_history FROM general_info WHERE user_id = :user_id AND date = :latest_date";
    $stmtUserInfo = $conn->prepare($sqlUserInfo);
    $stmtUserInfo->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmtUserInfo->bindParam(':latest_date', $latestDate, PDO::PARAM_STR);
    $stmtUserInfo->execute();

    // ตรวจสอบว่ามีข้อมูลหรือไม่
    if ($rowUserInfo = $stmtUserInfo->fetch(PDO::FETCH_ASSOC)) {
        $age = $rowUserInfo['age'];
        $hasMedicalHistory = $rowUserInfo['has_medical_history'];

        // ตรวจสอบกลุ่มอายุและนับ
        foreach ($ageGroups as $groupKey => $group) {
            if ($age >= $group['min'] && $age <= $group['max']) {
                $ageCount[$groupKey]++;
                break;
            }
        }

        // ตรวจสอบว่ามีโรคประจำตัวหรือไม่
        if ($hasMedicalHistory == 1) {
            $medicalHistoryCount++;
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
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <div class="input-group">
                        <h1 class="h3 mb-0 text-gray-800">จัดการ Admin</h1>&nbsp; &nbsp;
                    </div>
                </nav>
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- เพิ่มเนื้อหาของคุณที่นี่ -->





                    <div class="row">
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow border-start-primary py-2">
                <div class="card-body">
                    <div class="row align-items-center no-gutters">
                        <div class="col me-2">
                            <div class="text-uppercase text-primary fw-bold text-xs mb-1">
                                <h3><span>จำนวนคน </span></h3>
                            </div>
                            <div class="text-dark fw-bold h5 mb-0">
                                <span><?= $totalUsers ?></span>
                            </div>
                        </div>
                        <div class="col-auto"><a href='view_user_sum.php'><i class="fas fa-user fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>



        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow border-start-success py-2">
                <div class="card-body">
                    <div class="row align-items-center no-gutters">
                        <div class="col me-2">
                            <div class="text-uppercase text-success fw-bold text-xs mb-1">
                                <h3><span>ผู้บันทึกรวม</span></h3>
                            </div>
                            <div class="text-dark fw-bold h5 mb-0">
                                <span><?= $checkedUsers ?></span>
                            </div>
                        </div>
                        <div class="col-auto"><a href=''><i class="fas fa-user-md fa-2x text-gray-300"></a></i></div>
                    </div>
                </div>
            </div>
        </div>


                    
        <div class="col-md-6 col-xl-3 mb-4">
    <div class="card shadow border-start-info py-2">
        <div class="card-body">
            <div class="row align-items-center no-gutters">
                <div class="col me-2">
                    <div class="text-uppercase text-info fw-bold text-xs mb-1">
                        <h3><span>โปรไฟล์ผู้ใช้</span></h3>
                    </div>
                    <div class="text-dark fw-bold h5 mb-0">
                        <span><?= $profileCount ?></span>
                    </div>
                </div>
                <div class="col-auto"><a href='view_user_table.php'><i class="fas fa-clipboard-list fa-2x text-gray-300"></a></i></div>
            </div>
        </div>
    </div>
</div>

                        <!-- New card to display the number of sets -->
                         <div class="col-md-6 col-xl-3 mb-4" >
            <div class="card shadow border-start-info py-2">
                <div class="card-body">
                    <div class="row align-items-center no-gutters">
                        <div class="col me-2">
                            <div class="text-uppercase text-info fw-bold text-xs mb-1">
                                <h3><span>เลขชุดตรวจ</span></h3>
                            </div>
                            <div class="text-dark fw-bold h5 mb-0">
                                <?php
                                // Query to get the count of distinct sets
                                $sqlSetCount = "SELECT COUNT(DISTINCT sect) AS set_count FROM set_test";
                                $resultSetCount = $conn->query($sqlSetCount);
                                $rowSetCount = $resultSetCount->fetch(PDO::FETCH_ASSOC);
                                $setCount = $rowSetCount['set_count'];

                                echo "<span>{$setCount}</span>";
                                ?>
                            </div>
                        </div>
                         <div class="col-auto"><a href='add_sect.php'><i class="fas fa-file fa-2x text-gray-300"></i></a></div> 
                    </div>
                    
                </div>
            </div>
        </div>
        
    </div>

    </div>

    <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- ... Topbar ... -->
                <div class="container py-4 py-xl-5">
                    <div class="row gy-4 row-cols-2 row-cols-md-4">
                        <?php
                        foreach ($ageGroups as $groupKey => $group) {
                            echo "<div class='col'>
                                    <div class='text-center d-flex flex-column justify-content-center align-items-center py-3'>
                                        <div class='bs-icon-xl bs-icon-circle bs-icon-primary d-flex flex-shrink-0 justify-content-center align-items-center d-inline-block mb-2 bs-icon lg'>
                                            <img src='{$group['image']}' width='60' height='60' />
                                        </div>
                                        <div class='px-3'>
                                            <h2 class='fw-bold mb-0'>{$ageCount[$groupKey]}</h2>
                                            <p class='mb-0'>{$group['label']}</p>
                                        </div>
                                    </div>
                                </div>";
                        }
                        ?>


                        
                        <!-- New card to display the number of people with medical history -->
                        <div class="col">
                            <a href='chronic_disease_info_user.php'>
                            <div class="card border-primary border-2">
                                <div class="card-body text-center p-4">
                                    <h6 class="text-uppercase text-muted card-subtitle">ผู้ที่มีโรคประจำตัว</h6>
                                    <h4 class="display-4 fw-bold card-title"><?= $medicalHistoryCount ?></h4>
                                </div>
                                <div class="card-footer p-4">
                                    <div>
                                        <ul class="list-unstyled">
                                            <li class="d-flex mb-2">
                                                <span class="bs-icon-xs bs-icon-rounded bs-icon-primary-light bs-icon me-2">
                                                    <svg class="bi bi-check-lg" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                                                        <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"></path>
                                                    </svg>
                                                
                                                <span>ผู้ที่มีโรคประจำตัวมีกี่คน</span>
                                            </li>
                                            </a>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>


                <div class="col">
                <a href='update_user.php'>
                    <div class="card border-primary border-2">
                        <div class="card-body text-center p-4">
                            <h6 class="text-uppercase text-muted card-subtitle">การอัพเดทผู้ใช้งาน</h6>
                            <h4 class="display-4 fw-bold card-title"><?= $updatedUserCount ?></h4>
                        </div>
                        <div class="card-footer p-4">
                            <div>
                                
                                <ul class="list-unstyled">
                                    <li class="d-flex mb-2"><span class="bs-icon-xs bs-icon-rounded bs-icon-primary-light bs-icon me-2"><svg class="bi bi-check-lg" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"></path>
                                            </svg></span><span>อัพเดทส่วนสูงน้ำหนักของผู้ใช้งานว่ามีการเปลี่ยนแปลงแค่ไหน</span></li></a>
                                    
                                </ul>
                                            </div>
                                        </div>
                                    </div>


                                </div>



                 <div class="col">
                <a href='walk_view_user.php'>
                    <div class="card border-primary border-2">
                        <div class="card-body text-center p-4">
                            <h6 class="text-uppercase text-muted card-subtitle">จำนวนการเดินของผู้ใช้งาน</h6>
                            <h4 class="display-4 fw-bold card-title"><?= $usersWithSteps ?></h4>
                        </div>
                        <div class="card-footer p-4">
                            <div>
                                
                                <ul class="list-unstyled">
                                    <li class="d-flex mb-2"><span class="bs-icon-xs bs-icon-rounded bs-icon-primary-light bs-icon me-2"><svg class="bi bi-check-lg" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"></path>
                                            </svg></span><span>ดูการเดินการใช้พลังงานของ ผู้ใช้งาน ว่ามีเท่าไหร่ต่ออาทิตย์</span></li></a>
                                    
                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    </div>

                                   <div class="col">
                <a href='view_check_user_sect.php'>
                    <div class="card border-primary border-2">
                        <div class="card-body text-center p-4">
                            <h6 class="text-uppercase text-muted card-subtitle">การบันทึกชุดตรวจสุภาพของผู้ใช้งาน</h6>
                            <h4 class="display-4 fw-bold card-title"><?=$setTestCount?></h4>
                        </div>
                        <div class="card-footer p-4">
                            <div>
                                
                                <ul class="list-unstyled">
                                    <li class="d-flex mb-2"><span class="bs-icon-xs bs-icon-rounded bs-icon-primary-light bs-icon me-2"><svg class="bi bi-check-lg" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"></path>
                                            </svg></span><span>ดูการบันทึกการตรวจสุขภาพของผู้ใช้งาน</span></li></a>
                                    
                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                        




                        
                <!-- End Chronic Disease Form -->
            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->
        </div>
        <!-- Footer -->
    
<!-- Footer -->
<?php
            include '../footer.php';
            ?>












  <!-- Bootstrap core JavaScript-->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../js/sb-admin-2.min.js"></script>


</body>
</html>
