<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "leray");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$success = "";
$error = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $conn->real_escape_string($_POST['firstname']);
    $lastname = $conn->real_escape_string($_POST['lastname']);
    $contact = $conn->real_escape_string($_POST['contact']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validation
    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Check if user already exists
        $check = $conn->query("SELECT * FROM users WHERE contact = '$contact'");
        if ($check->num_rows > 0) {
            $error = "User already exists.";
        } else {
            $sql = "INSERT INTO users (firstname, lastname, contact, password) VALUES ('$firstname', '$lastname', '$contact', '$hashedPassword')";
            if ($conn->query($sql) === TRUE) {
                $success = "Account created successfully!";
            } else {
                $error = "Error: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Account - Le'Ray</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: white;
      background-size: cover;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', sans-serif;
    }
    .card {
      width: 100%;
      max-width: 450px;
      box-shadow: 0 0 10px rgba(0,0,0,0.2);
    }
    .card-header {
      font-size: 1.8rem;
      font-weight: bold;
      border-bottom: 2px solid #D9B382;
      color: #333;
    }
    .form-control:focus {
      box-shadow: none;
      border-color: #D9B382;
    }
    .btn-primary {
      background-color: #333;
      border: none;
    }
    .btn-primary:hover {
      background-color: #555;
    }
    .small-text {
      font-size: 0.75rem;
    }
    .text-link {
      color: #e29500;
      text-decoration: none;
    }
    .text-link:hover {
      text-decoration: underline;
    }
    .back-btn {
      position: absolute;
      top: 20px;
      left: 20px;
      background: #fff;
      border-radius: 5px;
      padding: 6px 10px;
      font-size: 1.5rem;
      border: 1px solid #ccc;
      cursor: pointer;
    }
  </style>
</head>
<body>

<a href="index.php" class="back-btn">
  <i class="bi bi-arrow-left"></i>
</a>

<div class="card p-4">
  <div class="card-header text-center">Create a new account</div>

  <?php if ($success): ?>
    <div class="alert alert-success mt-3"><?php echo $success; ?></div>
  <?php elseif ($error): ?>
    <div class="alert alert-danger mt-3"><?php echo $error; ?></div>
  <?php endif; ?>

  <form method="POST" action="">
    <div class="row mt-3">
      <div class="col-md-6 mb-3">
        <label class="form-label">First name</label>
        <input type="text" class="form-control" name="firstname" required>
      </div>
      <div class="col-md-6 mb-3">
        <label class="form-label">Last name</label>
        <input type="text" class="form-control" name="lastname" required>
      </div>
    </div>
    <div class="mb-3">
      <label class="form-label">Mobile number or email</label>
      <input type="text" class="form-control" name="contact" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" class="form-control" name="password" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Confirm password</label>
      <input type="password" class="form-control" name="confirm_password" required>
    </div>
    <div class="small-text text-center text-muted mb-3">
      By clicking Sign Up, you agree to our 
      <a href="#" class="text-link">Terms</a> and 
      <a href="#" class="text-link">Privacy Policy</a>.<br>
      You may receive Gmail Notification from us and can opt out any time.
    </div>
    <div class="d-grid">
      <button type="submit" class="btn btn-primary">Sign Up</button>
    </div>
    <div class="text-center mt-3">
      <a href="login.php" class="text-link">Already have an account?</a>
    </div>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
