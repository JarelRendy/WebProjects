<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user["password"])) {
            $_SESSION["user"] = $user["email"];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>




<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <div class="login-wrapper">
        <div class="login-box">
            <div class="logo-top">
    <img src="log.png.png" alt="Logo">
</div>

            <h2>Login to your account</h2>
            <form method="POST" action="">
                <div class="input-group">
                    <input type="text" name="email" placeholder="Student/Email ID" required>
                </div>
                <div class="input-group password-container">
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    <span class="toggle-password" onclick="togglePassword()" id="toggleText">Show</span>
                </div>
                <div class="remember-forgot">
                    <label><input type="checkbox"> Remember Me</label>
                    <a href="#">Forgot your password?</a>
                </div>
                <button type="submit">Login</button>

                <?php
                if (isset($error)) {
                    echo "<p class='error'>$error</p>";
                }
                ?>
            </form>
            <div class="bottom-links">
                <p>Don't have an account? <a href="register.php">Create an account</a></p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const pwd = document.getElementById("password");
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
