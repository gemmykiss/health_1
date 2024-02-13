<?php
require_once '../config/db.php';

session_start(); // Start session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $user_id = $_SESSION['user']['id']; // Get user_id from session
    $age = filter_var($_POST["age"], FILTER_SANITIZE_NUMBER_INT);
    $weight = filter_var($_POST["weight"], FILTER_SANITIZE_NUMBER_INT);
    $height = filter_var($_POST["height"], FILTER_SANITIZE_NUMBER_INT);
    $exercise_frequency = isset($_POST["exercise_frequency"]) ? $_POST["exercise_frequency"] : null;
    $health_condition = filter_var($_POST["health_condition"], FILTER_SANITIZE_STRING);
    $has_medical_history = isset($_POST["has_medical_history"]) ? 1 : 0;

    // Additional variable for treatment history when there is a medical history
    $treatment_history = isset($_POST["treatment_history"]) ? $_POST["treatment_history"] : null;

    // Calculate BMI
    $bmi = calculateBMI($weight, $height);

    // Determine BMI category
    $bmi_category = calculateBMICategory($bmi);

    // Determine checkup level based on age
    $checkup_level = getCheckupLevel($age);

    $gender = isset($_POST["gender"]) ? $_POST["gender"] : null;

// Create SQL statement
$sql = "INSERT INTO general_info (user_id, age, weight, height, exercise_frequency, health_condition, has_medical_history, treatment_history, bmi, bmi_category, checkup_level, gender) 
        VALUES (:user_id, :age, :weight, :height, :exercise_frequency, :health_condition, :has_medical_history, :treatment_history, :bmi, :bmi_category, :checkup_level, :gender)";

// Use prepared statement to prevent SQL injection
$stmt = $conn->prepare($sql);

// Bind parameters
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindValue(':age', $age, PDO::PARAM_INT);
$stmt->bindValue(':weight', $weight, PDO::PARAM_INT);
$stmt->bindValue(':height', $height, PDO::PARAM_INT);
$stmt->bindValue(':exercise_frequency', $exercise_frequency, PDO::PARAM_INT);
$stmt->bindValue(':health_condition', $health_condition, PDO::PARAM_STR);
$stmt->bindValue(':has_medical_history', $has_medical_history, PDO::PARAM_INT);
$stmt->bindValue(':treatment_history', $treatment_history, PDO::PARAM_STR);
$stmt->bindValue(':bmi', $bmi, PDO::PARAM_STR);
$stmt->bindValue(':bmi_category', $bmi_category, PDO::PARAM_STR);
$stmt->bindValue(':checkup_level', $checkup_level, PDO::PARAM_STR);
$stmt->bindValue(':gender', $gender, PDO::PARAM_STR);

// Execute SQL statement
$stmt->execute();

    

    // After saving the data, you can redirect or do something else
    header("Location: succ.php");
    exit();
} else {
    // If it's not a POST request, redirect
    header("Location: user_dashboard.php");
    exit();
}

// Function to calculate BMI
function calculateBMI($weight, $height)
{
    // BMI formula: weight (kg) / (height (m) * height (m))
    $heightInMeter = $height / 100; // Convert height to meters
    $bmi = $weight / ($heightInMeter * $heightInMeter);

    // Round BMI to 2 decimal places
    $bmi = round($bmi, 2);

    return $bmi;
}

// Function to determine BMI category
function calculateBMICategory($bmi)
{
    if ($bmi < 18.50) {
        return 'น้ำหนักน้อย / ผอม (มากกว่าคนปกติ)';
    } elseif ($bmi >= 18.50 && $bmi <= 22.90) {
        return 'ปกติ (สุขภาพดี)';
    } elseif ($bmi >= 23 && $bmi <= 24.90) {
        return 'ท้วม / โรคอ้วนระดับ 1';
    } elseif ($bmi >= 25 && $bmi <= 29.90) {
        return 'อ้วน / โรคอ้วนระดับ 2';
    } else {
        return 'อ้วนมาก / โรคอ้วนระดับ 3';
    }
}

// Function to get the checkup level based on age
function getCheckupLevel($age)
{
    if ($age < 20) {
        return 'basic check';
    } elseif ($age >= 21 && $age <= 35) {
        return 'advanced check';
    } elseif ($age >= 36 && $age <= 45) {
        return 'executive check';
    } else {
        return 'supreme check';
    }
}
?>
