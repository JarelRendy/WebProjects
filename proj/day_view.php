<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

$roomName = $_GET['room'] ?? '';
$date = $_GET['date'] ?? '';

$conn = new mysqli("localhost", "root", "", "room_reservation");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$timeslots = [
    ["08:00:00", "11:00:00"],
    ["11:00:00", "14:00:00"],
    ["14:00:00", "17:00:00"],
    ["17:00:00", "20:00:00"]
];

$bookedSlots = [];
$sql = "SELECT start_time, end_time FROM bookings WHERE room_name = ? AND date = ? AND status = 'booked'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $roomName, $date);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $bookedSlots[] = [$row['start_time'], $row['end_time']];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $roomName; ?> - <?php echo $date; ?></title>
    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background: url('maingatecrop.png') no-repeat center center fixed;
            background-size: cover;
        }

        .container {
            max-width: 500px;
            margin: 100px auto;
            background: rgba(255, 255, 255, 0.95);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        h2 {
            color: #e91e63;
        }

        .slot {
            padding: 15px;
            margin: 10px 0;
            border-radius: 6px;
            font-size: 18px;
            background-color: #4caf50;
            color: white;
        }

        .slot.booked {
            background-color: #e53935;
        }
    </style>
</head>
<body>
<div class="container">
    <h2><?php echo $roomName; ?></h2>
    <p>Date: <?php echo $date; ?></p>
    <?php
    foreach ($timeslots as $slot) {
        $start = $slot[0];
        $end = $slot[1];
        $isBooked = false;

        foreach ($bookedSlots as $b) {
            if ($start === $b[0] && $end === $b[1]) {
                $isBooked = true;
                break;
            }
        }

        $label = date("g:i A", strtotime($start)) . " - " . date("g:i A", strtotime($end));
        $class = $isBooked ? "slot booked" : "slot";
        echo "<div class='$class'>$label</div>";
    }
    ?>
</div>
</body>
</html>
