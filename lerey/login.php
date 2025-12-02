<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "leray");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$login_error = "";

// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $contact = $conn->real_escape_string($_POST['contact']);
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE contact = '$contact'");
    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Redirect or start session
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['firstname'] = $user['firstname'];
            header("Location: dashboard.php");
            exit();
        } else {
            $login_error = "Incorrect password.";
        }
    } else {
        $login_error = "No account found with that info.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - Le'Ray</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background:white;
      background-size: cover;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', sans-serif;
    }
    .card {
      width: 100%;
      max-width: 420px;
      box-shadow: 0 0 10px rgba(0,0,0,0.2);
    }
    .card-header {
      font-size: 1.8rem;
      font-weight: bold;
      color: #333;
      border-bottom: 2px solid #D9B382;
      text-align: center;
    }
    .form-control:focus {
      box-shadow: none;
      border-color: #D9B382;
    }
    .btn-dark {
      background-color: #333;
      border: none;
    }
    .btn-dark:hover {
      background-color: #555;
    }
    .btn-social {
      border: 1px solid #ccc;
      background-color: #fff;
      color: #000;
      margin-top: 8px;
    }
    .btn-social:hover {
      background-color: #f0f0f0;
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
  <div class="card-header">Welcome Back!</div>

  <?php if ($login_error): ?>
    <div class="alert alert-danger mt-3"><?php echo $login_error; ?></div>
  <?php endif; ?>

  <form method="POST" action="">
    <div class="mb-3 mt-3">
      <label class="form-label">Username / Mobile number / Email</label>
      <input type="text" class="form-control" name="contact" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" class="form-control" name="password" required>
    </div>
    <div class="d-grid mb-2">
      <button type="submit" class="btn btn-dark">Log In</button>
    </div>
    <div class="text-center mb-3">
      <a href="#" class="text-link">Forgot account?</a> |
      <a href="register.php" class="text-link">Sign up</a>
    </div>
    <div class="d-grid">
      <button type="button" class="btn btn-social">
        <i class="bi bi-facebook me-2"></i> Continue with Facebook
      </button>
      <button type="button" class="btn btn-social">
        <i class="bi bi-google me-2"></i> Continue with Google
      </button>
    </div>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
