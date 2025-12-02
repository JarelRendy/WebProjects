<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Fetch all approved bookings
$query = "SELECT * FROM bookings WHERE status = 'approved' ORDER BY room, date, start_time";
$result = $conn->query($query);

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
    <title>All Room Bookings Schedule</title>

    <!-- FullCalendar CSS & JS -->
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
        }

        #calendar {
            max-width: 800px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 12px;
            padding: 16px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 1000px) {
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

        .fc-daygrid-day-number,
        .fc-col-header-cell-cushion {
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
</div>



<div id="calendar"></div>

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
                    description: e.description,
                    room: e.room
                }
            })),
            eventClick: function (info) {
                alert(
                    `Booked by: ${info.event.title}\n` +
                    `Start: ${info.event.start.toLocaleString()}\n` +
                    `End: ${info.event.end.toLocaleString()}\n` +
                    `Room: ${info.event.extendedProps.room}\n` +
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
