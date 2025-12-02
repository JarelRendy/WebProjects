<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM admins WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            $_SESSION["admin"] = $email;
            header("Location: maindashboard.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No admin account found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <div class="login-wrapper">
        <div class="login-box">
            <div class="logo-top">
                <img src="log.png.png" alt="Logo">
            </div>
            <h2>Admin Login</h2>
            <form method="POST" action="">
                <div class="input-group">
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="input-group password-container">
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    <span class="toggle-password" onclick="togglePassword()" id="toggleText">Show</span>
                </div>
                <button type="submit">Login</button>
                <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
            </form>
            <div class="bottom-links">
                <p>Don't have an account? <a href="admin_register.php">Register here</a></p>
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
