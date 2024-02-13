<?php
require_once '../config/db.php';


if (!isset($_SESSION['user'])) {
    // If no user session, redirect to login
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user']; // Use user session data

// Query to get user information
$userQuery = $conn->prepare("SELECT * FROM `user` WHERE id = :user_id");
$userQuery->bindParam(':user_id', $user['id']);
$userQuery->execute();
$userInfo = $userQuery->fetch(PDO::FETCH_ASSOC);

// Rest of your code...
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
    <link rel="shortcut icon" href="./image/logo.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">
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

    <?php if ($userInfo): ?>
        <h3 class="fw-bold text-dark"><?= $userInfo['name']; ?></h3>
        <!-- Add other user information as needed -->
    <?php else: ?>
        <p class="text-dark">ไม่พบข้อมูลโปรไฟล์</p>
    <?php endif; ?>
</div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>