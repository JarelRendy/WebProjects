<?php
$conn = new mysqli("localhost", "root", "", "leray");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $conn->prepare("INSERT INTO bookings (name, email, phone, service, booking_date, message) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $_POST["name"], $_POST["email"], $_POST["phone"], $_POST["service"], $_POST["date"], $_POST["message"]);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('Booking successful!'); window.location='index.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Book Now</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="p-5">

<h2>Book an Appointment</h2>

<form method="post" class="row g-3">
  <div class="col-md-6">
    <input type="text" name="name" class="form-control" placeholder="Full Name" required>
  </div>
  <div class="col-md-6">
    <input type="email" name="email" class="form-control" placeholder="Email" required>
  </div>
  <div class="col-md-6">
    <input type="text" name="phone" class="form-control" placeholder="Phone" required>
  </div>
  <div class="col-md-6">
    <select name="service" class="form-select">
      <option selected disabled>Choose Service</option>
      <option value="Facial">Facial</option>
      <option value="Body Treatment">Body Treatment</option>
    </select>
  </div>
  <div class="col-md-6">
    <input type="date" name="date" class="form-control" required>
  </div>
  <div class="col-md-12">
    <textarea name="message" class="form-control" placeholder="Message (optional)"></textarea>
  </div>
  <div class="col-12">
    <button type="submit" class="btn btn-primary">Book Now</button>
  </div>
</form>

</body>
</html>
