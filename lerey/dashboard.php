<?php
// Connect to DB
$conn = new mysqli("localhost", "root", "", "leray");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Client Dashboard | Le'Ray</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      padding: 0;
      background-color: #fffdf9;
    }

    .sidebar {
      width: 200px;
      background-color: #fff;
      border-right: 2px solid #007bff;
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      text-align: center;
      padding-top: 30px;
      z-index: 10;
    }

    .sidebar .profile-icon {
      font-size: 60px;
      color: #4a3b2f;
    }

    .sidebar p {
      font-weight: bold;
      margin: 10px 0;
    }

    .sidebar a {
      display: block;
      padding: 10px;
      text-decoration: none;
      color: #000;
      font-size: 14px;
    }

    .sidebar a:hover {
      background-color: #f0f0f0;
    }

    .main-content {
      margin-left: 200px;
      padding: 20px;
    }

    .main-logo {
      text-align: center;
    }

    .main-logo img {
      max-height: 150px;
    }

    .image-grid {
      margin-top: 40px;
    }

    .image-grid .card {
      height: 200px;
      background-color: #ccc;
      border: none;
      border-radius: 8px;
    }

    .carousel-indicators {
      margin-top: 10px;
    }

    .chat-icon {
      position: fixed;
      bottom: 20px;
      right: 20px;
      font-size: 30px;
      color: #c99c00;
      cursor: pointer;
    }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <i class="bi bi-person-circle profile-icon"></i>
  <p>NAME</p>
  <a href="#"><i class="bi bi-pencil"></i> EDIT PROFILE</a>
  <a href="#"><i class="bi bi-clock-history"></i> CLIENT HISTORY</a>
  <a href="#"><i class="bi bi-calendar-check"></i> RESCHEDULE</a>
  <a href="#"><i class="bi bi-card-checklist"></i> LOYALTY PROGRESS</a>
</div>

<!-- Main Content -->
<div class="main-content">
  <!-- Navbar -->
  <nav class="d-flex justify-content-between align-items-center">
    <ul class="nav">
      <li class="nav-item"><a class="nav-link active fw-semibold" href="#">HOME</a></li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle fw-semibold" data-bs-toggle="dropdown" href="#">SERVICES</a>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="#">Facials</a></li>
          <li><a class="dropdown-item" href="#">Body Treatments</a></li>
        </ul>
      </li>
      <li class="nav-item"><a class="nav-link fw-semibold" href="#">ABOUT</a></li>
      <li class="nav-item"><a class="nav-link fw-semibold" href="#">CONTACT US</a></li>
    </ul>
    <div>
      <a href="#"><i class="bi bi-facebook px-2"></i></a>
      <a href="#"><i class="bi bi-instagram px-2"></i></a>
      <a href="#"><i class="bi bi-person px-2"></i></a>
      <a href="#" class="btn btn-outline-dark btn-sm">BOOK NOW</a>
    </div>
  </nav>

  <!-- Logo -->
  <div class="main-logo mt-4">
    <img src="assets/image/lereylogo.jpg" alt="Le'Ray Logo">
    <p>999 JP Rizal Street Concepcion I, Marikina City, Philippines</p>
  </div>

  <!-- Image Gallery Grid -->
  <div class="row row-cols-2 row-cols-md-4 g-4 image-grid">
    <div class="col"><div class="card"></div></div>
    <div class="col"><div class="card"></div></div>
    <div class="col"><div class="card"></div></div>
    <div class="col"><div class="card"></div></div>
    <div class="col"><div class="card"></div></div>
    <div class="col"><div class="card"></div></div>
  </div>

  <!-- Carousel Indicator -->
  <div class="text-center mt-4">
    <div class="carousel-indicators">
      <span class="dot">•</span>
      <span class="dot">•</span>
      <span class="dot">•</span>
      <span class="dot">•</span>
    </div>
  </div>
</div>

<!-- Chat Icon -->
<div class="chat-icon">
  <i class="bi bi-chat-dots"></i>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
