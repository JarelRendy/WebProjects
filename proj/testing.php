<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Our Room - Avson Hotel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="testing.css">
</head>
<body>

<!-- Header -->
<header class="bg-dark text-white p-3">
    <div class="container d-flex justify-content-between">
        <div><strong>Avson</strong> Hotel & Room Services</div>
        <div>+49 656 789 999 | 205 Main Road, New York</div>
    </div>
</header>

<!-- Carousel -->
<div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active" data-bs-interval="3000">
            <img src="images/maingate.png" class="d-block w-100" alt="Main Gate">
            <div class="carousel-caption d-none d-md-block text-white">
                <h5>Welcome to Avson Hotel</h5>
                <p>Enjoy luxury and comfort in every room.</p>
            </div>
        </div>
        <div class="carousel-item" data-bs-interval="3000">
            <img src="images/maingate.png" class="d-block w-100" alt="Main Gate 2">
            <div class="carousel-caption d-none d-md-block text-white">
                <h5>Experience Elegance</h5>
                <p>Top-tier services for your stay.</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="images/maingate.png" class="d-block w-100" alt="Main Gate 3">
            <div class="carousel-caption d-none d-md-block text-white">
                <h5>Stay with Confidence</h5>
                <p>We make your stay memorable.</p>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<!-- Room Grid -->
<section class="container my-5">
    <h2 class="mb-4 text-center">Available Rooms</h2>
    <div class="row">
        <?php
        $rooms = [
            ["Modern Guest Rooms", "Guest House", "$180.00"],
            ["Conference Room", "Meeting Room", "$205.00"],
            ["Deluxe Couple Room", "Guest House", "$199.00"],
            ["Study & Library Rooms", "Guest House", "$180.00"],
            ["Conference Room", "Meeting Room", "$205.00"],
            ["Deluxe Couple Room", "Guest House", "$199.00"],
            ["Study & Library Rooms", "Guest House", "$180.00"],
            ["Conference Room", "Meeting Room", "$205.00"],
            ["Deluxe Couple Room", "Guest House", "$199.00"],
        ];
        foreach ($rooms as $room) {
            echo '
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="images/maingatecrop.png" class="card-img-top" alt="Room">
                    <div class="card-body">
                        <span class="badge bg-warning text-dark mb-2">'.$room[1].'</span>
                        <h5 class="card-title">'.$room[0].'</h5>
                        <p class="card-text">3 Bed | 2 Bath | 72 m²</p>
                        <p class="card-text fw-bold text-primary">'.$room[2].'</p>
                    </div>
                </div>
            </div>';
        }
        ?>
    </div>

    <!-- Pagination -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <li class="page-item"><a class="page-link" href="#">01</a></li>
            <li class="page-item"><a class="page-link" href="#">02</a></li>
            <li class="page-item"><a class="page-link" href="#">03</a></li>
        </ul>
    </nav>
</section>

<!-- Footer -->
<footer class="bg-dark text-white p-4 text-center">
    &copy; 2025 Avson. All Rights Reserved.
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="testing.js"></script>

</body>
</html>
