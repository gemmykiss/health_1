<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>ข้อมูลผู้ใช้งาน</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            padding-top: 20px;
        }

        .card {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1 class="mt-4 mb-4">ข้อมูลการเดิน7วันล่าสุด</h1>
        <?php
        // เริ่มเซสชัน
        session_start();

        // ตรวจสอบว่ามีการส่งค่า user_id มาหรือไม่
        if (isset($_POST['user_id'])) {
            // รับค่า user_id จากการ POST
            $userId = $_POST['user_id'];

            // เชื่อมต่อฐานข้อมูล
            require_once '../../config/db.php';  // แก้เป็นตามที่อยู่ของไฟล์ db.php

            // คิวรี่เพื่อดึงข้อมูลผู้ใช้งาน
            $query = "SELECT * FROM google_fit_steps WHERE user_id = :user_id ORDER BY id DESC LIMIT 7";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();
            $userDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // แสดงข้อมูลผู้ใช้งาน
            $userDetails = array_reverse($userDetails); // เรียงลำดับข้อมูลใหม่โดยกลับด้าน

            $totalSteps = 0;
            $totalCalories = 0;
        ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>วันที่</th>
                            <th>จำนวนเก้า</th>
                            <th>พลังงานที่ใช้ (Calories)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($userDetails as $detail) {
                            $totalSteps += $detail['steps_count'];
                            $totalCalories += $detail['calories_burned'];
                        ?>
                            <tr>
                                <td><?php echo $detail['user_id']; ?></td>
                                <td><?php echo $detail['start_time']; ?></td>
                                <td><?php echo $detail['steps_count']; ?></td>
                                <td><?php echo $detail['calories_burned']; ?> kcal</td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- แสดงผลรวมข้อมูล -->
            <div class='card'>
                <div class='card-body'>
                    <h5 class='card-title'>ผลรวมข้อมูลการเดิน</h5>
                    <p class='card-text'>
                        Total Steps: <?php echo $totalSteps; ?><br>
                        Total Calories Burned: <?php echo $totalCalories; ?> kcal
                    </p>
                </div>
            </div>

        <?php
        } else {
            // ถ้าไม่มี user_id ที่ส่งมา
            echo "<p class='text-danger'>Error: No user_id provided.</p>";
        }
        ?>
    </div>



    <script>
    $(document).ready(function () {
        // When the modal is hidden
        $('#userDetailsModal').on('hidden.bs.modal', function () {
            // Reload the page using AJAX
            location.reload();
        });
    });
</script>


    <!-- Bootstrap core JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>

</body>

</html>
