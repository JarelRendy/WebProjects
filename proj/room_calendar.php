<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

$roomNumber = isset($_GET['room']) ? intval($_GET['room']) : 0;

$rooms = [
    ["name" => "Room 1", "image" => "complab.jpg"],
    ["name" => "Room 2", "image" => "complab.jpg"],
    ["name" => "Room 3", "image" => "complab.jpg"],
    ["name" => "Room 4", "image" => "complab.jpg"],
    ["name" => "Room 5", "image" => "complab.jpg"],
    ["name" => "Alvarado 102", "image" => "maingate.png"],
    ["name" => "Room 6", "image" => "complab.jpg"],
    ["name" => "Science Laboratory", "image" => "maingate.png"],
    ["name" => "NB1A", "image" => "maingate.png"],
    ["name" => "NB1B", "image" => "maingate.png"],
    ["name" => "NB2A", "image" => "maingate.png"],
    ["name" => "NB2B", "image" => "maingate.png"],
    ["name" => "Computer Laboratory 1", "image" => "maingate.png"],
    ["name" => "CPE Laboratory 3", "image" => "maingate.png"],
    ["name" => "Drawing Room", "image" => "maingate.png"],
    ["name" => "Room 205A", "image" => "maingate.png"]
];

if ($roomNumber < 1 || $roomNumber > count($rooms)) {
    echo "Invalid room selected.";
    exit();
}

$room = $rooms[$roomNumber - 1];
$roomName = $room['name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $roomName; ?> - Real-Time Calendar</title>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('maingatecrop.png') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background-color: #fff;
            padding: 25px;
            border-radius: 10px;
        }

        .room-header {
            text-align: center;
        }

        .room-image {
            width: 100%;
            max-height: 300px;
            object-fit: cover;
            border-radius: 10px;
        }

        .room-name {
            font-size: 24px;
            background-color: #e91e63;
            color: white;
            padding: 10px;
            border-radius: 0 0 10px 10px;
            margin-top: -5px;
        }

        #calendar {
            margin-top: 30px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="room-header">
        <img src="<?php echo $room['image']; ?>" class="room-image" alt="Room Image">
        <div class="room-name"><?php echo $roomName; ?></div>
    </div>

    <div id='calendar'></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let calendarEl = document.getElementById('calendar');
        let calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            selectable: true,
            nowIndicator: true,
            events: {
                url: 'fetch_events.php',
                method: 'POST',
                extraParams: {
                    room_name: "<?php echo addslashes($roomName); ?>"
                },
                failure: function () {
                    alert('There was an error fetching bookings!');
                }
            },
            dateClick: function (info) {
                if (info.dateStr >= new Date().toISOString().split("T")[0]) {
                    window.location.href = 'day_view.php?room=' + encodeURIComponent("<?php echo $roomName; ?>") + '&date=' + info.dateStr;
                } else {
                    alert("You cannot book past dates.");
                }
            }
        });

        calendar.render();
    });
</script>
</body>
</html>
