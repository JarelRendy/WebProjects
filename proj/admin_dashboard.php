<?php
session_start();
include 'db.php';

$result = $conn->query("SELECT * FROM bookings ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Booking Requests</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f1f1f1;
            padding: 20px;
        }

        .back-button {
            margin-bottom: 20px;
        }

        .back-button a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ba3c66;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background: #333;
            color: white;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        a.action {
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 6px;
            color: white;
            font-weight: bold;
        }

        .approve {
            background-color: #4caf50;
        }

        .reject {
            background-color: #f44336;
        }

        .view-doc {
            color: #ba3c66;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="back-button">
    <a href="maindashboard.php">&larr; Back</a>
</div>

<h2>📋 Meneses Campus Booking Requests</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Room</th>
        <th>Full Name</th>
        <th>Email</th>
        <th>Purpose</th>
        <th>Date</th>
        <th>Time</th>
        <th>Document</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['room']) ?></td>
        <td><?= htmlspecialchars($row['fullname']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['purpose']) ?></td>
        <td><?= $row['date'] ?></td>
        <td><?= $row['start_time'] . " - " . $row['end_time'] ?></td>
        <td>
            <?php if ($row['document'] && $row['document'] !== "N/A"): ?>
                <a href="<?= htmlspecialchars($row['document']) ?>" target="_blank" class="view-doc">View</a>
            <?php else: ?>
                N/A
            <?php endif; ?>
        </td>
        <td><?= ucfirst($row['status']) ?></td>
        <td>
            <?php if ($row['status'] === 'pending'): ?>
                <a href="approve_booking.php?id=<?= $row['id'] ?>&action=approve" class="action approve">Approve</a>
                <a href="approve_booking.php?id=<?= $row['id'] ?>&action=reject" class="action reject">Reject</a>
            <?php else: ?>
                -
            <?php endif; ?>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
