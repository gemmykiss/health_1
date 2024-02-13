<?php
require_once '../../config/db.php';

$userCountQuery = $conn->query("SELECT COUNT(id) as total FROM user");
$userCount = $userCountQuery->fetch(PDO::FETCH_ASSOC);

echo json_encode($userCount);
?>
