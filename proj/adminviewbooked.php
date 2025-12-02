<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: index.php"); // redirect to login if not admin
    exit();
}

include 'db.php';

$query = "SELECT * FROM bookings WHERE status = 'approved' ORDER BY date, start_time";
$result = $conn->query($query);

$backLink = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'admin_dashboard.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Approved Bookings</title>
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
            background: #ba3c66;
            color: white;
            padding: 10px 14px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        }

        .container {
            max-width: 1000px;
            margin: 100px auto 50px;
            background: rgba(255, 255, 255, 0.95);
            padding: 25px;
            border-radius: 12px;
            overflow-x: auto;
        }

        h1 {
            text-align: center;
            color: #ba3c66;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            table-layout: fixed;
            word-wrap: break-word;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
            vertical-align: middle;
        }

        th {
            background-color: #ba3c66;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        a.document-link {
            color: #ba3c66;
            text-decoration: none;
            font-weight: bold;
        }

        a.document-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .container {
                margin: 120px 20px 50px;
                padding: 15px;
            }

            table, th, td {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<div class="nav-buttons">
    <a href="<?= htmlspecialchars($backLink) ?>" title="Back" style="background:#607d8b;">&lt; Back</a>
    
</div>

<div class="container">
    <h1>✅ All Approved Bookings</h1>

    <table>
        <tr>
            <th>Room</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Date</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Purpose</th>
            <th>Document</th>
        </tr>

        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['room']) ?></td>
                    <td><?= htmlspecialchars($row['fullname']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['date']) ?></td>
                    <td><?= htmlspecialchars($row['start_time']) ?></td>
                    <td><?= htmlspecialchars($row['end_time']) ?></td>
                    <td><?= htmlspecialchars($row['purpose']) ?></td>
                    <td>
                        <?php 
                        if (!empty($row['document']) && strtolower($row['document']) !== 'n/a'): ?>
                            <a href="<?= htmlspecialchars($row['document']) ?>" target="_blank" class="document-link">View Document</a>
                        <?php else: ?>
                            No document
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="8">No approved bookings found.</td>
            </tr>
        <?php endif; ?>
    </table>
</div>

</body>
</html>
