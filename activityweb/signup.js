document.getElementById("signupForm").addEventListener("submit", function (e) {
  e.preventDefault(); // Stop form from submitting traditionally

  const email = document.querySelector('input[name="email"]').value;
  const name = document.querySelector('input[name="name"]').value;
  const password = document.querySelector('input[name="password"]').value;
  const confirmPassword = document.querySelector('input[name="confirmPassword"]').value;

  // Simple validation
  if (!email || !name || !password || !confirmPassword) {
    alert("Please fill in all fields.");
    return;
  }

  if (password.length < 6) {
    alert("Password must be at least 6 characters.");
    return;
  }

  if (password !== confirmPassword) {
    alert("Passwords do not match.");
    return;
  }

  // Simulate successful signup (you can replace this with backend call)
  alert("Signup successful! Redirecting to login...");
  window.location.href = "log.html";
});

// Toggle the visibility of the password fields
document.getElementById("togglePassword").addEventListener("click", function () {
  const passwordField = document.getElementById("password");
  const icon = document.getElementById("togglePassword");

  if (passwordField.type === "password") {
    passwordField.type = "text";
    icon.innerHTML = "&#128065;"; // Change icon to open eye
  } else {
    passwordField.type = "password";
    icon.innerHTML = "&#128065;"; // Change icon to closed eye
  }
});

document.getElementById("toggleConfirmPassword").addEventListener("click", function () {
  const confirmPasswordField = document.getElementById("confirmPassword");
  const icon = document.getElementById("toggleConfirmPassword");

  if (confirmPasswordField.type === "password") {
    confirmPasswordField.type = "text";
    icon.innerHTML = "&#128065;"; // Change icon to open eye
  } else {
    confirmPasswordField.type = "password";
    icon.innerHTML = "&#128065;"; // Change icon to closed eye
  }
});
