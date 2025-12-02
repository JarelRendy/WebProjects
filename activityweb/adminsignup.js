document.getElementById("adminSignupForm").addEventListener("submit", function (e) {
  e.preventDefault(); // Prevent form from submitting traditionally

  // Get the values
  const firstname = document.querySelector('input[name="firstname"]').value.trim();
  const lastname = document.querySelector('input[name="lastname"]').value.trim();
  const position = document.querySelector('select[name="position"]').value;
  const email = document.querySelector('input[name="email"]').value.trim();
  const phone = document.querySelector('input[name="phone"]').value.trim();
  const password = document.getElementById("password").value.trim();
  const confirmPassword = document.getElementById("confirmPassword").value.trim();

  // Simple validation
  if (!firstname || !lastname || !position || !email || !phone || !password || !confirmPassword) {
    alert("Please fill out all fields.");
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

  if (!/^\d{10,15}$/.test(phone)) {
    alert("Please enter a valid phone number (10-15 digits).");
    return;
  }

  // Success message
  alert("Admin account created successfully!");

  // Redirect to admin login page
  window.location.href = "adminlog.html";
});

// Toggle password visibility for Create Password
document.getElementById("togglePassword").addEventListener("click", function () {
  const passwordInput = document.getElementById("password");
  const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
  passwordInput.setAttribute("type", type);
});

// Toggle password visibility for Confirm Password
document.getElementById("toggleConfirmPassword").addEventListener("click", function () {
  const confirmPasswordInput = document.getElementById("confirmPassword");
  const type = confirmPasswordInput.getAttribute("type") === "password" ? "text" : "password";
  confirmPasswordInput.setAttribute("type", type);
});
