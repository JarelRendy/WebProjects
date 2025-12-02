<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

$roomNumber = isset($_GET['room']) ? intval($_GET['room']) : 0;

$rooms = [
    ["name" => "Room 1"], ["name" => "Room 2"], ["name" => "Room 3"], ["name" => "Room 4"], ["name" => "Room 5"],
    ["name" => "Alvarado 102"], ["name" => "Room 6"], ["name" => "Science Laboratory"], ["name" => "NB1A"],
    ["name" => "NB1B"], ["name" => "NB2A"], ["name" => "NB2B"], ["name" => "Computer Laboratory 1"],
    ["name" => "CPE Laboratory 3"], ["name" => "Drawing Room"], ["name" => "Room 205A"]
];

$roomName = ($roomNumber > 0 && $roomNumber <= count($rooms)) ? $rooms[$roomNumber - 1]['name'] : null;

if (!$roomName) {
    echo "Invalid room selected.";
    exit();
}

// Get all approved bookings for this room
$stmt = $conn->prepare("SELECT date, start_time, end_time FROM bookings WHERE room = ? AND status = 'approved'");
$stmt->bind_param("s", $roomName);
$stmt->execute();
$result = $stmt->get_result();

$bookedSlots = [];
while ($row = $result->fetch_assoc()) {
    $bookedSlots[$row['date']][] = ['start' => $row['start_time'], 'end' => $row['end_time']];
}

$workingHours = ['start' => '08:00', 'end' => '17:00'];
$availableSlots = [];

for ($i = 0; $i < 7; $i++) {
    $date = date('Y-m-d', strtotime("+$i days"));
    $start = $workingHours['start'];
    $end = $workingHours['end'];
    $slots = $bookedSlots[$date] ?? [];

    // Sort bookings by start time
    usort($slots, function ($a, $b) {
        return strcmp($a['start'], $b['start']);
    });

    $current = $start;
    foreach ($slots as $slot) {
        if ($current < $slot['start']) {
            $availableSlots[$date][] = [$current, $slot['start']];
        }
        $current = max($current, $slot['end']);
    }

    if ($current < $end) {
        $availableSlots[$date][] = [$current, $end];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Available Slots - <?= htmlspecialchars($roomName) ?></title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: url('maingatecrop.png') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
        }

        .nav-buttons {
            position: fixed;
            top: 20px;
            left: 20px;
            display: flex;
            gap: 10px;
            z-index: 100;
        }

        .nav-buttons a {
            background: #e91e63;
            color: white;
            padding: 10px 14px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        }

        .container {
            max-width: 950px;
            margin: 100px auto;
            background: rgba(255, 255, 255, 0.95);
            padding: 25px;
            border-radius: 10px;
        }

        h1 {
            text-align: center;
            color: #e91e63;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #4caf50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f1f1f1;
        }

        p {
            text-align: center;
            font-size: 18px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="nav-buttons">
    <a href="room.php?room=<?= $roomNumber ?>" title="Back" style="background:#607d8b;">&lt; Back</a>
    <a href="dashboard.php">🏠 Home</a>
</div>

<div class="container">
    <h1>🟢 Available Slots for <?= htmlspecialchars($roomName) ?> (Next 7 Days)</h1>

    <?php if (!empty($availableSlots)): ?>
        <table>
            <tr>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
            </tr>
            <?php foreach ($availableSlots as $date => $slots): ?>
                <?php foreach ($slots as $slot): ?>
                    <tr>
                        <td><?= htmlspecialchars($date) ?></td>
                        <td><?= htmlspecialchars($slot[0]) ?></td>
                        <td><?= htmlspecialchars($slot[1]) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No available time slots for the next 7 days.</p>
    <?php endif; ?>
</div>

</body>
</html>
