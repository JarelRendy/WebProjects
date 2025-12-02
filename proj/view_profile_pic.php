<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

if (!isset($_GET['id'])) {
    echo "Invalid request.";
    exit();
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT profile_pic, full_name FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "User not found.";
    exit();
}

$row = $result->fetch_assoc();
$imageData = $row['profile_pic'];
$fullName = $row['full_name'];

if (empty($imageData)) {
    echo "No profile picture available.";
    exit();
}

// Detect mime type from image binary data
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mimeType = $finfo->buffer($imageData);

// Back button link: referer or fallback
$backLink = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'users.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title><?= htmlspecialchars($fullName) ?> - Profile Picture</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('maingatecrop.png') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .nav-buttons {
            position: fixed;
            top: 20px;
            left: 20px;
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
            max-width: 600px;
            margin: 120px auto 50px;
            background: rgba(255, 255, 255, 0.95);
            padding: 25px;
            border-radius: 12px;
            text-align: center;
        }

        h1 {
            color: #ba3c66;
            margin-bottom: 25px;
        }

        img.profile-pic {
            max-width: 100%;
            height: auto;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        @media (max-width: 768px) {
            .container {
                margin: 80px 20px 50px;
                padding: 15px;
            }

            h1 {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>

<div class="nav-buttons">
    <a href="<?= htmlspecialchars($backLink) ?>">&lt; Back</a>
</div>

<div class="container">
    <h1><?= htmlspecialchars($fullName) ?>'s Profile Picture</h1>
    <img
        src="data:<?= htmlspecialchars($mimeType) ?>;base64,<?= base64_encode($imageData) ?>"
        alt="Profile Picture of <?= htmlspecialchars($fullName) ?>"
        class="profile-pic"
    >
</div>

</body>
</html>
