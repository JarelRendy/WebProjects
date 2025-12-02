dashboard
<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$userEmail = $_SESSION["user_email"] ?? 'user@example.com';
$userName = ucfirst(str_replace('@gmail.com', '', $userEmail));




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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Meneses Room Reservation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="dashboard.css">
    <style>
        .btn-pink {
            background-color: #ba3c66;
            color: white;
        }
        .btn-pink:hover {
            background-color: #ba3c66;
            color: white;
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
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto px-5 text-uppercase custom-nav small fw-semibold">
                    <li class="nav-item me-2"><a class="nav-link" href="#">Home</a></li>
                    <li class="nav-item me-2"><a class="nav-link" href="about.php">About</a></li>
                    <li class="nav-item me-2"><a class="nav-link" href="contact.php">Contact</a></li>
                    <li class="nav-item me-2">
                        <a class="nav-link" href="https://www.bulsu.edu.ph/university-calendar" target="_blank">Calendar</a>
                    </li>
                    <li class="nav-item me-2"><a class="nav-link" href="my_bookings.php">See My Booking</a></li>
                    <li class="nav-item me-2"><a class="nav-link" href="profile.php">Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

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
        <h2 class="fw-semibold">Welcome, <span style="color: #763435;"><?= $userName ?></span>!</h2>
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
                                <p class="card-text pb-3">Room 1 is a newly renovated, non-AC and AC classroom that comfortably accommodates 30 to 50 students.</p>
                                <a href="room.php?room=<?= $index + 1 ?>" class="btn btn-pink">View Room</a>
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
            <p>&copy; <?= date('Y'); ?> <a href="#" class="text-white" style="text-decoration: underline;">Meneses Room Reservation Booking System</a>. All Rights Reserved.</p>
            <p>Bulacan State University Meneses Campus
                realtime and date and last login time and date
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Add this inside your <body> tag, preferably before the closing </body> -->
<!-- PROFILE OVERLAY -->
<div id="profileOverlay" class="position-fixed top-0 end-0 bg-white shadow-lg" style="width: 400px; height: 100vh; z-index: 1050; transform: translateX(100%); transition: transform 0.3s;">
    <div class="p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">My Profile</h4>
            <button onclick="closeOverlay()" class="btn btn-sm btn-outline-secondary"><i class="fas fa-times"></i></button>
        </div>
        <form>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" value="<?= $userEmail ?>" class="form-control" disabled>
            </div>
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" value="<?= $userName ?>" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Department</label>
                <input type="text" class="form-control" placeholder="Enter department">
            </div>
            <div class="mb-3">
                <label class="form-label">Birthday</label>
                <input type="date" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Age</label>
                <input type="number" class="form-control" placeholder="Enter age">
            </div>
            <div class="mb-3">
                <label class="form-label">New Password</label>
                <input type="password" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Profile Picture</label>
                <input type="file" class="form-control">
            </div>
            <button type="submit" class="btn btn-pink w-100">Update Profile</button>
        </form>
    </div>
</div>

<!-- Add this script before the closing </body> -->
<script>
    function openOverlay() {
        document.getElementById('profileOverlay').style.transform = 'translateX(0)';
    }

    function closeOverlay() {
        document.getElementById('profileOverlay').style.transform = 'translateX(100%)';
    }

    // Optional: Close overlay on outside click
    document.addEventListener('click', function(event) {
        const overlay = document.getElementById('profileOverlay');
        if (!overlay.contains(event.target) && !event.target.closest('.nav-profile-link')) {
            closeOverlay();
        }
    });
</script>

</body>
</html>
