<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

include 'db.php';
$userEmail = $_SESSION['user'];

// Fetch approved bookings for calendar
$approvedQuery = "SELECT * FROM bookings WHERE email = '$userEmail' AND status = 'approved' ORDER BY date, start_time";
$approvedResult = $conn->query($approvedQuery);

$approvedEvents = [];
if ($approvedResult && $approvedResult->num_rows > 0) {
    while ($row = $approvedResult->fetch_assoc()) {
        $approvedEvents[] = [
            'title' => htmlspecialchars($row['room']),
            'start' => $row['date'] . 'T' . $row['start_time'],
            'end'   => $row['date'] . 'T' . $row['end_time'],
            'description' => htmlspecialchars($row['purpose']),
        ];
    }
}

// Fetch pending and rejected bookings
$othersResult = $conn->query("SELECT * FROM bookings WHERE email = '$userEmail' AND status != 'approved' ORDER BY id DESC");
$othersBookings = [];
if ($othersResult && $othersResult->num_rows > 0) {
    while ($row = $othersResult->fetch_assoc()) {
        $othersBookings[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('maingatecrop.png') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding-top: 40px;
            overflow-x: hidden;
        }

        .main-container {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-start;
            justify-content: center;
            gap: 20px;
            padding: 20px;
            margin-left: 30px;
        }

        .back-btn {
            background: #ba3c66;
            color: white;
            padding: 10px 16px;
            text-decoration: none;
            border-radius: 8px;
            height: fit-content;
        }

        h2 {
            text-align: center;
            color: #fff;
            text-shadow: 1px 1px 2px #000;
        }

        #calendar {
            background: rgba(255, 255, 255, 0.95);
            padding: 16px;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.2);
            max-width: 850px;
            flex: 2;
            min-width: 300px;
        }

        .side-panel {
            background: rgba(255, 255, 255, 0.95);
            padding: 16px;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.2);
            max-width: 350px;
            flex: 1;
            min-width: 280px;
            height: fit-content;
        }

        .side-panel h3 {
            margin-top: 0;
            color: #ba3c66;
        }

        .booking-entry {
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid #ddd;
        }

        .status {
            font-weight: bold;
            text-transform: capitalize;
        }

        .status.pending { color: orange; }
        .status.rejected { color: red; }

        .fc-event {
            background-color: #ba3c66 !important;
            color: white !important;
            border: none;
        }

        .fc-button {
            background-color: #ba3c66 !important;
            color: white !important;
            border: none;
        }

        .fc-button:hover {
            background-color: #a03058 !important;
        }

        .fc-toolbar-title {
            color: #ba3c66;
        }

        .fc-daygrid-day-number,
        .fc-col-header-cell-cushion {
            color: #ba3c66;
        }

        @media (max-width: 900px) {
            .main-container {
                flex-direction: column;
                align-items: center;
            }

            #calendar, .side-panel, .back-btn {
                width: 95%;
            }
        }
    </style>

    <script>
        const approvedEvents = <?= json_encode($approvedEvents); ?>;
    </script>
</head>
<body>

<div class="main-container">
    <a href="dashboard.php" class="back-btn">← Back</a>

    <div id="calendar"></div>

    <div class="side-panel">
        <h3>Pending & Rejected</h3>
        <?php if (count($othersBookings) > 0): ?>
            <?php foreach ($othersBookings as $row): ?>
                <div class="booking-entry">
                    <strong><?= htmlspecialchars($row['room']) ?></strong><br>
                    <?= date("M j, Y", strtotime($row['date'])) ?><br>
                    <?= date("g:i A", strtotime($row['start_time'])) . ' - ' . date("g:i A", strtotime($row['end_time'])) ?><br>
                    Purpose: <?= htmlspecialchars($row['purpose']) ?><br>
                    <span class="status <?= strtolower($row['status']) ?>"><?= htmlspecialchars($row['status']) ?></span><br>
                    <?php if ($row['document'] && $row['document'] !== 'N/A'): ?>
                        <a href="<?= htmlspecialchars($row['document']) ?>" target="_blank">View Document</a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No pending or rejected bookings.</p>
        <?php endif; ?>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('calendar');

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            headerToolbar: {
                left: 'prev,today,next',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: approvedEvents.map(e => ({
                title: `${e.title}`,
                start: e.start,
                end: e.end,
                extendedProps: {
                    description: e.description
                }
            })),
            eventClick: function (info) {
                alert(
                    `Room: ${info.event.title}\n` +
                    `Start: ${info.event.start.toLocaleString()}\n` +
                    `End: ${info.event.end.toLocaleString()}\n` +
                    `Purpose: ${info.event.extendedProps.description}`
                );
            }
        });

        calendar.render();
    });
</script>

</body>
</html>
