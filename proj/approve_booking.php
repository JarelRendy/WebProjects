<?php
include 'db.php';

$id = intval($_GET['id']);
$action = $_GET['action'];

$status = ($action === 'approve') ? 'approved' : 'rejected';

$stmt = $conn->prepare("UPDATE bookings SET status = ? WHERE id = ?");
$stmt->bind_param("si", $status, $id);
$stmt->execute();

header("Location: admin_dashboard.php");
exit();
?>
