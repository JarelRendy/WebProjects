<?php
session_start();
include 'db.php';

// If logged in, get user data using email (from session)
if (isset($_SESSION["user"])) {
    $email = $_SESSION["user"];
    $stmt = $conn->prepare("SELECT id, email, full_name, department, birthday, age, profile_pic FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $user_id = $user['id'];
} else {
    // Default guest user
    $user = [
        'email' => 'Guest',
        'full_name' => '',
        'department' => '',
        'birthday' => '',
        'age' => '',
        'profile_pic' => ''
    ];
}

// Convert BLOB to base64 image for display
if (!empty($user['profile_pic'])) {
    $profileImageData = base64_encode($user['profile_pic']);
    $profileImageSrc = "data:image/jpeg;base64,{$profileImageData}";
} else {
    $profileImageSrc = "Icons/humanIcon.png"; // Default image if none uploaded
}

// Handle form submission (only if logged in)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($user_id)) {
    $email = $_POST['email'] ?? $user['email'];
    $full_name = $_POST['full_name'] ?? '';
    $department = $_POST['department'] ?? '';
    $birthday = $_POST['birthday'] ?? '';
    $age = intval($_POST['age'] ?? 0);

    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $update_pass = false;

    if ($password !== '' && $password === $confirm_password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $update_pass = true;
    }

    $imgData = null;
    $update_image = false;

    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
        $imgData = file_get_contents($_FILES['profile_pic']['tmp_name']);
        $update_image = true;
    }

    if ($update_image && $update_pass) {
        // Update including image and password
        $null = NULL;
        $stmtUpdate = $conn->prepare("UPDATE users SET email=?, full_name=?, department=?, birthday=?, age=?, profile_pic=?, password=? WHERE id=?");
        $stmtUpdate->bind_param("sssssbsi", $email, $full_name, $department, $birthday, $age, $null, $hashed_password, $user_id);
        $stmtUpdate->send_long_data(5, $imgData);
    } elseif ($update_image && !$update_pass) {
        // Update including image but no password
        $null = NULL;
        $stmtUpdate = $conn->prepare("UPDATE users SET email=?, full_name=?, department=?, birthday=?, age=?, profile_pic=? WHERE id=?");
        $stmtUpdate->bind_param("ssssbsi", $email, $full_name, $department, $birthday, $age, $null, $user_id);
        $stmtUpdate->send_long_data(5, $imgData);
    } elseif (!$update_image && $update_pass) {
        // Update including password but no image
        $stmtUpdate = $conn->prepare("UPDATE users SET email=?, full_name=?, department=?, birthday=?, age=?, password=? WHERE id=?");
        $stmtUpdate->bind_param("ssssssi", $email, $full_name, $department, $birthday, $age, $hashed_password, $user_id);
    } else {
        // Update without image or password
        $stmtUpdate = $conn->prepare("UPDATE users SET email=?, full_name=?, department=?, birthday=?, age=? WHERE id=?");
        $stmtUpdate->bind_param("sssssi", $email, $full_name, $department, $birthday, $age, $user_id);
    }

    $stmtUpdate->execute();
    $stmtUpdate->close();

    // Redirect to avoid form resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>My Profile</title>
<style>
    body {
        background-image: url('background/qr_background.png');
        background-size: cover;
        font-family: sans-serif;
        margin: 0;
    }
    .card {
        background: #fff;
        width: 400px;
        margin: 80px auto;
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }
    .centered-header {
        text-align: center;
        margin-bottom: 20px;
    }
    img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 4px solid #c90060;
        object-fit: cover;
    }
    h3 {
        margin-top: 10px;
        margin-bottom: 0;
    }
    .profile-info p {
        margin: 20px 0 10px 0;
        font-size: 16px;
        text-align: center;
    }
    .label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
        font-size: 18px;
    }
    .value {
        font-size: 16px;
        color: #333;
    }
    button {
        background-color: #c90060;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 20px;
        margin-top: 20px;
        cursor: pointer;
        display: block;
        width: 100%;
        font-size: 16px;
    }
    a {
        text-decoration: none;
    }
    /* Hide the edit container initially */
    #edit-container {
        display: none;
    }
    input, select {
        width: 100%;
        padding: 10px;
        margin-top: 10px;
        border-radius: 10px;
        border: 1px solid #ccc;
        font-size: 14px;
    }
    input[type="file"] {
        padding: 5px;
    }
</style>
</head>
<body>

<div class="card" id="view-container">
    <div class="centered-header">
        <img src="<?= $profileImageSrc ?>" alt="Profile Picture" />
        <h3><?= htmlspecialchars($user['email']) ?></h3>
    </div>

    <?php if (empty($user['full_name'])): ?>
        <p>Please complete your profile.</p>
    <?php else: ?>
        <div class="profile-info">
            <p><span class="label">Name:</span><span class="value"><?= htmlspecialchars($user['full_name']) ?></span></p>
            <p><span class="label">Age:</span><span class="value"><?= htmlspecialchars($user['age']) ?></span></p>
            <p><span class="label">Department:</span><span class="value"><?= htmlspecialchars($user['department']) ?></span></p>
            <p><span class="label">Birthday:</span><span class="value"><?= htmlspecialchars($user['birthday']) ?></span></p>
        </div>
    <?php endif; ?>

    <button id="edit-btn">Edit Profile</button>
</div>

<div class="card" id="edit-container">
    <h2 style="text-align:center; color:#333;">Edit Your Profile</h2>
    <form method="post" enctype="multipart/form-data" id="edit-form">
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required placeholder="Email" />
        <input type="text" name="full_name" placeholder="Full Name" value="<?= htmlspecialchars($user['full_name']) ?>" />
        <input type="text" name="department" placeholder="Department" value="<?= htmlspecialchars($user['department']) ?>" />
        <input type="date" name="birthday" value="<?= htmlspecialchars($user['birthday']) ?>" />
        <input type="number" name="age" placeholder="Age" value="<?= htmlspecialchars($user['age']) ?>" />
        <input type="password" name="password" placeholder="New Password (leave blank to keep current)" />
        <input type="password" name="confirm_password" placeholder="Confirm New Password" />
        <input type="file" name="profile_pic" accept="image/*" />
        <button type="submit">Save Changes</button>
        <button type="button" id="cancel-btn" style="background:#777; margin-top:10px;">Cancel</button>
    </form>
</div>

<script>
    const editBtn = document.getElementById('edit-btn');
    const cancelBtn = document.getElementById('cancel-btn');
    const viewContainer = document.getElementById('view-container');
    const editContainer = document.getElementById('edit-container');

    editBtn.addEventListener('click', () => {
        viewContainer.style.display = 'none';
        editContainer.style.display = 'block';
    });

    cancelBtn.addEventListener('click', () => {
        editContainer.style.display = 'none';
        viewContainer.style.display = 'block';
    });
</script>

</body>
</html>














