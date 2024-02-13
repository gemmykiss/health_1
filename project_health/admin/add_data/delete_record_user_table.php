<?php
require_once '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];

    $deleteQuery = "DELETE FROM `general_info` WHERE `user_id` = :user_id";
    $deleteStatement = $conn->prepare($deleteQuery);
    $deleteStatement->bindParam(':user_id', $userId, PDO::PARAM_INT);

    if ($deleteStatement->execute()) {
        echo 'success';
    } else {
        echo 'failed';
    }
} else {
    echo 'Invalid request';
}
?>
