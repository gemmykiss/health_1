<?php
require_once '../config/db.php';
session_start();

$user_id = null;

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if (isset($_SESSION['user']['id'])) {
    $user_id = $_SESSION['user']['id'];

    try {
        $stmt = $conn->prepare("SELECT id, name FROM user WHERE id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            echo "Error: ไม่พบข้อมูลผู้ใช้ในฐานข้อมูล.";
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
}

// Initialize weekly total steps and calories
$weeklyTotalSteps = 0;
$weeklyTotalCalories = 0;

if (isset($_GET['access_token'])) {
    $access_token = $_GET['access_token'];

    // Get the last recorded date for the user
    $getLastRecordedDateQuery = "SELECT MAX(end_time) AS lastRecordedDate FROM google_fit_steps WHERE user_id = :user_id";
    $stmt_getLastRecordedDate = $conn->prepare($getLastRecordedDateQuery);
    $stmt_getLastRecordedDate->bindParam(':user_id', $user_id);
    $stmt_getLastRecordedDate->execute();
    $result_lastRecordedDate = $stmt_getLastRecordedDate->fetch(PDO::FETCH_ASSOC);

    $lastRecordedDate = $result_lastRecordedDate ? $result_lastRecordedDate['lastRecordedDate'] : null;

    // Google Fit API URL
    $google_fit_steps_url = 'https://www.googleapis.com/fitness/v1/users/me/dataset:aggregate';

    // Set the start and end time for the last 7 days
    $start_time = strtotime('-7 days');
    $end_time = time();

    // Prepare the request body
    $request_body = [
        "aggregateBy" => [
            [
                "dataTypeName" => "com.google.step_count.delta",
                "dataSourceId" => "derived:com.google.step_count.delta:com.google.android.gms:estimated_steps"
            ]
        ],
        "bucketByTime" => [
            "durationMillis" => 86400000
        ],
        "startTimeMillis" => $start_time * 1000,
        "endTimeMillis" => $end_time * 1000
    ];

    // Initialize cURL session
    $curl = curl_init($google_fit_steps_url);

    // Set cURL options
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($request_body));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $access_token,
        'Content-Type: application/json'
    ]);

    // Execute cURL session
    $steps_response = curl_exec($curl);
    curl_close($curl);

    // Decode the response
    $decoded_response = json_decode($steps_response, true);

    // Check if there is already a record for the current date
    $currentDate = date("Y-m-d");

    if ($lastRecordedDate && date("Y-m-d", strtotime($lastRecordedDate)) == $currentDate) {
        echo "ข้อมูลบันทึกสำหรับวันนี้มีอยู่แล้ว";
    } else {
        // Insert data into the database
        if (isset($decoded_response['bucket'])) {
            foreach ($decoded_response['bucket'] as $bucket) {
                if (isset($bucket['dataset'][0]['point'][0]['value'][0]['intVal'])) {
                    $steps_count = $bucket['dataset'][0]['point'][0]['value'][0]['intVal'];
                    $start_time_millis = $bucket['startTimeMillis'];
                    $end_time_millis = $bucket['endTimeMillis'];

                    $start_time_readable = date("Y-m-d H:i:s", $start_time_millis / 1000);
                    $end_time_readable = date("Y-m-d H:i:s", $end_time_millis / 1000);

                    $calories_burned = $steps_count * 0.04;

                    $insert_query = "INSERT INTO google_fit_steps (user_id, steps_count, calories_burned, start_time, end_time) 
                                     VALUES (:user_id, :steps_count, :calories_burned, :start_time, :end_time)";
                    $stmt_insert = $conn->prepare($insert_query);
                    $stmt_insert->bindParam(':user_id', $user_id);
                    $stmt_insert->bindParam(':steps_count', $steps_count);
                    $stmt_insert->bindParam(':calories_burned', $calories_burned);
                    $stmt_insert->bindParam(':start_time', $start_time_readable);
                    $stmt_insert->bindParam(':end_time', $end_time_readable);
                    $result_insert = $stmt_insert->execute();

                    if (!$result_insert) {
                        echo "Error: ไม่สามารถเพิ่มข้อมูลลงในตาราง google_fit_steps ได้.";
                    }

                    $weeklyTotalSteps += $steps_count;
                    $weeklyTotalCalories += $calories_burned;
                }
            }

            echo "บันทึกข้อมูลสำเร็จ";
        } else {
            echo "ไม่พบข้อมูลการเดิน.";
        }
    }
} else {
    echo "Error: Access token is missing.";
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
            background-color: #f2f2f2; /* Change color as needed */
        }
    </style>

</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Include Header -->
        <?php include "header.php"; ?>
        <!-- Page Content -->
        <div id="content">
            <div class="container-fluid">
                <div class="input-group">
                    <h1 class="h3 mb-0 text-gray-800">แบบฟอร์มข้อมูลเดินเดินจาก Google Fit </h1>&nbsp; &nbsp;
                    <h1 class="h3 mb-0 text-gray-800">สวัสดี <?php echo $user['name']; ?>!</h1>
                </div>
                <!-- Your existing content goes here -->
                <!-- Display Step Count Data -->
                <!-- Display Calorie Data -->
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-fire"></i>
                        Google Fit Calorie Data
                    </div>
                    <div class="card-body">
                        <?php
                        // Calculate and Display Daily and Weekly Calories

                        // Initialize variables for daily and weekly total calories
                        $dailyTotalCalories = 0;
                        $weeklyTotalCalories = 0;

                        // Display Calorie Data
                        if (isset($decoded_response['bucket'])) {
                            foreach ($decoded_response['bucket'] as $bucket) {
                                if (isset($bucket['dataset'][0]['point'][0]['value'][0]['intVal'])) {
                                    $steps_count = $bucket['dataset'][0]['point'][0]['value'][0]['intVal'];

                                    // Assuming 1 step burns 0.04 calories (adjust as needed based on your calculation)
                                    $calories_burned = $steps_count * 0.04;

                                    $start_time_millis = $bucket['startTimeMillis'];
                                    $end_time_millis = $bucket['endTimeMillis'];

                                    $start_time_readable = date("Y-m-d H:i:s", $start_time_millis / 1000);
                                    $end_time_readable = date("Y-m-d H:i:s", $end_time_millis / 1000);

                                    echo "วันที่: $start_time_readable - $end_time_readable, จำนวนก้าว: $steps_count, แคลอรี่ที่ได้รับ: $calories_burned กิโลแคลอรี่<br>";

                                    // Update daily and weekly total calories
                                    $dailyTotalCalories += $calories_burned;
                                    $weeklyTotalCalories += $calories_burned;
                                }
                            }

                            // Display daily and weekly total calories
                            echo "<br>Weekly Total Steps: $weeklyTotalSteps ก้าว<br>";
                            echo "Weekly Total Calories: $weeklyTotalCalories กิโลแคลอรี่";
                           
                        } else {
                            echo "ไม่พบข้อมูลการเดิน.";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap core JavaScript -->
        <script src="../vendor/jquery/jquery.min.js"></script>
        <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- Core plugin JavaScript -->
        <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
        <!-- Custom scripts for all pages -->
        <script src="../js/sb-admin-2.min.js"></script>
    </body>
</html>
