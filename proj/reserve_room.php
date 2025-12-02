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

if ($roomNumber < 1 || $roomNumber > count($rooms)) {
    echo "Invalid room selected.";
    exit();
}

$room = $rooms[$roomNumber - 1];
$email = $_SESSION['user'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reserve <?php echo htmlspecialchars($room['name']); ?></title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
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
            max-width: 700px;
            margin: 100px auto;
            background: rgba(255, 255, 255, 0.95);
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 0 12px rgba(0,0,0,0.2);
        }

        .room-image {
            width: 100%;
            border-radius: 12px;
        }

        .room-title {
            margin-top: 10px;
            font-size: 26px;
            font-weight: bold;
            text-align: center;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input, textarea, select {
            width: 98%;
            padding: 12px;
            margin-top: 5px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 15px;
            font-family: 'Segoe UI', sans-serif;
        }

        input[type="date"] {
            height: 50px;
            font-size: 16px;
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        button {
            margin-top: 20px;
            background: #4caf50;
            color: white;
            border: none;
            padding: 14px;
            font-size: 17px;
            border-radius: 8px;
            cursor: pointer;
        }

        button:hover {
            background: #45a049;
        }
    </style>
</head>
<body>

<?php $backLink = "room.php?room=" . $roomNumber; ?>
<div class="nav-buttons">
    <a href="<?= $backLink ?>" title="Back" style="background:#607d8b;"><</a>
    <a href="my_bookings.php" title="See My Bookings" style="background:#3f51b5;">📑 My Bookings</a>
    <a href="dashboard.php" title="Home">🏠 Home</a>
</div>


<div class="container">
    <img src="<?php echo $room['image']; ?>" alt="Room Image" class="room-image">
    <div class="room-title"><?php echo htmlspecialchars($room['name']); ?></div>

    <form id="bookingForm" enctype="multipart/form-data">
        <input type="hidden" name="room" value="<?php echo htmlspecialchars($room['name']); ?>">
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">

        <label>Full Name</label>
        <input type="text" name="fullname" required>

        <label>Booking Date</label>
        <input type="date" name="date" required min="<?php echo date('Y-m-d'); ?>">

        <label>Start Time</label>
        <input type="time" name="start_time" required>

        <label>End Time</label>
        <input type="time" name="end_time" required>

        <label>Purpose</label>
        <textarea name="purpose" required></textarea>

        <label>Attach Document (optional)</label>
        <input type="file" name="document" accept=".pdf,.jpg,.png,.doc,.docx">

        <button type="submit">Submit Booking</button>
    </form>
</div>

<script>
document.getElementById("bookingForm").addEventListener("submit", function(e) {
    e.preventDefault(); // prevent default submission

    const formData = new FormData(this);

    fetch('submit_booking.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        alert("Booking submitted successfully!");
        document.getElementById("bookingForm").reset();
    })
    .catch(err => {
        alert("Something went wrong.");
        console.error(err);
    });
});
</script>

</body>
</html>
