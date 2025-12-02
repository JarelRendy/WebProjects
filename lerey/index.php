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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Le'Ray Aesthetic and Wellness Center</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="assets/css/style.css" />
  <style>
    .banner-img {
      max-height: 300px;
      object-fit: contain;
      width: auto;
    }

    .carousel-item img {
      max-height: 400px;
      object-fit: cover;
    }

    .navbar-brand img {
      height: 40px;
    }

    .nav-link {
      color: #000 !important;
      font-weight: 500;
      letter-spacing: 0.5px;
    }

    .btn-dark {
      border-radius: 50px;
      padding-left: 20px;
      padding-right: 20px;
    }

    .img-gallery img {
      max-height: 200px;
      object-fit: cover;
    }

    .img-gallery .card:hover {
      transform: scale(1.03);
      transition: transform 0.3s ease-in-out;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.15);
    }

    body {
      background-color: #fffdf9;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #fffdf9; padding: 1rem 2rem;">
  <a class="navbar-brand d-flex align-items-center" href="#">
    <img src="assets/image/lereylogo.jpg" alt="Logo">
  </a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav mx-auto text-uppercase fw-semibold">
      <li class="nav-item"><a class="nav-link px-3" href="#">Home</a></li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle px-3" href="#" data-bs-toggle="dropdown">Services</a>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="#">Facials</a></li>
          <li><a class="dropdown-item" href="#">Body Treatments</a></li>
        </ul>
      </li>
      <li class="nav-item"><a class="nav-link px-3" href="#">About</a></li>
      <li class="nav-item"><a class="nav-link px-3" href="#">Contact Us</a></li>
    </ul>

    <!-- Updated Account & Book Button -->
    <div class="d-flex align-items-center gap-2">
      <a href="#"><i class="bi bi-facebook fs-5"></i></a>
      <a href="#"><i class="bi bi-instagram fs-5"></i></a>
      <div class="dropdown">
        <a class="btn btn-outline-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
          <i class="bi bi-person-circle me-1"></i> Account
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><a class="dropdown-item" href="login.php">Login</a></li>
          <li><a class="dropdown-item" href="register.php">Create Account</a></li>
        </ul>
      </div>
      <a href="book.php" class="btn btn-dark ms-2">Book Now</a>
    </div>
  </div>
</nav>

<!-- Static Image Banner with 4 Images -->
<section class="py-5 bg-white">
  <div class="container">
    <h2 class="text-center fw-bold mb-3">Where Technology Meets Skin Wellness</h2>
    <p class="text-center text-muted mb-4">Explore our AI-enhanced services and personalized care.</p>
    <div class="row g-4" id="banner-images">
      <!-- Images will be injected here by JS -->
    </div>
    <div class="text-center mt-4">
      <a href="#ai-features" class="btn btn-warning btn-lg rounded-pill px-4">Explore Features</a>
    </div>
  </div>
</section>





<!-- AI Feature Highlights -->
<section id="ai-features" class="py-5 bg-light">
  <div class="container">
    <h2 class="text-center mb-5 fw-bold">AI-Powered Features</h2>
    <div class="row g-4 text-center">
      <div class="col-md-4">
        <div class="p-4 shadow-sm rounded bg-white h-100">
          <i class="bi bi-calendar2-check-fill fs-1 text-warning mb-3"></i>
          <h5 class="fw-semibold">AI Appointment Suggestions</h5>
          <p class="text-muted">Smart calendar insights to help patients book faster and smarter.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-4 shadow-sm rounded bg-white h-100">
          <i class="bi bi-chat-left-text-fill fs-1 text-primary mb-3"></i>
          <h5 class="fw-semibold">AI-Assisted Messaging</h5>
          <p class="text-muted">Get recommended replies to help dermatologists guide the conversation.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-4 shadow-sm rounded bg-white h-100">
          <i class="bi bi-journal-text fs-1 text-success mb-3"></i>
          <h5 class="fw-semibold">Chat Summaries</h5>
          <p class="text-muted">Auto-summarized patient sessions including symptoms and treatment notes.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-4 shadow-sm rounded bg-white h-100">
          <i class="bi bi-camera-fill fs-1 text-danger mb-3"></i>
          <h5 class="fw-semibold">My Skin Journey</h5>
          <p class="text-muted">Track and compare your skin’s progress through uploaded photos over time.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-4 shadow-sm rounded bg-white h-100">
          <i class="bi bi-newspaper fs-1 text-info mb-3"></i>
          <h5 class="fw-semibold">Personalized Health Feed</h5>
          <p class="text-muted">Articles and insights tailored to your skin type and conditions.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-4 shadow-sm rounded bg-white h-100">
          <i class="bi bi-bell-fill fs-1 text-secondary mb-3"></i>
          <h5 class="fw-semibold">Smart Reminders</h5>
          <p class="text-muted">Receive timely alerts for medications, checkups, and skincare routines.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
  .ai-section-container {
    margin-left: 96px;  /* 1 inch margin left */
    margin-right: 96px; /* 1 inch margin right */
  }

  .ai-image-wrapper {
    width: 100%;
    height: 100%;
    overflow: hidden;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .ai-image {
    object-fit: cover;
    width: 450px;
    height: 420px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.15);
  }

  @media (max-width: 500px) {
    .ai-section-container {
      margin: 20px;
    }
  }
</style>

<section class="py-5 bg-light">
  <div class="ai-section-container">
    <div class="row align-items-stretch">
      <!-- Image Column (Left Side) -->
      <div class="col-md-6 d-flex align-items-center">
        <div class="ai-image-wrapper">
          <img src="assets/image/AImain.jpg" alt="AI Dermatology" class="ai-image">
        </div>
      </div>

      <!-- Text Column (Right Side) -->
      <div class="col-md-6 d-flex flex-column justify-content-center">
        <h2 class="fw-bold mb-4">How Does Artificial Intelligence Analyze Images?</h2>
        <p class="text-muted">
          AI Dermatologist uses a deep machine learning algorithm (AI-algorithm). The human ability to learn from examples and experiences has been transferred to a computer. For this purpose, the neural network has been trained using a dermoscopic imaging database containing tens of thousands of examples that have confirmed diagnosis and assessment by dermatologists.
        </p>
        <p class="text-muted">
          The AI is able to distinguish between benign and malignant tumors, similar to the ABCDE rule (5 main signs of oncology: asymmetry, boundary, color, diameter, and change over time). The difference between them is that the algorithm can analyze thousands of features, but not only 5 of them. Of course, only a machine can detect that amount of evidence.
        </p>
        <p class="text-muted">
          Due to the productive cooperation with doctors, the quality of the algorithm performance is constantly being improved. Based on growing experience and its own autonomous rules, the AI is able to distinguish between benign and malignant tumors, find risks of human papillomavirus, and classify different types of acne…
        </p>
      </div>
    </div>
  </div>
</section>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Dermatologist</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .section-title {
            font-weight: bold;
            color: #001b75;
            margin-bottom: 20px;
        }

        .icon-box {
            text-align: center;
            padding: 20px;
        }

        .icon-box img {
            width: 50px;
            height: 50px;
            margin-bottom: 15px;
        }

        .instruction {
            text-align: center;
            padding: 20px;
        }

        .instruction img {
            height: 120px;
            margin-bottom: 15px;
        }

        .red-btn {
            background-color: #f12e2e;
            color: white;
            font-weight: bold;
            padding: 10px 30px;
            border: none;
            border-radius: 25px;
        }

        .footer-note {
            font-size: 0.8rem;
            color: #888;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Dermatologist</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .icon-box img {
            width: 50px;
            margin-bottom: 10px;
        }
        .instruction img {
            width: 80px;
            margin-bottom: 10px;
        }
        .section-title {
            font-weight: bold;
            margin-bottom: 40px;
        }
        .red-btn {
            background-color: red;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 20px;
            font-weight: bold;
            transition: 0.3s;
        }
        .red-btn:hover {
            background-color: darkred;
        }
        .footer-note {
            font-size: 0.9rem;
            color: gray;
            text-align: center;
        }
        footer {
            border-top: 1px solid #ccc;
            padding-top: 20px;
            margin-top: 60px;
            text-align: center;
            font-size: 0.9rem;
            color: #666;
        }
    </style>
</head>
<body>

    <div class="container py-5">
        <h2 class="section-title text-center">Why is AI Dermatologist worth using?</h2>
        <div class="row text-center">
            <div class="col-md-3 icon-box">
                <img src="https://img.icons8.com/fluency-systems-filled/48/artificial-intelligence.png" alt="Smart">
                <h5>Smart</h5>
                <p>AI Dermatologist is created on the basis of artificial intelligence as a result of joint work of IT specialists and doctors. Our app has the same accuracy as a professional dermatologist.</p>
            </div>
            <div class="col-md-3 icon-box">
                <img src="https://img.icons8.com/fluency-systems-filled/48/touch-id.png" alt="Simple">
                <h5>Simple</h5>
                <p>Place your phone near a mole or other formation on the skin and within 1 minute you will find out if there is cause for concern.</p>
            </div>
            <div class="col-md-3 icon-box">
                <img src="https://img.icons8.com/fluency-systems-filled/48/internet.png" alt="Accessible">
                <h5>Accessible</h5>
                <p>AI Dermatologist is available anytime, anywhere. Keep your health in check at your fingertips even when you are on the go.</p>
            </div>
            <div class="col-md-3 icon-box">
                <img src="https://img.icons8.com/fluency-systems-filled/48/money.png" alt="Affordable">
                <h5>Affordable</h5>
                <p>AI Dermatologist’s leading image analytics features come at an unbeatable price, fit for any request or budget. Flexible pricing plans and customizable bundles will save your practice both time and money.</p>
            </div>
        </div>

        <h2 class="section-title text-center mt-5">How to use AI Dermatologist?</h2>
        <div class="row text-center">
            <div class="col-md-4 instruction">
                <img src="https://img.icons8.com/ios-filled/100/camera.png" alt="Take a photo">
                <h6>Take a photo*</h6>
                <p>Keep zoomed at the closest distance (less than 10 cm), keep in focus and center only the skin mark (without hair, wrinkles and other objects).</p>
            </div>
            <div class="col-md-4 instruction">
                <img src="https://img.icons8.com/ios-filled/100/sent.png" alt="Send photo">
                <h6>Identify and send</h6>
                <p>Send your photo to the Artificial Intelligence. The system will analyze it and send you a risk assessment.</p>
            </div>
            <div class="col-md-4 instruction">
                <img src="https://img.icons8.com/ios-filled/100/ok.png" alt="Save result">
                <h6>Receive your risk assessment**</h6>
                <p>Get the result within 60 seconds and related advice on the next steps to take.</p>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="upload.html">
                <button class="red-btn">Try Now!</button>
            </a>
        </div>

        <p class="footer-note mt-4">
            * You can take a photo on your mobile phone or upload a photo from your computer.<br>
            ** You can view your results online or send them to your email address.
        </p>
    </div>

    <footer>
        <hr>
        &copy; 2025 AI Dermatologist. All rights reserved.
    </footer>

</body>
</html>


<!-- Service Gallery -->
<section class="container py-5">
  <div class="row g-4 img-gallery">
    <!-- Images will be inserted by JS -->
  </div>
</section>

<!-- Chat Icon -->
<div style="position: fixed; bottom: 20px; right: 20px;">
  <button class="btn btn-outline-warning rounded-circle p-3">
    <i class="bi bi-chat-dots fs-4"></i>
  </button>
</div>

<!-- JS & Smooth Scroll -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/script.js"></script>

<script>
// Sample image array (replace with actual paths)
const images = [
  'assets/image/lereylogo.jpg',
  'assets/image/lereylogo.jpg',
  'assets/image/lereylogo.jpg',
  'assets/image/lereylogo.jpg',
];

const container = document.querySelector('#banner-images');
images.forEach(img => {
  const col = document.createElement('div');
  col.className = 'col-lg-3 col-md-6 col-sm-6';
  col.innerHTML = `
    <div class="card border-0 shadow-sm h-100 text-center p-2">
      <img src="${img}" class="img-fluid rounded banner-img" alt="Banner Image">
    </div>
  `;
  container.appendChild(col);
});
</script>


</body>
</html>
