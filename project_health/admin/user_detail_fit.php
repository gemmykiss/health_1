<?php
session_start();

require_once '../../config/db.php';

if (isset($_POST['user_id'])) {
    $userId = $_POST['user_id'];

    $query = "SELECT * FROM google_fit_steps WHERE user_id = :user_id ORDER BY id DESC";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();
    $userDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if there are any records
    if ($stmt->rowCount() > 0) {
        // Display user details
        echo "<h5>User ID: $userId</h5>";
        echo "<table class='table table-bordered'>";
        echo "<thead><tr><th>Start Time</th><th>Steps Count</th><th>Calories Burned</th></tr></thead>";
        echo "<tbody>";

        foreach ($userDetails as $detail) {
            echo "<tr>";
            echo "<td>" . $detail['start_time'] . "</td>";
            echo "<td>" . $detail['steps_count'] . "</td>";
            echo "<td>" . $detail['calories_burned'] . " kcal</td>";
            echo "</tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "ไม่พบข้อมูลสำหรับผู้ใช้นี้";
    }
} else {
    echo "Error: No user_id provided.";
}
?>
