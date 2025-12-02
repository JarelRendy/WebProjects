<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $error = "Email already registered.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $password);
        if ($stmt->execute()) {
            header("Location: login.php");
            exit();
        } else {
            $error = "Registration failed.";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <link rel="stylesheet" href="login.css"> <!-- Reusing login.css -->
</head>
<body>
  <div class="login-wrapper">
    <div class="login-box">
      <div class="logo-top">
        <img src="log.png.png" alt="Logo">
      </div>

      <h2>Create your account</h2>
      <form method="POST">
        <div class="input-group">
          <input type="email" name="email" placeholder="Email Address" required>
        </div>
        <div class="input-group password-container">
          <input type="password" name="password" id="register-password" placeholder="Password" required>
          <span class="toggle-password" onclick="togglePassword()" id="toggleText">Show</span>
        </div>
        <button type="submit" class="btn">Register</button>

        <?php
        if (isset($error)) {
            echo "<p class='error'>$error</p>";
        }
        ?>
      </form>

      <div class="bottom-links">
        <p>Already have an account? <a href="login.php">Login here</a></p>
      </div>
    </div>
  </div>

  <script>
    function togglePassword() {
      const pwd = document.getElementById("register-password");
      const toggleText = document.getElementById("toggleText");
      if (pwd.type === "password") {
        pwd.type = "text";
        toggleText.textContent = "Hide";
      } else {
        pwd.type = "password";
        toggleText.textContent = "Show";
      }
    }
  </script>
</body>
</html>
