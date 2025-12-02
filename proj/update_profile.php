<?php
session_start();
include 'db.php';

if (!isset($_SESSION["user"])) {
    echo "unauthorized";
    exit();
}

$email = $_SESSION["user"];
$name = $_POST['name'];
$age = $_POST['age'];
$department = $_POST['department'];
$birthday = $_POST['birthday'];

$sql = "UPDATE users SET full_name=?, age=?, department=?, birthday=? WHERE email=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sisss", $name, $age, $department, $birthday, $email);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "error";
}
?>
