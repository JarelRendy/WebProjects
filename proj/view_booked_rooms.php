<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

$roomNumber = isset($_GET['room']) ? intval($_GET['room']) : 0;

$rooms = [
    ["name" => "Room 1", "image" => "room1.jpg"],
    ["name" => "Room 2", "image" => "room2.jpg"],
    ["name" => "Room 3", "image" => "room3.jpg"],
    ["name" => "Room 4", "image" => "room4.jpg"],
    ["name" => "Room 5", "image" => "room5.jpg"],
    ["name" => "Alvarado 102", "image" => "alvarado.jpg"],
    ["name" => "Room 6", "image" => "room6.jpg"],
    ["name" => "Science Laboratory", "image" => "science.jpg"],
    ["name" => "NB1A", "image" => "nb1a.jpg"],
    ["name" => "NB1B", "image" => "nb1b.jpg"],
    ["name" => "NB2A", "image" => "nb2a.jpg"],
    ["name" => "NB2B", "image" => "comlab2.jpg"],
    ["name" => "Computer Laboratory 1", "image" => "comlab1.jpg"],
    ["name" => "CPE Laboratory 3", "image" => "cpe.jpg"],
    ["name" => "Drawing Room", "image" => "drawingroom.jpg"],
    ["name" => "Room 205A", "image" => "room205a.jpg"]
];

$roomName = ($roomNumber > 0 && $roomNumber <= count($rooms)) ? $rooms[$roomNumber - 1]['name'] : null;

if ($roomName) {
    $stmt = $conn->prepare("SELECT * FROM bookings WHERE room = ? AND status = 'approved' ORDER BY date, start_time");
    $stmt->bind_param("s", $roomName);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $query = "SELECT * FROM bookings WHERE status = 'approved' ORDER BY date, start_time";
    $result = $conn->query($query);
}

$events = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = [
            'title' => htmlspecialchars($row['fullname']),
            'start' => $row['date'] . 'T' . $row['start_time'],
            'end'   => $row['date'] . 'T' . $row['end_time'],
            'description' => htmlspecialchars($row['purpose']),
            'email' => htmlspecialchars($row['email']),
            'room' => htmlspecialchars($row['room']),
        ];
    }
}

$backLink = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'dashboard.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $roomName ? htmlspecialchars($roomName) . " " : "Schedule Page" ?></title>

    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: url('maingatecrop.png') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            color: #222;
            min-height: 100vh;
        }

        .nav-buttons {
            position: fixed;
            top: 20px;
            left: 20px;
            display: flex;
            gap: 10px;
            z-index: 1000;
        }

        .nav-buttons a {
            background: #ba3c66;
            color: white;
            padding: 8px 12px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        h1 {
            text-align: center;
            color: #ba3c66;
            padding: 16px;
            margin: 0;
            font-size: 24px;
            letter-spacing: 1px;
            /* Removed background-color */
        }

        #calendar {
            max-width: 800px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 12px;
            padding: 16px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
        }

        #eventList {
            background-color: #fff0f5;
            max-width: 300px;
            padding: 16px;
            border-radius: 10px;
            position: absolute;
            top: 100px;
            right: 30px;
            font-size: 15px;
            box-shadow: 0 0 10px rgba(255, 105, 180, 0.2);
            color: #222;
        }

        #eventList strong {
            font-size: 18px;
            color: #ba3c66;
            display: block;
            margin-bottom: 10px;
        }

        #eventList ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        #eventList li {
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 2px solid #ba3c66; /* Solid pink line */
        }

        @media (max-width: 1000px) {
            #eventList {
                position: static;
                max-width: 95%;
                margin: 20px auto;
            }

            #calendar {
                width: 95%;
            }
        }

        .fc {
            background-color: #ffffff;
            color: #222;
        }

        .fc-toolbar-title {
            color: #ba3c66;
        }

        .fc-daygrid-day-number, .fc-col-header-cell-cushion {
            color: #ba3c66;
        }

        .fc-event {
            background-color: #ba3c66 !important;
            border: none;
            color: white !important;
        }

        .fc-button {
            background-color: #ba3c66 !important;
            border: none;
            color: white !important;
        }

        .fc-button:hover {
            background-color: #ba3c66 !important;
        }
    </style>

    <script>
        const events = <?= json_encode($events); ?>;
    </script>
</head>
<body>

<div class="nav-buttons">
    <a href="<?= htmlspecialchars($backLink) ?>">&lt; Back</a>
    <a href="my_bookings.php">📑 My Bookings</a>
    <a href="dashboard.php">🏠 Home</a>
</div>

<h1><?= $roomName ? htmlspecialchars($roomName) . " " : "Schedule Page" ?></h1>

<div id="calendar"></div>

<div id="eventList">
    <strong>Schedule</strong>
    <ul>
        <?php foreach ($events as $ev): ?>
            <li>
                <?= $ev['email'] ?>: <?= date("M j, Y", strtotime($ev['start'])) ?> <?= date("g:i A", strtotime($ev['start'])) ?> - <?= date("g:i A", strtotime($ev['end'])) ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('calendar');

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            headerToolbar: {
                left: 'prev today next',
                center: 'title',
                right: 'dayGridMonth timeGridWeek timeGridDay'
            },
            events: events.map(e => ({
                title: `${e.title} (${e.room})`,
                start: e.start,
                end: e.end,
                extendedProps: {
                    email: e.email,
                    description: e.description
                }
            })),
            eventClick: function (info) {
                alert(
                    `Booked by: ${info.event.title}\n` +
                    `Start: ${info.event.start.toLocaleString()}\n` +
                    `End: ${info.event.end.toLocaleString()}\n` +
                    `Email: ${info.event.extendedProps.email}\n` +
                    `Purpose: ${info.event.extendedProps.description}`
                );
            }
        });

        calendar.render();
    });
</script>

</body>
</html>
