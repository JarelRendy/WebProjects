<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = htmlspecialchars(trim($_POST["user_input"]));

    if (empty($input)) {
        echo "Please enter a valid email, phone, or username.";
    } else {
        // Simulated response
        echo "If we found a matching account for \"$input\", a reset link has been sent.";
    }
} else {
    echo "Invalid request.";
}
?>
