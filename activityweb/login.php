<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = htmlspecialchars($_POST["username"]);
  $password = htmlspecialchars($_POST["password"]);

  // Fake login logic for demo
  if ($username === "demo" && $password === "demo123") {
    echo "Login successful. Welcome, $username!";
  } else {
    echo "Invalid username or password.";
  }
} else {
  echo "Invalid request.";
}
?>
