<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO admins (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $password);

    if ($stmt->execute()) {
        header("Location: admin_login.php");
        exit();
    } else {
        $error = "Registration failed. Email might already be in use.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Register</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <div class="login-wrapper">
        <div class="login-box">
            <div class="logo-top">
                <img src="log.png.png" alt="Logo">
            </div>
            <h2>Admin Register</h2>
            <form method="POST" action="">
                <div class="input-group">
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="input-group password-container">
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    <span class="toggle-password" onclick="togglePassword()" id="toggleText">Show</span>
                </div>
                <button type="submit">Register</button>
                <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
            </form>
            <div class="bottom-links">
                <p>Already registered? <a href="admin_login.php">Login here</a></p>
            </div>
        </div>
    </div>
    <script>
        function togglePassword() {
            const pwd = document.getElementById("password");
            const toggleText = document.getElementById("toggleText");
            pwd.type = pwd.type === "password" ? "text" : "password";
            toggleText.textContent = toggleText.textContent === "Show" ? "Hide" : "Show";
        }
    </script>
</body>
</html>
