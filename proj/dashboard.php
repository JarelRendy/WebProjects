<?php
session_start();
require 'db.php';

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

$userEmail = $_SESSION["user"];
$userName = ucfirst(str_replace('@gmail.com', '', $userEmail));

// Handle AJAX POST request to update profile data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_profile') {
    // Sanitize input
    $full_name = $_POST['name'] ?? '';
    $age = $_POST['age'] ?? '';
    $department = $_POST['department'] ?? '';
    $birthday = $_POST['birthday'] ?? '';

    // Passwords
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';

    // Get existing profile picture and hashed password from DB
    $stmt = $conn->prepare("SELECT profile_pic, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $userEmail);
    $stmt->execute();
    $result = $stmt->get_result();
    $userProfile = $result->fetch_assoc();

    if (!$userProfile) {
        echo json_encode(['status' => 'error', 'message' => 'User not found.']);
        exit;
    }

    $profile_pic = $userProfile['profile_pic'] ?? '';
    $hashedPassword = $userProfile['password'];

    // Handle image upload
    if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileTmp = $_FILES['profileImage']['tmp_name'];
        $fileName = basename($_FILES['profileImage']['name']);
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        $safeName = preg_replace('/[^a-zA-Z0-9_-]/', '', pathinfo($fileName, PATHINFO_FILENAME));
        $targetFile = $uploadDir . time() . '_' . $safeName . '.' . $ext;

        if (move_uploaded_file($fileTmp, $targetFile)) {
            $profile_pic = $targetFile;
        }
    }

    // If user wants to change password, verify current password first
    if (!empty($new_password)) {
        if (empty($current_password)) {
            echo json_encode(['status' => 'error', 'message' => 'Current password is required to change password.']);
            exit;
        }
        if (!password_verify($current_password, $hashedPassword)) {
            echo json_encode(['status' => 'error', 'message' => 'Current password is incorrect.']);
            exit;
        }

        // Current password verified, hash new password
        $hashedNewPassword = password_hash($new_password, PASSWORD_DEFAULT);

        // Update profile info including new password
        $sql = "UPDATE users SET full_name = ?, age = ?, department = ?, birthday = ?, profile_pic = ?, password = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $full_name, $age, $department, $birthday, $profile_pic, $hashedNewPassword, $userEmail);
        $stmt->execute();
    } else {
        // No password change, just update profile info
        $sql = "UPDATE users SET full_name = ?, age = ?, department = ?, birthday = ?, profile_pic = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $full_name, $age, $department, $birthday, $profile_pic, $userEmail);
        $stmt->execute();
    }

    echo json_encode([
        'status' => 'success',
        'message' => 'Profile updated successfully',
        'profileImage' => $profile_pic // Send back updated image path
    ]);
    exit;
}




// Fetch user profile info from DB
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userEmail);
$stmt->execute();
$result = $stmt->get_result();
$userProfile = $result->fetch_assoc();

// Set default profile values if none found
$name = $userProfile['full_name'] ?? $userName;
$age = $userProfile['age'] ?? '';
$department = $userProfile['department'] ?? '';
$birthday = $userProfile['birthday'] ?? '';
$profileImage = $userProfile['profile_pic'] ?? "...";

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard - Room Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet" />
    <style>
        /* Minimal custom CSS */
        .hover-zoom:hover img {
            transform: scale(1.05);
            transition: transform 0.3s ease-in-out;
        }
    </style>
</head>
<body>

<!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top" style="background-color: #ba3c66;">
        <div class="container-fluid">
            <a class="navbar-brand px-5 text-uppercase" href="#"><i class="fas fa-hotel me-2"></i>Meneses Room Reservation</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            


        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
            <ul class="navbar-nav ms-auto text-uppercase custom-nav small fw-semibold">
                <li class="nav-item me-2"><a class="nav-link" href="#">Home</a></li>
                    <li class="nav-item me-2"><a class="nav-link" href="about.php">About</a></li>
                    <li class="nav-item me-2"><a class="nav-link" href="contact.php">Contact</a></li>
                    <li class="nav-item me-2">
                        <a class="nav-link" href="https://www.bulsu.edu.ph/university-calendar" target="_blank">Calendar</a>
                    </li>
            </ul>

            <!-- Profile Dropdown -->
            <div class="dropdown pe-4">
                <a
                  class="dropdown-toggle d-flex align-items-center text-white text-decoration-none"
                  href="#"
                  role="button"
                  data-bs-toggle="dropdown"
                >
                    <img src="<?= htmlspecialchars($profileImage) ?>" alt="Profile" class="rounded-circle" width="33" height="33" />
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#profileModal">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li class="dropdown-item"><a class="nav-link" href="my_bookings.php">See My Booking</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li class="dropdown-item"><a class="nav-link" href="calendar.php">All Bookings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- View Profile Modal -->
<div
    class="modal fade"
    id="profileModal"
    tabindex="-1"
    aria-labelledby="profileModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 class="modal-title w-100" id="profileModalLabel">Profile</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body" id="profileModalBody">
                <img src="<?= htmlspecialchars($profileImage) ?>" alt="Profile" class="rounded-circle mb-3" width="100" height="100" />
                <p><strong>Email:</strong> <?= htmlspecialchars($userEmail) ?></p>
                <p><strong>Name:</strong> <?= htmlspecialchars($name) ?></p>
                <p><strong>Age:</strong> <?= htmlspecialchars($age) ?></p>
                <p><strong>Department:</strong> <?= htmlspecialchars($department) ?></p>
                <p><strong>Date of Birth:</strong> <?= htmlspecialchars($birthday) ?></p>
            </div>

            <div class="modal-footer d-flex justify-content-center">
                <button
                    type="button"
                    class="btn btn-primary"
                    data-bs-target="#editProfileModal"
                    data-bs-toggle="modal"
                    data-bs-dismiss="modal"
                >
                    Edit Profile
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div
    class="modal fade"
    id="editProfileModal"
    tabindex="-1"
    aria-labelledby="editProfileModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 class="modal-title w-100" id="editProfileModalLabel">Edit Profile</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                    id="closeEditProfileModal"
                ></button>
            </div>
            <div class="modal-body">
                <form id="editProfileForm" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="profileName" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="profileName" name="name" value="<?= htmlspecialchars($name) ?>" required />
                    </div>
                    <div class="mb-3">
                        <label for="profileAge" class="form-label">Age</label>
                        <input type="number" class="form-control" id="profileAge" name="age" value="<?= htmlspecialchars($age) ?>" />
                    </div>
                    <div class="mb-3">
    <label for="editDepartment" class="form-label">Department</label>
    <select
        class="form-select"
        id="editDepartment"
        name="department"
    >
        <option value="" disabled selected>Select your department</option>
        <option value="Computer Science">Computer Science</option>
        <option value="Information Technology">Information Technology</option>
        <option value="Engineering">Engineering</option>
        <option value="Business Administration">Business Administration</option>
        <option value="Education">Education</option>
        <option value="Other">Other</option>
    </select>
</div>

                    <div class="mb-3">
                        <label for="profileBirthday" class="form-label">Birthday</label>
                        <input type="date" class="form-control" id="profileBirthday" name="birthday" value="<?= htmlspecialchars($birthday) ?>" />
                    </div>
                    <hr>
                    <hr>
                    <div class="mb-3">
                        <label for="currentPassword" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="currentPassword" name="current_password" placeholder="Enter your current password to confirm changes" />
                    </div>
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">New Password (optional)</label>
                        <input type="password" class="form-control" id="newPassword" name="new_password" placeholder="Enter new password if changing" />
                    </div>


                    <div class="mb-3">
                        <label for="profileImage" class="form-label">Upload Profile Image</label>
                        <input type="file" class="form-control" id="profileImageInput" name="profileImage" accept="image/*" />
                    </div>

                 
                     </div>
            <div class="modal-footer d-flex justify-content-between">
                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                >
                    Cancel
                </button>
                <button id="saveProfileBtn" type="submit" class="btn btn-danger">
  Save Changes
</button>

            </div>
        </form>
    </div>
</div>

</div>
 <!-- Carousel -->
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <?php 
            $carouselImages = [
                ['img' => 'maingatecrop.png', 'caption' => 'A well-equipped space for productive learning'],
                ['img' => 'maingatecrop.png', 'caption' => 'An ideal environment for creativity'],
                ['img' => 'maingatecrop.png', 'caption' => 'Comfortable and conducive for all activities']
            ];
            foreach ($carouselImages as $index => $slide): 
                $activeClass = $index === 0 ? 'active' : ''; 
            ?>
                <div class="carousel-item <?= $activeClass ?>" style="position: relative; height: 400px;">
                    <img src="<?= $slide['img'] ?>" class="d-block w-100" alt="..." style="object-fit: cover; height: 100%;">
                    <div class="carousel-caption d-flex justify-content-center align-items-center text-center" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; color: white; background-color: rgba(0, 0, 0, 0.4);">
                        <div>
                            <h1 class="display-1">ROOM RESERVATION</h1>
                            <h3 class="custom-subheader"><?= $slide['caption'] ?></h3>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
<!-- Welcome Message -->
    <div class="container text-center my-4 text-uppercase">
        <h2 class="fw-semibold">Welcome, <span style="color: #ba3c66;"><?= $userName ?></span>!</h2>
    </div>

<!-- Room Grid -->
    <div class="container pb-5">
        <div class="row g-4">
            <?php foreach ($rooms as $index => $room): ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card shadow hover-zoom">
                        <a href="room.php?room=<?= $index + 1 ?>" class="text-decoration-none text-dark">
                            <img src="<?= $room['image'] ?>" class="card-img-top" alt="<?= $room['name'] ?>" style="height: 200px; object-fit: cover;">
                            <div class="card-body text-center">
                                <h5 class="card-title fw-bold text-uppercase"><?= $room['name'] ?></h5>
                                <p class="card-text pb-3">A newly renovated, non-AC and AC classroom that comfortably accommodates 30 to 50 students.</p>
                              <a href="room.php?room=<?= $index + 1 ?>" class="btn" style="background-color: #ba3c66; color: white;">View Room</a>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

  <!-- Footer -->
<footer class="bg-dark text-white text-center pt-4 pb-2"> 
    <div class="container">
        <p>&copy; <?= date('Y'); ?> 
            <a href="#" class="text-white" style="text-decoration: underline;">
                Meneses Room Reservation Booking System
            </a>. All Rights Reserved.
        </p>
        <p>
            Bulacan State University Meneses Campus<br>
            <span id="realTime"></span><br>
            Last login: 
            <?php
            if (isset($_SESSION['last_login'])) {
                echo htmlspecialchars($_SESSION['last_login']);
            } else {
                $now = date('F j, Y \a\t h:i A');
                $_SESSION['last_login'] = $now;
                echo htmlspecialchars($now);
            }
            ?>
        </p>
    </div>
</footer>


   

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


 <script>
const saveBtn = document.getElementById('saveProfileBtn');

document.getElementById('editProfileForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    // Disable button and show spinner
    saveBtn.disabled = true;
    saveBtn.innerHTML = `
      <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
      Loading...
    `;

    const form = e.target;
    const data = new FormData(form);
    data.append('action', 'update_profile');

    // Add new_password only if filled
    const newPassword = form.new_password.value;
    if (newPassword) {
        data.append('new_password', newPassword);
    }

    try {
        const response = await fetch('<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>', {
            method: 'POST',
            body: data,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });

        const resData = await response.json();

        if (resData.status === 'success') {
            const name = form.name.value;
            const age = form.age.value;
            const dept = form.department.value;
            const birthday = form.birthday.value;
            const profileImage = resData.profileImage;

            // Update profile modal content
            document.querySelector('#profileModalBody').innerHTML = `
                <img src="${profileImage}" alt="Profile" class="rounded-circle mb-3" width="100" height="100" />
                <p><strong>Email:</strong> <?= htmlspecialchars($userEmail) ?></p>
                <p><strong>Name:</strong> ${name}</p>
                <p><strong>Age:</strong> ${age}</p>
                <p><strong>Department:</strong> ${dept}</p>
                <p><strong>Birthday:</strong> ${birthday}</p>
            `;

            // Update navbar profile image
            document.querySelectorAll('img[alt="Profile"]').forEach(img => {
                img.src = profileImage;
            });

            // Close edit profile modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('editProfileModal'));
            modal.hide();

            // Optionally: show profile view modal with updated info
            const viewModal = new bootstrap.Modal(document.getElementById('profileModal'));
            viewModal.show();

        } else {
            alert(resData.message || 'Failed to update profile.');
        }
    } catch (err) {
        console.error(err);
        alert('An error occurred while updating the profile.');
    } finally {
        // Always re-enable button and reset text
        saveBtn.disabled = false;
        saveBtn.textContent = 'Save Changes';
    }
});

// Real-time clock updater (unchanged)
function updateRealTime() {
    const now = new Date();
    const formatted = now.toLocaleString('en-US', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: true
    });
    document.getElementById('realTime').textContent = `Current time: ${formatted}`;
}
updateRealTime();
setInterval(updateRealTime, 1000);
</script>





</body>
</html>
