<?php
require_once '../config/db.php';
session_start();

// Check if user_id and sect parameters are set in the URL
if (isset($_GET['user_id']) && isset($_GET['sect'])) {
    $user_id = $_GET['user_id'];
    $sect = $_GET['sect'];

    // Fetch information about the checkup set
    $sqlCheckupSet = "SELECT id_topic, topic_sect, checkup_subject, checkup_details FROM set_test WHERE sect = :sect";
    $stmtCheckupSet = $conn->prepare($sqlCheckupSet);
    $stmtCheckupSet->bindParam(':sect', $sect);
    $stmtCheckupSet->execute();
    $checkupSetData = $stmtCheckupSet->fetch(PDO::FETCH_ASSOC);
    $stmtCheckupSet->closeCursor();

    // Fetch details about the user
    $sqlUserDetails = "SELECT uc.*, st.checkup_subject, st.checkup_details
                       FROM user_checkup uc
                       INNER JOIN set_test st ON uc.id_topic = st.id_topic
                       WHERE uc.user_id = :user_id AND uc.check_up_times = :sect";
    $stmtUserDetails = $conn->prepare($sqlUserDetails);
    $stmtUserDetails->bindParam(':user_id', $user_id);
    $stmtUserDetails->bindParam(':sect', $sect);
    $stmtUserDetails->execute();
    $userDetails = $stmtUserDetails->fetchAll(PDO::FETCH_ASSOC);
    $stmtUserDetails->closeCursor();

    // Fetch additional details about the user from general_info table
    $sqlGeneralInfo = "SELECT * FROM general_info WHERE user_id = :user_id ORDER BY id DESC LIMIT 1";
    $stmtGeneralInfo = $conn->prepare($sqlGeneralInfo);
    $stmtGeneralInfo->bindParam(':user_id', $user_id);
    $stmtGeneralInfo->execute();
    $generalInfo = $stmtGeneralInfo->fetch(PDO::FETCH_ASSOC);
    $stmtGeneralInfo->closeCursor();

    // Fetch all checkup sets related to the selected sect
    $sqlAllCheckupSets = "SELECT * FROM set_test WHERE sect = :sect";
    $stmtAllCheckupSets = $conn->prepare($sqlAllCheckupSets);
    $stmtAllCheckupSets->bindParam(':sect', $sect);
    $stmtAllCheckupSets->execute();
    $allCheckupSets = $stmtAllCheckupSets->fetchAll(PDO::FETCH_ASSOC);
    $stmtAllCheckupSets->closeCursor();

} else {
    // Redirect to an error page or handle the case when parameters are not set
    header("Location: error_page.php");
    exit();
}
?>



<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>รายละเอียดการตรวจของผู้ใช้</title>

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
                <div class="container-fluid">
                    
                    <h1 class="h3 mb-4 text-gray-800">รายละเอียดการตรวจของผู้ใช้</h1>
                    

                    

                    <?php
                    if (isset($allCheckupSets) && isset($userDetails) && isset($generalInfo)) {
                        // Display information about the user
                        echo "<div class='card mb-4'>";
                        echo "<div class='card-header'>";
                        
                        echo "<h3 class='m-0 font-weight-bold text-primary'>ข้อมูลผู้ใช้ (User ID: {$user_id})</h3>";
                        echo "<a href='generate_pdf.php?user_id={$user_id}&sect={$sect}' class='btn btn-primary'>ดาวน์โหลดเป็น PDF</a>";
                        echo "</div>";
                        echo "<div class='card-body'>";
                        echo "<p><strong>ชื่อ:</strong> {$userDetails[0]['name']}</p>";
                        echo "<p><strong>อายุ:</strong> {$generalInfo['age']}</p>";
                        echo "<p><strong>น้ำหนัก:</strong> {$generalInfo['weight']}</p>";
                        echo "<p><strong>ส่วนสูง:</strong> {$generalInfo['height']}</p>";
                        echo "<p><strong>BMI ประเภท:</strong> {$generalInfo['bmi_category']}</p>";
                        echo "</div>";
                        echo "</div>";

                        // Display all checkup sets related to the selected sect
                        echo "<div class='card mb-4'>";
                        echo "<div class='card-header'>";
                        echo "<h3 class='m-0 font-weight-bold text-primary'>ชุดตรวจหมายเลข {$sect}</h3>";
                        echo "</div>";
                        echo "<div class='card-body'>";
                        echo "<p><strong>ชื่อชุดตรวจ:</strong> {$checkupSetData['topic_sect']}</p>";
                        echo "<table class='table table-bordered'>";
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>จำนวน</th>";
                        echo "<th>หัวข้อการตรวจ</th>";
                        echo "<th>รายละเอียดการตรวจ</th>";
                        echo "<th>การตรวจ</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";

                        // Counter variable
                        $counter = 1;

                        foreach ($allCheckupSets as $checkupSet) {
                            echo "<tr>";
                            echo "<td>{$counter}</td>";
                            echo "<td>{$checkupSet['checkup_subject']}</td>";
                            echo "<td>{$checkupSet['checkup_details']}</td>";

                            // Check if the user has done this checkup
                            $isChecked = false;

                            foreach ($userDetails as $userCheckup) {
                                if ($checkupSet['id_topic'] == $userCheckup['id_topic'] &&
                                    $checkupSet['checkup_subject'] == $userCheckup['checkup_subject'] &&
                                    $checkupSet['checkup_details'] == $userCheckup['checkup_details']) {
                                    $isChecked = true;
                                    break;  // No need to continue checking once a match is found
                                }
                            }

                            // Display checkmark based on the condition
                            echo "<td>" . ($isChecked ? "<i class='fas fa-check'></i>" : "") . "</td>";

                            echo "</tr>";

                            // Increment the counter
                            $counter++;
                        }

                        echo "</tbody>";
                        echo "</table>";
                        echo "</div>";
                        echo "</div>";
                    } else {
                        echo "<p class='text-danger'>ไม่พบข้อมูลรายละเอียด</p>";
                    }
                    ?>
                </div>
            </div>
            <?php
            include '../footer.php';
            ?>
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
