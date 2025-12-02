<?php
session_start();
if (!isset($_SESSION["user"])) {
    echo "unauthorized";
    exit();
}

include 'db.php';

$room = $_POST['room'] ?? '';
$email = $_POST['email'] ?? '';
$fullname = $_POST['fullname'] ?? '';
$date = $_POST['date'] ?? '';
$start_time = $_POST['start_time'] ?? '';
$end_time = $_POST['end_time'] ?? '';
$purpose = $_POST['purpose'] ?? '';
$documentPath = "N/A";

// Optional: Validate fields here (check for empty or invalid values)

// ✅ Check for time conflict
$query = "
    SELECT * FROM bookings 
    WHERE room = ? AND date = ? 
    AND (
        (start_time < ? AND end_time > ?) OR
        (start_time >= ? AND start_time < ?)
    )
    AND status != 'rejected'
";

$stmt = $conn->prepare($query);
$stmt->bind_param("ssssss", $room, $date, $end_time, $start_time, $start_time, $end_time);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "conflict"; // You can return JSON here instead
    exit();
}

// ✅ Handle file upload
if (isset($_FILES['document']) && $_FILES['document']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $fileName = basename($_FILES['document']['name']);
    $fileTmp = $_FILES['document']['tmp_name'];
    $targetPath = $uploadDir . time() . '_' . $fileName;

    if (move_uploaded_file($fileTmp, $targetPath)) {
        $documentPath = $targetPath;
    }
}

// ✅ Insert booking
$insert = $conn->prepare("
    INSERT INTO bookings (room, email, fullname, date, start_time, end_time, purpose, document, status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')
");
$insert->bind_param("ssssssss", $room, $email, $fullname, $date, $start_time, $end_time, $purpose, $documentPath);

if ($insert->execute()) {
    echo "success";
} else {
    echo "error";
}
?>
